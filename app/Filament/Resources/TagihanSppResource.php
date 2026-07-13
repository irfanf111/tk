<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TagihanSppResource\Pages;
use App\Models\TagihanSpp;
use App\Models\Siswa;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Carbon;

class TagihanSppResource extends Resource
{
    protected static ?string $model = TagihanSpp::class;

    protected static ?string $navigationGroup = 'Pembayaran SPP';
    protected static ?string $navigationIcon = 'heroicon-o-credit-card';
    protected static ?string $navigationLabel = 'Tagihan SPP';
    protected static ?string $modelLabel = 'Tagihan SPP';
    protected static ?string $pluralModelLabel = 'Tagihan SPP';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Tagihan')
                    ->columns(2)
                    ->schema([
                        Forms\Components\Select::make('siswa_id')
                            ->label('Nama Siswa')
                            ->options(
                                Siswa::orderBy('nama_lengkap')
                                    ->get()
                                    ->pluck('nama_lengkap', 'id')
                            )
                            ->searchable()
                            ->required()
                            ->placeholder('Pilih siswa...')
                            ->live()
                            ->afterStateUpdated(fn ($state, Set $set, Get $get) => self::updateTenggat($state, $get('bulan_tagihan'), $set)),

                        Forms\Components\TextInput::make('bulan_tagihan')
                            ->label('Bulan Tagihan')
                            ->placeholder('Format: YYYY-MM, contoh: 2026-07')
                            ->required()
                            ->regex('/^\d{4}-(0[1-9]|1[0-2])$/')
                            ->helperText('Format YYYY-MM (misal: 2026-07)')
                            ->default(fn () => now()->format('Y-m'))
                            ->live()
                            ->afterStateUpdated(fn ($state, Set $set, Get $get) => self::updateTenggat($get('siswa_id'), $state, $set)),

                        Forms\Components\TextInput::make('total_tagihan')
                            ->label('Total Tagihan')
                            ->numeric()
                            ->required()
                            ->prefix('Rp')
                            ->default(45000)
                            ->placeholder('45000')
                            ->helperText('Nominal tagihan dalam Rupiah'),

                        Forms\Components\DatePicker::make('tenggat_pembayaran')
                            ->label('Tenggat Pembayaran')
                            ->required()
                            ->placeholder('Pilih tanggal tenggat...'),

                        Forms\Components\Select::make('status')
                            ->label('Status')
                            ->options([
                                'Belum Lunas' => 'Belum Lunas',
                                'Lunas' => 'Lunas',
                            ])
                            ->required()
                            ->default('Belum Lunas')
                            ->live(),

                        Forms\Components\DatePicker::make('tanggal_pembayaran')
                            ->label('Tanggal Pembayaran')
                            ->placeholder('Pilih tanggal bayar...')
                            ->nullable()
                            ->visible(fn (Get $get) => $get('status') === 'Lunas')
                            ->required(fn (Get $get) => $get('status') === 'Lunas')
                            ->maxDate(now())
                            ->default(fn (Get $get) => $get('status') === 'Lunas' ? now() : null),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('siswa.nama_lengkap')
                    ->label('Nama Siswa')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('bulan_tagihan')
                    ->label('Bulan Tagihan')
                    ->formatStateUsing(function ($state) {
                        try {
                            return Carbon::createFromFormat('Y-m', $state)->translatedFormat('F Y');
                        } catch (\Exception $e) {
                            return $state;
                        }
                    })
                    ->sortable(),

                Tables\Columns\TextColumn::make('total_tagihan')
                    ->label('Total Tagihan')
                    ->formatStateUsing(fn ($state) => 'Rp ' . number_format($state, 0, ',', '.'))
                    ->sortable(),

                Tables\Columns\TextColumn::make('tenggat_pembayaran')
                    ->label('Tenggat Pembayaran')
                    ->date('d M Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Lunas' => 'success',
                        'Belum Lunas' => 'danger',
                        default => 'warning',
                    })
                    ->sortable(),

                Tables\Columns\TextColumn::make('tanggal_pembayaran')
                    ->label('Tanggal Pembayaran')
                    ->date('d M Y')
                    ->placeholder('—')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Status Tagihan')
                    ->options([
                        'Lunas' => 'Lunas',
                        'Belum Lunas' => 'Belum Lunas',
                    ]),

                SelectFilter::make('bulan_tagihan')
                    ->label('Bulan')
                    ->options(function () {
                        return TagihanSpp::query()
                            ->distinct()
                            ->orderBy('bulan_tagihan', 'desc')
                            ->pluck('bulan_tagihan')
                            ->mapWithKeys(function ($bulan) {
                                try {
                                    return [$bulan => Carbon::createFromFormat('Y-m', $bulan)->translatedFormat('F Y')];
                                } catch (\Exception $e) {
                                    return [$bulan => $bulan];
                                }
                            })
                            ->toArray();
                    }),
            ])
            ->actions([
                Tables\Actions\Action::make('bayarLunas')
                    ->label('Bayar Lunas')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->action(function (TagihanSpp $record) {
                        $record->update([
                            'status' => 'Lunas',
                            'tanggal_pembayaran' => now(),
                        ]);

                        \Filament\Notifications\Notification::make()
                            ->title('Pembayaran Berhasil')
                            ->body('Tagihan berhasil diperbarui menjadi Lunas.')
                            ->success()
                            ->send();
                    })
                    ->visible(fn (TagihanSpp $record) => $record->status !== 'Lunas'),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->headerActions([
                Tables\Actions\Action::make('buatTagihanBulanan')
                    ->label('Buat Tagihan Bulanan')
                    ->icon('heroicon-o-plus-circle')
                    ->color('primary')
                    ->form([
                        Forms\Components\Select::make('bulan_tagihan')
                            ->label('Bulan Tagihan')
                            ->options(
                                collect(range(-2, 5))->mapWithKeys(function ($i) {
                                    $date = now()->addMonths($i);
                                    return [$date->format('Y-m') => $date->translatedFormat('F Y')];
                                })->toArray()
                            )
                            ->required()
                            ->default(now()->format('Y-m')),
                    ])
                    ->action(function (array $data) {
                        $bulan = $data['bulan_tagihan'];
                        $activeStudents = Siswa::aktif()->get();
                        $totalTagihan = 45000; // SPP 40000 + Majalah 5000
                        
                        $createdCount = 0;
                        $skippedCount = 0;

                        foreach ($activeStudents as $siswa) {
                            // Cek jika tagihan bulan ini sudah pernah dibuat
                            $exists = TagihanSpp::where('siswa_id', $siswa->id)
                                ->where('bulan_tagihan', $bulan)
                                ->exists();

                            if ($exists) {
                                $skippedCount++;
                                continue;
                            }

                            // Aturan Khusus Tenggat: disesuaikan dengan hari dari masa aktif awal masing-masing siswa.
                            $masaAktifAwal = $siswa->masa_aktif_awal; // Carbon instance dari accessor
                            $hariMasaAktif = $masaAktifAwal ? $masaAktifAwal->day : 10;
                            
                            try {
                                [$tahunTarget, $bulanTarget] = explode('-', $bulan);
                                $daysInMonth = cal_days_in_month(CAL_GREGORIAN, (int)$bulanTarget, (int)$tahunTarget);
                                $hariTenggat = min($hariMasaAktif, $daysInMonth);
                                
                                $tenggat = Carbon::create((int)$tahunTarget, (int)$bulanTarget, $hariTenggat);
                            } catch (\Exception $e) {
                                $tenggat = Carbon::parse($bulan . '-10');
                            }

                            TagihanSpp::create([
                                'siswa_id' => $siswa->id,
                                'bulan_tagihan' => $bulan,
                                'total_tagihan' => $totalTagihan,
                                'tenggat_pembayaran' => $tenggat,
                                'status' => 'Belum Lunas',
                                'tanggal_pembayaran' => null,
                            ]);
                            $createdCount++;
                        }

                        \Filament\Notifications\Notification::make()
                            ->title('Generate Tagihan Massal Selesai')
                            ->body("Berhasil membuat {$createdCount} tagihan baru. {$skippedCount} tagihan dilewati (sudah ada).")
                            ->success()
                            ->send();
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('bulan_tagihan', 'desc');
    }

    /**
     * Helper untuk auto-set tenggat pembayaran berdasarkan masa aktif awal siswa
     */
    public static function updateTenggat($siswaId, $bulan, Set $set): void
    {
        if (! $siswaId || ! $bulan) {
            return;
        }

        if (! preg_match('/^\d{4}-(0[1-9]|1[0-2])$/', $bulan)) {
            return;
        }

        $siswa = Siswa::find($siswaId);
        if (! $siswa) {
            return;
        }

        $masaAktifAwal = $siswa->masa_aktif_awal;
        $hariMasaAktif = $masaAktifAwal ? $masaAktifAwal->day : 10;

        try {
            [$tahunTarget, $bulanTarget] = explode('-', $bulan);
            $daysInMonth = cal_days_in_month(CAL_GREGORIAN, (int)$bulanTarget, (int)$tahunTarget);
            $hariTenggat = min($hariMasaAktif, $daysInMonth);
            
            $tenggat = Carbon::create((int)$tahunTarget, (int)$bulanTarget, $hariTenggat)->format('Y-m-d');
            $set('tenggat_pembayaran', $tenggat);
        } catch (\Exception $e) {
            // fallback
        }
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTagihanSpps::route('/'),
            'create' => Pages\CreateTagihanSpp::route('/create'),
            'edit' => Pages\EditTagihanSpp::route('/{record}/edit'),
        ];
    }
}
