<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SppPaymentResource\Pages;
use App\Models\SppPayment;
use App\Models\Student;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class SppPaymentResource extends Resource
{
    protected static ?string $model = SppPayment::class;

    protected static ?string $navigationGroup  = 'Pembayaran SPP';
    protected static ?string $navigationIcon   = 'heroicon-o-banknotes';
    protected static ?string $navigationLabel  = 'Pembayaran SPP';
    protected static ?string $modelLabel       = 'Pembayaran SPP';
    protected static ?string $pluralModelLabel = 'Pembayaran SPP';
    protected static ?int    $navigationSort   = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Data Pembayaran')
                    ->columns(2)
                    ->schema([
                        Forms\Components\Select::make('student_id')
                            ->label('Siswa')
                            ->options(
                                Student::orderBy('nama_lengkap')
                                    ->get()
                                    ->mapWithKeys(fn ($s) => [$s->id => $s->nama_lengkap ?? 'Siswa #' . $s->id])
                            )
                            ->searchable()
                            ->required()
                            ->placeholder('Cari nama siswa...'),

                        Forms\Components\TextInput::make('bulan')
                            ->label('Bulan Pembayaran')
                            ->placeholder('Format: YYYY-MM, contoh: 2026-07')
                            ->required()
                            ->regex('/^\d{4}-(0[1-9]|1[0-2])$/')
                            ->helperText('Format: YYYY-MM (contoh: 2026-07 untuk Juli 2026)')
                            ->default(fn () => now()->format('Y-m')),

                        Forms\Components\TextInput::make('nominal')
                            ->label('Nominal (Rupiah)')
                            ->numeric()
                            ->required()
                            ->minValue(0)
                            ->prefix('Rp')
                            ->placeholder('150000')
                            ->helperText('Masukkan nominal dalam angka, tanpa titik/koma'),

                        Forms\Components\DatePicker::make('tanggal_bayar')
                            ->label('Tanggal Bayar')
                            ->nullable()
                            ->maxDate(now())
                            ->default(now()),

                        Forms\Components\Select::make('status')
                            ->label('Status')
                            ->options([
                                'lunas' => 'Lunas',
                                'belum' => 'Belum Lunas',
                            ])
                            ->required()
                            ->default('lunas'),

                        Forms\Components\Hidden::make('dicatat_oleh')
                            ->default(fn () => Auth::id()),

                        Forms\Components\Textarea::make('keterangan')
                            ->label('Keterangan (opsional)')
                            ->placeholder('Catatan tambahan, misal: terlambat, cicilan, dll.')
                            ->nullable()
                            ->rows(2)
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('student.nama_lengkap')
                    ->label('Nama Siswa')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('bulan')
                    ->label('Bulan')
                    ->formatStateUsing(function ($state) {
                        try {
                            return Carbon::createFromFormat('Y-m', $state)->translatedFormat('F Y');
                        } catch (\Exception $e) {
                            return $state;
                        }
                    })
                    ->sortable(),

                Tables\Columns\TextColumn::make('nominal')
                    ->label('Nominal')
                    ->formatStateUsing(fn ($state) => 'Rp ' . number_format($state, 0, ',', '.'))
                    ->sortable(),

                Tables\Columns\TextColumn::make('tanggal_bayar')
                    ->label('Tgl Bayar')
                    ->date('d M Y')
                    ->sortable()
                    ->placeholder('—'),

                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn ($state) => $state === 'lunas' ? 'Lunas' : 'Belum Lunas')
                    ->color(fn ($state) => $state === 'lunas' ? 'success' : 'danger'),

                Tables\Columns\TextColumn::make('pencatat.name')
                    ->label('Dicatat Oleh')
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('keterangan')
                    ->label('Keterangan')
                    ->limit(40)
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Waktu Input')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('student_id')
                    ->label('Siswa')
                    ->options(
                        Student::orderBy('nama_lengkap')
                            ->get()
                            ->mapWithKeys(fn ($s) => [$s->id => $s->nama_lengkap ?? 'Siswa #' . $s->id])
                    )
                    ->searchable(),

                SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'lunas' => 'Lunas',
                        'belum' => 'Belum Lunas',
                    ]),

                Tables\Filters\Filter::make('bulan')
                    ->form([
                        Forms\Components\TextInput::make('bulan')
                            ->label('Bulan (YYYY-MM)')
                            ->placeholder('2026-07'),
                    ])
                    ->query(function ($query, array $data) {
                        if (! empty($data['bulan'])) {
                            $query->where('bulan', $data['bulan']);
                        }
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('bulan', 'desc');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'   => Pages\ListSppPayments::route('/'),
            'create'  => Pages\CreateSppPayment::route('/create'),
            'edit'    => Pages\EditSppPayment::route('/{record}/edit'),
            'rekap'   => Pages\RekapSppPayment::route('/rekap'),
        ];
    }

    /**
     * Navigation badge: tampilkan jumlah pembayaran belum lunas bulan ini.
     */
    public static function getNavigationBadge(): ?string
    {
        $belum = SppPayment::where('status', 'belum')
            ->where('bulan', now()->format('Y-m'))
            ->count();

        return $belum > 0 ? (string) $belum : null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'danger';
    }
}
