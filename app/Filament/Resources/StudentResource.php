<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StudentResource\Pages;
use App\Models\Student;
use App\Models\Classroom;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;

class StudentResource extends Resource
{
    protected static ?string $model = Student::class;

    protected static ?string $navigationGroup = 'Sistem Akademik';
    protected static ?string $navigationIcon  = 'heroicon-o-user-group';
    protected static ?string $navigationLabel = 'Siswa';
    protected static ?string $modelLabel       = 'Siswa';
    protected static ?string $pluralModelLabel = 'Daftar Siswa';
    protected static ?int    $navigationSort  = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make('Data Siswa')
                    ->columnSpanFull()
                    ->tabs([
                        // TAB 1: AKADEMIK
                        Forms\Components\Tabs\Tab::make('Data Akademik')
                            ->icon('heroicon-o-academic-cap')
                            ->schema([
                                Forms\Components\Grid::make(2)->schema([
                                    Forms\Components\TextInput::make('nis')
                                        ->label('NIS (Nomor Induk Siswa)')
                                        ->unique(ignoreRecord: true)
                                        ->nullable()
                                        ->placeholder('Masukkan NIS siswa...'),

                                    Forms\Components\Select::make('status')
                                        ->label('Status Siswa')
                                        ->options([
                                            'aktif' => 'Aktif',
                                            'non_aktif' => 'Non-Aktif',
                                            'lulus' => 'Lulus',
                                            'pindah' => 'Pindah',
                                        ])
                                        ->default('aktif')
                                        ->required(),

                                    Forms\Components\TextInput::make('ppdb_registration_id')
                                        ->label('PPDB Registration ID')
                                        ->numeric()
                                        ->nullable()
                                        ->placeholder('ID Pendaftaran PPDB...'),
                                ]),
                            ]),

                        // TAB 2: IDENTITAS DIRI
                        Forms\Components\Tabs\Tab::make('Identitas Diri')
                            ->icon('heroicon-o-user')
                            ->schema([
                                Forms\Components\Grid::make(2)->schema([
                                    Forms\Components\TextInput::make('nama_lengkap')
                                        ->label('Nama Lengkap')
                                        ->required()
                                        ->placeholder('Nama Lengkap Siswa...'),

                                    Forms\Components\TextInput::make('nama_panggilan')
                                        ->label('Nama Panggilan')
                                        ->placeholder('Nama Panggilan...'),

                                    Forms\Components\Select::make('jenis_kelamin')
                                        ->label('Jenis Kelamin')
                                        ->options([
                                            'L' => 'Laki-Laki',
                                            'P' => 'Perempuan',
                                        ])
                                        ->required(),

                                    Forms\Components\Grid::make(2)->schema([
                                        Forms\Components\TextInput::make('tempat_lahir')
                                            ->label('Tempat Lahir')
                                            ->placeholder('Kota lahir...'),

                                        Forms\Components\DatePicker::make('tanggal_lahir')
                                            ->label('Tanggal Lahir')
                                            ->placeholder('Pilih tanggal lahir...'),
                                    ]),

                                    Forms\Components\Select::make('agama')
                                        ->label('Agama')
                                        ->options([
                                            'Islam' => 'Islam',
                                            'Kristen' => 'Kristen',
                                            'Katolik' => 'Katolik',
                                            'Hindu' => 'Hindu',
                                            'Buddha' => 'Buddha',
                                            'Konghucu' => 'Konghucu',
                                        ])
                                        ->default('Islam'),

                                    Forms\Components\Select::make('kewarganegaraan')
                                        ->label('Kewarganegaraan')
                                        ->options([
                                            'WNI' => 'WNI',
                                            'WNA' => 'WNA',
                                        ])
                                        ->default('WNI')
                                        ->required(),
                                ]),
                            ]),

                        // TAB 3: ALAMAT & KONTAK
                        Forms\Components\Tabs\Tab::make('Kontak & Alamat')
                            ->icon('heroicon-o-home')
                            ->schema([
                                Forms\Components\Grid::make(2)->schema([
                                    Forms\Components\TextInput::make('no_hp')
                                        ->label('No. HP Orang Tua / Wali')
                                        ->tel()
                                        ->placeholder('Contoh: 081234567890'),

                                    Forms\Components\Select::make('tinggal_bersama')
                                        ->label('Tinggal Bersama')
                                        ->options([
                                            'orang_tua' => 'Orang Tua',
                                            'menumpang' => 'Menumpang (Kerabat)',
                                            'asrama' => 'Asrama',
                                            'kontrak' => 'Kontrak/Kos',
                                        ])
                                        ->default('orang_tua'),

                                    Forms\Components\Textarea::make('alamat')
                                        ->label('Alamat Lengkap')
                                        ->placeholder('Masukkan alamat rumah lengkap...')
                                        ->columnSpanFull()
                                        ->rows(3),
                                ]),
                            ]),

                        // TAB 4: KELUARGA
                        Forms\Components\Tabs\Tab::make('Data Keluarga')
                            ->icon('heroicon-o-users')
                            ->schema([
                                Forms\Components\Grid::make(2)->schema([
                                    Forms\Components\TextInput::make('anak_ke')
                                        ->label('Anak Ke-')
                                        ->numeric()
                                        ->placeholder('Contoh: 1'),

                                    Forms\Components\TextInput::make('bahasa_sehari_hari')
                                        ->label('Bahasa Sehari-hari')
                                        ->placeholder('Contoh: Bahasa Indonesia, Jawa...'),

                                    Forms\Components\TextInput::make('jumlah_saudara_kandung')
                                        ->label('Jumlah Saudara Kandung')
                                        ->numeric()
                                        ->default(0),

                                    Forms\Components\TextInput::make('jumlah_saudara_tiri')
                                        ->label('Jumlah Saudara Tiri')
                                        ->numeric()
                                        ->default(0),

                                    Forms\Components\TextInput::make('jumlah_saudara_angkat')
                                        ->label('Jumlah Saudara Angkat')
                                        ->numeric()
                                        ->default(0),
                                ]),
                            ]),

                        // TAB 5: FISIK & KESEHATAN
                        Forms\Components\Tabs\Tab::make('Fisik & Kesehatan')
                            ->icon('heroicon-o-heart')
                            ->schema([
                                Forms\Components\Grid::make(3)->schema([
                                    Forms\Components\TextInput::make('berat_badan')
                                        ->label('Berat Badan (kg)')
                                        ->numeric()
                                        ->placeholder('Contoh: 18.5'),

                                    Forms\Components\TextInput::make('tinggi_badan')
                                        ->label('Tinggi Badan (cm)')
                                        ->numeric()
                                        ->placeholder('Contoh: 110'),

                                    Forms\Components\Select::make('golongan_darah')
                                        ->label('Golongan Darah')
                                        ->options([
                                            'A' => 'A',
                                            'B' => 'B',
                                            'AB' => 'AB',
                                            'O' => 'O',
                                            'Tidak Tahu' => 'Tidak Tahu',
                                        ])
                                        ->default('Tidak Tahu'),
                                ]),

                                Forms\Components\Textarea::make('riwayat_penyakit')
                                    ->label('Riwayat Penyakit / Alergi')
                                    ->placeholder('Tulis jika ada alergi atau penyakit khusus...')
                                    ->columnSpanFull()
                                    ->rows(2),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_lengkap')
                    ->label('Nama Siswa')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('nis')
                    ->label('NIS')
                    ->searchable()
                    ->sortable()
                    ->placeholder('Belum diisi'),

                Tables\Columns\TextColumn::make('jenis_kelamin')
                    ->label('JK')
                    ->badge()
                    ->color(fn (string $state): string => $state === 'L' ? 'info' : 'warning')
                    ->formatStateUsing(fn ($state) => $state === 'L' ? 'L' : 'P')
                    ->sortable(),

                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'aktif' => 'success',
                        'non_aktif' => 'danger',
                        'lulus' => 'gray',
                        'pindah' => 'warning',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn ($state) => ucfirst(str_replace('_', ' ', $state)))
                    ->sortable(),

                Tables\Columns\TextColumn::make('no_hp')
                    ->label('No. HP Ortu')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Status Siswa')
                    ->options([
                        'aktif' => 'Aktif',
                        'non_aktif' => 'Non-Aktif',
                        'lulus' => 'Lulus',
                        'pindah' => 'Pindah',
                    ]),

                SelectFilter::make('jenis_kelamin')
                    ->label('Jenis Kelamin')
                    ->options([
                        'L' => 'Laki-Laki',
                        'P' => 'Perempuan',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStudents::route('/'),
            'create' => Pages\CreateStudent::route('/create'),
            'edit' => Pages\EditStudent::route('/{record}/edit'),
        ];
    }
}
