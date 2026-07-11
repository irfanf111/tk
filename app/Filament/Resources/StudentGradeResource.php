<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StudentGradeResource\Pages;
use App\Models\AcademicYear;
use App\Models\Classroom;
use App\Models\Competency;
use App\Models\Student;
use App\Models\StudentGrade;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class StudentGradeResource extends Resource
{
    protected static ?string $model = StudentGrade::class;

    protected static ?string $navigationGroup  = 'Sistem Akademik';
    protected static ?string $navigationIcon   = 'heroicon-o-chart-bar';
    protected static ?string $navigationLabel  = 'Nilai Siswa';
    protected static ?string $modelLabel       = 'Nilai Siswa';
    protected static ?string $pluralModelLabel = 'Nilai Siswa';
    protected static ?int    $navigationSort   = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Data Nilai')
                    ->columns(2)
                    ->schema([
                        Forms\Components\Select::make('student_id')
                            ->label('Siswa')
                            ->relationship('student', 'nama_lengkap')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->placeholder('Pilih siswa...'),

                        Forms\Components\Select::make('academic_year_id')
                            ->label('Tahun Ajaran')
                            ->relationship('academicYear', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->placeholder('Pilih tahun ajaran...')
                            ->default(fn () => AcademicYear::where('is_active', true)->value('id')),

                        Forms\Components\Select::make('semester')
                            ->label('Semester')
                            ->options([
                                '1' => 'Semester 1',
                                '2' => 'Semester 2',
                            ])
                            ->required()
                            ->placeholder('Pilih semester...'),

                        Forms\Components\Select::make('competency_id')
                            ->label('Kompetensi / Aspek Perkembangan')
                            ->relationship('competency', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->placeholder('Pilih kompetensi...'),

                        Forms\Components\Select::make('grade')
                            ->label('Capaian')
                            ->options([
                                'BSB' => 'BSB — Berkembang Sangat Baik',
                                'BSH' => 'BSH — Berkembang Sesuai Harapan',
                                'MB'  => 'MB  — Mulai Berkembang',
                                'BB'  => 'BB  — Belum Berkembang',
                            ])
                            ->required()
                            ->placeholder('Pilih capaian...')
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

                Tables\Columns\TextColumn::make('academicYear.name')
                    ->label('Tahun Ajaran')
                    ->sortable(),

                Tables\Columns\TextColumn::make('semester')
                    ->label('Semester')
                    ->formatStateUsing(fn ($state) => $state ? 'Semester ' . $state : '—')
                    ->badge()
                    ->color(fn ($state) => $state === '1' ? 'info' : 'warning'),

                Tables\Columns\TextColumn::make('competency.name')
                    ->label('Kompetensi')
                    ->searchable()
                    ->wrap(),

                Tables\Columns\TextColumn::make('grade')
                    ->label('Capaian')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'BSB' => 'success',
                        'BSH' => 'info',
                        'MB'  => 'warning',
                        'BB'  => 'danger',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Diperbarui')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('academic_year_id')
                    ->label('Tahun Ajaran')
                    ->relationship('academicYear', 'name')
                    ->preload(),

                SelectFilter::make('semester')
                    ->label('Semester')
                    ->options([
                        '1' => 'Semester 1',
                        '2' => 'Semester 2',
                    ]),

                SelectFilter::make('grade')
                    ->label('Capaian')
                    ->options([
                        'BSB' => 'BSB — Berkembang Sangat Baik',
                        'BSH' => 'BSH — Berkembang Sesuai Harapan',
                        'MB'  => 'MB  — Mulai Berkembang',
                        'BB'  => 'BB  — Belum Berkembang',
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
            ])
            ->defaultSort('updated_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListStudentGrades::route('/'),
            'create' => Pages\CreateStudentGrade::route('/create'),
            'edit'   => Pages\EditStudentGrade::route('/{record}/edit'),
        ];
    }
}
