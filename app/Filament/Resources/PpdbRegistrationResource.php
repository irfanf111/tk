<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PpdbRegistrationResource\Pages;
use App\Models\Registration;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;

class PpdbRegistrationResource extends Resource
{
    // ── Arahkan ke model Registration (sistem baru) ──────────────────────────
    protected static ?string $model = Registration::class;

    protected static ?string $navigationGroup       = 'Manajemen PPDB';
    protected static ?string $navigationIcon        = 'heroicon-o-document-text';
    protected static ?string $navigationLabel       = 'Pendaftar PPDB';
    protected static ?string $pluralModelLabel      = 'Pendaftar PPDB';
    protected static ?string $modelLabel            = 'Pendaftar PPDB';
    protected static ?int    $navigationSort        = 1;

    // ─────────────────────────────────────────────────────────────────────────
    // FORM — Edit status & catatan dari Admin Panel
    // ─────────────────────────────────────────────────────────────────────────

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Pendaftaran')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('id')
                            ->disabled()
                            ->dehydrated(false)
                            ->label('ID Pendaftaran'),

                        Forms\Components\Select::make('status')
                            ->label('Status')
                            ->options(Registration::statusLabels())
                            ->required(),

                        Forms\Components\Textarea::make('notes')
                            ->label('Catatan Admin')
                            ->placeholder('Isi catatan jika ada pengembalian atau keterangan khusus...')
                            ->columnSpanFull(),
                    ]),

                // ── Info Siswa (read-only via relasi) ─────────────────────────
                Forms\Components\Section::make('Data Siswa')
                    ->columns(2)
                    ->collapsed()
                    ->schema([
                        Forms\Components\TextInput::make('student.nama_lengkap')
                            ->label('Nama Lengkap')
                            ->disabled()
                            ->dehydrated(false),

                        Forms\Components\TextInput::make('student.nama_panggilan')
                            ->label('Nama Panggilan')
                            ->disabled()
                            ->dehydrated(false),

                        Forms\Components\TextInput::make('student.jenis_kelamin')
                            ->label('Jenis Kelamin')
                            ->disabled()
                            ->dehydrated(false),

                        Forms\Components\TextInput::make('student.tanggal_lahir')
                            ->label('Tanggal Lahir')
                            ->disabled()
                            ->dehydrated(false),

                        Forms\Components\TextInput::make('student.agama')
                            ->label('Agama')
                            ->disabled()
                            ->dehydrated(false),

                        Forms\Components\TextInput::make('student.no_hp')
                            ->label('No. HP')
                            ->disabled()
                            ->dehydrated(false),

                        Forms\Components\Textarea::make('student.alamat')
                            ->label('Alamat')
                            ->disabled()
                            ->dehydrated(false)
                            ->columnSpanFull(),
                    ]),

                // ── Info Orang Tua (read-only via relasi) ─────────────────────
                Forms\Components\Section::make('Data Orang Tua / Wali')
                    ->columns(2)
                    ->collapsed()
                    ->schema([
                        Forms\Components\TextInput::make('student.studentParent.nama_ayah')
                            ->label('Nama Ayah')
                            ->disabled()
                            ->dehydrated(false),

                        Forms\Components\TextInput::make('student.studentParent.pekerjaan_ayah')
                            ->label('Pekerjaan Ayah')
                            ->disabled()
                            ->dehydrated(false),

                        Forms\Components\TextInput::make('student.studentParent.nama_ibu')
                            ->label('Nama Ibu')
                            ->disabled()
                            ->dehydrated(false),

                        Forms\Components\TextInput::make('student.studentParent.pekerjaan_ibu')
                            ->label('Pekerjaan Ibu')
                            ->disabled()
                            ->dehydrated(false),
                    ]),
            ]);
    }

    // ─────────────────────────────────────────────────────────────────────────
    // TABLE — Daftar pendaftar dari tabel registrations (sistem baru)
    // ─────────────────────────────────────────────────────────────────────────

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // ID pendaftaran
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->width('60px'),

                // Nama siswa — via relasi student
                Tables\Columns\TextColumn::make('student.nama_lengkap')
                    ->label('Nama Siswa')
                    ->searchable()
                    ->sortable(),

                // No HP — via relasi student
                Tables\Columns\TextColumn::make('student.no_hp')
                    ->label('No. HP')
                    ->searchable()
                    ->toggleable(),

                // Nama Ayah — via relasi student → studentParent
                Tables\Columns\TextColumn::make('student.studentParent.nama_ayah')
                    ->label('Nama Ayah')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                // Nama akun user yang mendaftar
                Tables\Columns\TextColumn::make('student.user.name')
                    ->label('Akun Orang Tua')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                // Status dengan badge warna
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string =>
                        Registration::statusLabels()[$state] ?? ucfirst($state)
                    )
                    ->color(fn (string $state): string => match ($state) {
                        Registration::STATUS_DRAFT        => 'gray',
                        Registration::STATUS_SUBMITTED    => 'warning',
                        Registration::STATUS_VERIFIED     => 'info',
                        Registration::STATUS_ACCEPTED     => 'success',
                        Registration::STATUS_REJECTED     => 'danger',
                        Registration::STATUS_NOT_ACCEPTED => 'danger',
                        default                           => 'gray',
                    }),

                // Tanggal daftar
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tgl Daftar')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->toggleable(),
            ])

            // ── Filter by status ──────────────────────────────────────────────
            ->filters([
                SelectFilter::make('status')
                    ->label('Status')
                    ->options(Registration::statusLabels()),
            ])

            // ── Actions per baris ─────────────────────────────────────────────
            ->actions([
                // Tombol Lihat / Detail Preview
                Tables\Actions\ViewAction::make()
                    ->label('Cek Detail')
                    ->icon('heroicon-o-eye')
                    ->color('info'),

                // Tombol Verifikasi — hanya muncul saat status 'submitted'
                Tables\Actions\Action::make('verify')
                    ->label('Verifikasi')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Konfirmasi Verifikasi')
                    ->modalDescription('Tandai pendaftaran ini sebagai berkas valid?')
                    ->action(fn (Registration $record) =>
                        $record->update([
                            'status'      => Registration::STATUS_VERIFIED,
                            'verified_by' => \Filament\Facades\Filament::auth()->id() ?? auth()->id(),
                            'verified_at' => now(),
                        ])
                    )
                    ->successNotificationTitle('Pendaftaran berhasil diverifikasi!')
                    ->visible(fn (Registration $record): bool =>
                        $record->status === Registration::STATUS_SUBMITTED
                    ),

                // Tombol Terima — hanya muncul saat status 'verified'
                Tables\Actions\Action::make('accept')
                    ->label('Terima')
                    ->icon('heroicon-o-hand-thumb-up')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Terima Pendaftaran')
                    ->modalDescription('Pendaftaran ini akan ditandai sebagai DITERIMA.')
                    ->action(fn (Registration $record) =>
                        $record->update([
                            'status'      => Registration::STATUS_ACCEPTED,
                            'verified_by' => \Filament\Facades\Filament::auth()->id() ?? auth()->id(),
                            'verified_at' => now(),
                        ])
                    )
                    ->successNotificationTitle('Pendaftaran berhasil diterima!')
                    ->visible(fn (Registration $record): bool =>
                        $record->status === Registration::STATUS_VERIFIED
                    ),

                Tables\Actions\Action::make('reject')
                    ->label('Kembalikan')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading('Kembalikan Pendaftaran')
                    ->modalDescription('Pendaftaran ini akan dikembalikan ke pendaftar untuk diperbaiki.')
                    ->action(fn (Registration $record) =>
                        $record->update([
                            'status' => Registration::STATUS_REJECTED,
                        ])
                    )
                    ->successNotificationTitle('Pendaftaran berhasil dikembalikan!')
                    ->visible(fn (Registration $record): bool =>
                        in_array($record->status, [
                            Registration::STATUS_SUBMITTED,
                            Registration::STATUS_VERIFIED,
                        ])
                    ),

                // Tombol Cetak — buka tab baru
                Tables\Actions\Action::make('cetak')
                    ->label('Cetak')
                    ->icon('heroicon-o-printer')
                    ->color('gray')
                    ->url(fn (Registration $record): string =>
                        route('admin.ppdb.cetak', $record->id)
                    )
                    ->openUrlInNewTab(),

                Tables\Actions\EditAction::make()
                    ->label('Edit Status'),
            ])

            // ── Bulk actions ──────────────────────────────────────────────────
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])

            // Default: tampilkan yang terbaru + sembunyikan draft
            ->defaultSort('created_at', 'desc')
            ->modifyQueryUsing(fn ($query) =>
                $query->with(['student.user', 'student.studentParent'])
                      ->where('status', '!=', Registration::STATUS_DRAFT)
            );
    }

    // ─── Infolist (Detail Preview Modal) ──────────────────────────────────────

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([
            Infolists\Components\Section::make('Data Siswa')
                ->icon('heroicon-o-user')
                ->schema([
                    Infolists\Components\TextEntry::make('student.nama_lengkap')
                        ->label('Nama Lengkap'),
                    Infolists\Components\TextEntry::make('student.jenis_kelamin')
                        ->label('Jenis Kelamin')
                        ->formatStateUsing(fn ($state) => match($state) {
                            'L' => 'Laki-laki',
                            'P' => 'Perempuan',
                            default => $state,
                        }),
                    Infolists\Components\TextEntry::make('student.tanggal_lahir')
                        ->label('Tanggal Lahir')
                        ->date('d F Y'),
                    Infolists\Components\TextEntry::make('student.tempat_lahir')
                        ->label('Tempat Lahir'),
                    Infolists\Components\TextEntry::make('student.no_hp')
                        ->label('No. HP / WhatsApp'),
                    Infolists\Components\TextEntry::make('student.alamat')
                        ->label('Alamat')
                        ->columnSpanFull(),
                ])
                ->columns(2),

            Infolists\Components\Section::make('Data Orang Tua / Wali')
                ->icon('heroicon-o-users')
                ->schema([
                    Infolists\Components\TextEntry::make('student.studentParent.nama_ayah')
                        ->label('Nama Ayah'),
                    Infolists\Components\TextEntry::make('student.studentParent.nama_ibu')
                        ->label('Nama Ibu'),
                    Infolists\Components\TextEntry::make('student.studentParent.no_hp_ortu')
                        ->label('No. HP Orang Tua')
                        ->placeholder('—'),
                    Infolists\Components\TextEntry::make('student.studentParent.pekerjaan_ayah')
                        ->label('Pekerjaan Ayah'),
                ])
                ->columns(2),

            Infolists\Components\Section::make('Status Pendaftaran')
                ->icon('heroicon-o-clipboard-document-check')
                ->schema([
                    Infolists\Components\TextEntry::make('status')
                        ->label('Status')
                        ->badge()
                        ->color(fn ($state) => self::statusColor($state)),
                    Infolists\Components\TextEntry::make('verifier.name')
                        ->label('Diverifikasi Oleh')
                        ->placeholder('Belum diverifikasi'),
                    Infolists\Components\TextEntry::make('verified_at')
                        ->label('Tanggal Verifikasi')
                        ->dateTime('d F Y, H:i')
                        ->placeholder('-'),
                    Infolists\Components\TextEntry::make('notes')
                        ->label('Catatan Admin')
                        ->placeholder('Tidak ada catatan')
                        ->columnSpanFull(),
                ])
                ->columns(2),
        ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListPpdbRegistrations::route('/'),
            'create' => Pages\CreatePpdbRegistration::route('/create'),
            'edit'   => Pages\EditPpdbRegistration::route('/{record}/edit'),
        ];
    }

    // ─── Helper: Warna Status ─────────────────────────────────────────────────

    public static function statusColor(string $state): string
    {
        return match ($state) {
            Registration::STATUS_DRAFT        => 'gray',
            Registration::STATUS_SUBMITTED    => 'warning',
            Registration::STATUS_VERIFIED     => 'info',
            Registration::STATUS_REJECTED     => 'danger',
            Registration::STATUS_ACCEPTED     => 'success',
            Registration::STATUS_NOT_ACCEPTED => 'gray',
            default                           => 'gray',
        };
    }
}
