<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RegistrationResource\Pages;
use App\Filament\Widgets\PpdbStatsOverview;
use App\Models\Registration;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class RegistrationResource extends Resource
{
    protected static ?string $model = Registration::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static ?string $navigationLabel = 'Manajemen PPDB';

    protected static ?string $navigationGroup = 'Manajemen PPDB';

    protected static ?string $modelLabel = 'Pendaftaran';

    protected static ?string $pluralModelLabel = 'Daftar Pendaftar';

    protected static ?int $navigationSort = 1;

    // ─── Badge jumlah menunggu verifikasi di sidebar ──────────────────────────

    public static function getNavigationBadge(): ?string
    {
        return (string) static::getModel()::where('status', Registration::STATUS_SUBMITTED)->count() ?: null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }

    // ─── Form (Edit) ─────────────────────────────────────────────────────────

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Status Pendaftaran')
                ->description('Ubah status dan tambahkan catatan untuk pendaftar ini.')
                ->icon('heroicon-o-clipboard-document-check')
                ->schema([
                    Forms\Components\Select::make('status')
                        ->label('Status')
                        ->options(Registration::statusLabels())
                        ->required()
                        ->native(false)
                        ->live(),

                    Forms\Components\Select::make('verified_by')
                        ->label('Diverifikasi Oleh')
                        ->options(User::where('role', 'admin')->pluck('name', 'id'))
                        ->nullable()
                        ->native(false)
                        ->searchable()
                        ->hidden(fn (Forms\Get $get) => $get('status') === Registration::STATUS_DRAFT
                            || $get('status') === Registration::STATUS_SUBMITTED),

                    Forms\Components\DateTimePicker::make('verified_at')
                        ->label('Tanggal Verifikasi')
                        ->nullable()
                        ->hidden(fn (Forms\Get $get) => $get('status') === Registration::STATUS_DRAFT
                            || $get('status') === Registration::STATUS_SUBMITTED),

                    Forms\Components\Textarea::make('notes')
                        ->label('Catatan Admin')
                        ->placeholder('Tuliskan catatan atau alasan keputusan di sini...')
                        ->rows(4)
                        ->columnSpanFull(),
                ])
                ->columns(2),
        ]);
    }

    // ─── Infolist (View) ──────────────────────────────────────────────────────

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
                        ->label('No. HP Orang Tua'),
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

    // ─── Table ────────────────────────────────────────────────────────────────

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('index')
                    ->label('#')
                    ->rowIndex()
                    ->width(50),

                Tables\Columns\TextColumn::make('student.nama_lengkap')
                    ->label('Nama Lengkap')
                    ->searchable()
                    ->sortable()
                    ->weight('semibold'),

                Tables\Columns\TextColumn::make('student.no_hp')
                    ->label('No. HP')
                    ->searchable()
                    ->icon('heroicon-m-phone'),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Terakhir Diperbarui')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->since()
                    ->tooltip(fn ($record) => $record->updated_at->format('d F Y, H:i')),

                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn ($state) => self::statusColor($state))
                    ->formatStateUsing(fn ($state) => Registration::statusLabels()[$state] ?? $state)
                    ->sortable(),

                Tables\Columns\TextColumn::make('verifier.name')
                    ->label('Diverifikasi Oleh')
                    ->placeholder('—')
                    ->icon('heroicon-m-user-circle')
                    ->searchable(),
            ])
            ->defaultSort('updated_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Filter Status')
                    ->options(Registration::statusLabels()),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label('Cek Detail')
                    ->icon('heroicon-m-eye'),

                Tables\Actions\EditAction::make()
                    ->label('Ubah Status')
                    ->icon('heroicon-m-pencil-square'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateIcon('heroicon-o-clipboard-document-list')
            ->emptyStateHeading('Belum ada pendaftar')
            ->emptyStateDescription('Pendaftar akan muncul di sini setelah mengisi formulir PPDB.');
    }

    // ─── Relasi ───────────────────────────────────────────────────────────────

    public static function getRelations(): array
    {
        return [];
    }

    // ─── Pages ────────────────────────────────────────────────────────────────

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListRegistrations::route('/'),
            'create' => Pages\CreateRegistration::route('/create'),
            'view'   => Pages\ViewRegistration::route('/{record}'),
            'edit'   => Pages\EditRegistration::route('/{record}/edit'),
        ];
    }

    // ─── Eloquent Query (eager load relasi) ───────────────────────────────────

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with(['student', 'verifier']);
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
