<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReportResource\Pages;
use App\Filament\Resources\ReportResource\RelationManagers\NarrativeRelationManager;
use App\Models\AcademicYear;
use App\Models\LpadStudent;
use App\Models\Report;
use App\Models\Student;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ReportResource extends Resource
{
    protected static ?string $model = Report::class;

    protected static ?string $navigationGroup  = 'Sistem Akademik';
    protected static ?string $navigationIcon   = 'heroicon-o-document-text';
    protected static ?string $navigationLabel  = 'Rapor / LPAD';
    protected static ?string $modelLabel       = 'Rapor';
    protected static ?string $pluralModelLabel = 'Rapor Siswa';
    protected static ?int    $navigationSort   = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // ── Identitas Rapor ───────────────────────────────────────────
                Forms\Components\Section::make('Identitas Rapor')
                    ->columns(2)
                    ->schema([
                        // Untuk record baru: pilih siswa via Select
                        Forms\Components\Select::make('lpad_student_id')
                            ->label('Siswa')
                            ->options(function () {
                                // Tampilkan semua siswa dari tabel students
                                // dengan auto-create LpadStudent jika belum ada
                                $students = Student::orderBy('nama_lengkap')->get();
                                $options  = [];

                                foreach ($students as $student) {
                                    // Cari atau buat LpadStudent untuk siswa ini
                                    $lpad = LpadStudent::firstOrCreate(
                                        ['student_id' => $student->id],
                                        [
                                            'no_induk'      => $student->nis ?? 'PPDB-' . $student->id,
                                            'nama_lengkap'  => $student->nama_lengkap ?? 'Siswa #' . $student->id,
                                            'tanggal_lahir' => $student->tanggal_lahir ?? now()->subYears(5),
                                        ]
                                    );
                                    $options[$lpad->id] = $student->nama_lengkap ?? 'Siswa #' . $student->id;
                                }

                                // Juga tampilkan LpadStudent lama yang tidak punya student_id
                                $oldLpads = LpadStudent::whereNull('student_id')->get();
                                foreach ($oldLpads as $lpad) {
                                    $options[$lpad->id] = '(Lama) ' . $lpad->nama_lengkap;
                                }

                                return $options;
                            })
                            ->searchable()
                            ->required()
                            ->placeholder('Pilih siswa...'),

                        Forms\Components\Select::make('tahun_ajaran')
                            ->label('Tahun Ajaran')
                            ->options(
                                AcademicYear::orderBy('name', 'desc')->pluck('name', 'name')
                            )
                            ->searchable()
                            ->required()
                            ->placeholder('Pilih tahun ajaran...')
                            ->default(fn () => AcademicYear::where('is_active', true)->value('name')),

                        Forms\Components\Select::make('semester')
                            ->label('Semester')
                            ->options([
                                '1' => 'Semester 1',
                                '2' => 'Semester 2',
                            ])
                            ->required()
                            ->placeholder('Pilih semester...'),
                    ]),

                // ── Data Fisik ────────────────────────────────────────────────
                Forms\Components\Section::make('Data Fisik')
                    ->columns(3)
                    ->schema([
                        Forms\Components\TextInput::make('bb')
                            ->label('Berat Badan (kg)')
                            ->numeric()
                            ->required()
                            ->minValue(0)
                            ->step(0.1),

                        Forms\Components\TextInput::make('tb')
                            ->label('Tinggi Badan (cm)')
                            ->numeric()
                            ->required()
                            ->minValue(0)
                            ->step(0.1),

                        Forms\Components\TextInput::make('lingkar_kepala')
                            ->label('Lingkar Kepala (cm)')
                            ->numeric()
                            ->required()
                            ->minValue(0)
                            ->step(0.1),
                    ]),

                // ── Kondisi Kesehatan ─────────────────────────────────────────
                Forms\Components\Section::make('Kondisi Kesehatan')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('kondisi_mata')
                            ->label('Kondisi Mata')
                            ->placeholder('Normal / Bermasalah...')
                            ->required(),

                        Forms\Components\TextInput::make('kondisi_telinga')
                            ->label('Kondisi Telinga')
                            ->placeholder('Normal / Bermasalah...')
                            ->required(),

                        Forms\Components\TextInput::make('kondisi_hidung')
                            ->label('Kondisi Hidung')
                            ->placeholder('Normal / Bermasalah...')
                            ->required(),

                        Forms\Components\TextInput::make('kondisi_gigi')
                            ->label('Kondisi Gigi')
                            ->placeholder('Normal / Bermasalah...')
                            ->required(),

                        Forms\Components\TextInput::make('kondisi_kulit')
                            ->label('Kondisi Kulit')
                            ->placeholder('Normal / Bermasalah...')
                            ->required()
                            ->columnSpanFull(),
                    ]),

                // ── Kehadiran ─────────────────────────────────────────────────
                Forms\Components\Section::make('Kehadiran')
                    ->columns(3)
                    ->schema([
                        Forms\Components\TextInput::make('sakit')
                            ->label('Sakit (hari)')
                            ->numeric()
                            ->required()
                            ->minValue(0)
                            ->default(0),

                        Forms\Components\TextInput::make('izin')
                            ->label('Izin (hari)')
                            ->numeric()
                            ->required()
                            ->minValue(0)
                            ->default(0),

                        Forms\Components\TextInput::make('alpa')
                            ->label('Tanpa Keterangan (hari)')
                            ->numeric()
                            ->required()
                            ->minValue(0)
                            ->default(0),
                    ]),

                // ── Komentar Orang Tua ────────────────────────────────────────
                Forms\Components\Section::make('Komentar Orang Tua')
                    ->schema([
                        Forms\Components\Textarea::make('komentar_ortu')
                            ->label('Komentar / Catatan Orang Tua')
                            ->nullable()
                            ->rows(3)
                            ->placeholder('Opsional...'),
                    ]),

                // ── Narasi (tampilkan hanya saat edit) ───────────────────────
                Forms\Components\Section::make('Narasi Capaian Pembelajaran')
                    ->description('Setelah menyimpan data di atas, narasi bisa diisi di tab "Narasi Capaian Pembelajaran" di bawah.')
                    ->schema([
                        Forms\Components\Placeholder::make('narasi_info')
                            ->label('')
                            ->content('Simpan data rapor terlebih dahulu, lalu isi narasi capaian di bagian bawah halaman edit.')
                            ->hiddenOn('edit'),
                    ])
                    ->hiddenOn('edit'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('lpadStudent.student.nama_lengkap')
                    ->label('Nama Siswa')
                    ->searchable()
                    ->sortable()
                    ->default(fn ($record) => $record->lpadStudent?->nama_lengkap ?? '—'),

                Tables\Columns\TextColumn::make('tahun_ajaran')
                    ->label('Tahun Ajaran')
                    ->sortable(),

                Tables\Columns\TextColumn::make('semester')
                    ->label('Semester')
                    ->formatStateUsing(fn ($state) => 'Semester ' . $state)
                    ->badge()
                    ->color(fn ($state) => $state === '1' ? 'info' : 'warning'),

                Tables\Columns\TextColumn::make('bb')
                    ->label('BB (kg)')
                    ->numeric(1),

                Tables\Columns\TextColumn::make('tb')
                    ->label('TB (cm)')
                    ->numeric(1),

                Tables\Columns\IconColumn::make('narrative')
                    ->label('Narasi')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Diperbarui')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('tahun_ajaran')
                    ->label('Tahun Ajaran')
                    ->options(
                        AcademicYear::orderBy('name', 'desc')->pluck('name', 'name')
                    ),

                SelectFilter::make('semester')
                    ->label('Semester')
                    ->options([
                        '1' => 'Semester 1',
                        '2' => 'Semester 2',
                    ]),
            ])
            ->actions([
                Tables\Actions\Action::make('export_pdf')
                    ->label('PDF')
                    ->icon('heroicon-o-document-arrow-down')
                    ->color('success')
                    ->url(fn (Report $record): string => route('admin.rapor.pdf', $record->id))
                    ->openUrlInNewTab(),

                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('updated_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            NarrativeRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListReports::route('/'),
            'create' => Pages\CreateReport::route('/create'),
            'edit'   => Pages\EditReport::route('/{record}/edit'),
        ];
    }
}
