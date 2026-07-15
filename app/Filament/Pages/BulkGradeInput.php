<?php

namespace App\Filament\Pages;

use App\Models\AcademicYear;
use App\Models\Classroom;
use App\Models\Competency;
use App\Models\Student;
use App\Models\StudentGrade;
use Filament\Actions\Action;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Collection;

class BulkGradeInput extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationGroup = 'Sistem Akademik';
    protected static ?string $navigationIcon  = 'heroicon-o-table-cells';
    protected static ?string $navigationLabel = 'Input Nilai Massal';
    protected static ?string $title           = 'Input Nilai Massal per Kelas';
    protected static ?int    $navigationSort  = 4;

    protected static string $view = 'filament.pages.bulk-grade-input';

    // ── State ──────────────────────────────────────────────────────────────────

    public ?int    $academic_year_id = null;
    public ?string $semester         = null;
    public array   $grades           = [];

    public ?Collection $students     = null;
    public ?Collection $competencies = null;

    // ── Mount ──────────────────────────────────────────────────────────────────

    public function mount(): void
    {
        // Set default tahun ajaran aktif
        $activeYear = AcademicYear::where('is_active', true)->first();
        if ($activeYear) {
            $this->academic_year_id = $activeYear->id;
        }
    }

    // ── Form Definisi Filter ───────────────────────────────────────────────────

    protected function getFilterFormSchema(): array
    {
        return [
            Forms\Components\Section::make('Filter Data')
                ->columns(2)
                ->schema([
                    Forms\Components\Select::make('academic_year_id')
                        ->label('Tahun Ajaran')
                        ->options(AcademicYear::orderBy('name', 'desc')->pluck('name', 'id'))
                        ->required()
                        ->live()
                        ->afterStateUpdated(function ($state) {
                            $this->loadStudents();
                        }),

                    Forms\Components\Select::make('semester')
                        ->label('Semester')
                        ->options(['1' => 'Semester 1', '2' => 'Semester 2'])
                        ->required()
                        ->live()
                        ->afterStateUpdated(fn () => $this->loadStudents()),
                ]),
        ];
    }

    // ── Load Students ─────────────────────────────────────────────────────────

    public function loadStudents(): void
    {
        if (! $this->academic_year_id || ! $this->semester) {
            $this->students    = null;
            $this->competencies = null;
            return;
        }

        $this->students = Student::where('status', 'aktif')
            ->orderBy('nama_lengkap')
            ->get();

        $this->competencies = Competency::orderBy('name')->get();

        // Pre-fill existing grades
        $this->grades = [];
        foreach ($this->students as $student) {
            foreach ($this->competencies as $competency) {
                $existing = StudentGrade::where([
                    'student_id'       => $student->id,
                    'academic_year_id' => $this->academic_year_id,
                    'competency_id'    => $competency->id,
                    'semester'         => $this->semester,
                ])->first();

                $this->grades[$student->id][$competency->id] = $existing?->grade ?? '';
            }
        }
    }

    // ── Save ──────────────────────────────────────────────────────────────────

    public function save(): void
    {
        if (! $this->academic_year_id || ! $this->semester) {
            Notification::make()
                ->title('Pilih filter terlebih dahulu')
                ->warning()
                ->send();
            return;
        }

        $saved = 0;
        foreach ($this->grades as $studentId => $competencyGrades) {
            foreach ($competencyGrades as $competencyId => $grade) {
                if (empty($grade)) continue;

                StudentGrade::updateOrCreate(
                    [
                        'student_id'       => $studentId,
                        'academic_year_id' => $this->academic_year_id,
                        'competency_id'    => $competencyId,
                        'semester'         => $this->semester,
                    ],
                    ['grade' => $grade]
                );
                $saved++;
            }
        }

        Notification::make()
            ->title("Berhasil menyimpan {$saved} nilai!")
            ->success()
            ->send();
    }

    // ── Actions ───────────────────────────────────────────────────────────────

    protected function getHeaderActions(): array
    {
        return [
            Action::make('save')
                ->label('Simpan Semua Nilai')
                ->icon('heroicon-o-check')
                ->color('success')
                ->action('save'),
        ];
    }
}
