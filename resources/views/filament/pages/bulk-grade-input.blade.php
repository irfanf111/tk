<x-filament-panels::page>
    {{-- ── Filter Form ─────────────────────────────────────────────────── --}}
    <div class="p-6 bg-white rounded-xl shadow dark:bg-gray-900 mb-6">
        <h2 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-100">
            Filter Kelas & Semester
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            {{-- Tahun Ajaran --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tahun Ajaran</label>
                <select wire:model.live="academic_year_id"
                    class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                    <option value="">-- Pilih Tahun Ajaran --</option>
                    @foreach(\App\Models\AcademicYear::orderBy('name','desc')->get() as $ay)
                        <option value="{{ $ay->id }}" @selected($academic_year_id == $ay->id)>{{ $ay->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Semester --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Semester</label>
                <select wire:model.live="semester"
                    class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                    <option value="">-- Pilih Semester --</option>
                    <option value="1" @selected($semester == '1')>Semester 1</option>
                    <option value="2" @selected($semester == '2')>Semester 2</option>
                </select>
            </div>
        </div>

        @if($academic_year_id && $classroom_id && $semester)
            <div class="mt-4">
                <button wire:click="loadStudents"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg text-sm font-medium transition">
                    <x-heroicon-o-magnifying-glass class="w-4 h-4"/>
                    Muat Data Siswa
                </button>
            </div>
        @endif
    </div>

    {{-- ── Tabel Input Nilai ────────────────────────────────────────────── --}}
    @if($students && $students->isNotEmpty() && $competencies && $competencies->isNotEmpty())
        <div class="bg-white rounded-xl shadow dark:bg-gray-900 overflow-hidden">
            <div class="p-4 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                <div>
                    <h3 class="font-semibold text-gray-800 dark:text-gray-100">
                        Input Nilai — {{ $students->count() }} Siswa, {{ $competencies->count() }} Kompetensi
                    </h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                        Pilihan nilai: <span class="font-mono bg-gray-100 dark:bg-gray-800 px-1 rounded">BSB</span>
                        <span class="font-mono bg-gray-100 dark:bg-gray-800 px-1 rounded">BSH</span>
                        <span class="font-mono bg-gray-100 dark:bg-gray-800 px-1 rounded">MB</span>
                        <span class="font-mono bg-gray-100 dark:bg-gray-800 px-1 rounded">BB</span>
                    </p>
                </div>
                <button wire:click="save"
                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-success-600 hover:bg-success-700 text-white rounded-lg text-sm font-semibold transition shadow">
                    <x-heroicon-o-check class="w-4 h-4"/>
                    Simpan Semua Nilai
                </button>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 dark:bg-gray-800">
                        <tr>
                            <th class="sticky left-0 bg-gray-50 dark:bg-gray-800 px-4 py-3 text-left font-semibold text-gray-700 dark:text-gray-300 min-w-[200px]">
                                Nama Siswa
                            </th>
                            @foreach($competencies as $comp)
                                <th class="px-3 py-3 text-center font-semibold text-gray-700 dark:text-gray-300 min-w-[100px] max-w-[140px]">
                                    <div class="truncate text-xs" title="{{ $comp->name }}">
                                        {{ Str::limit($comp->name, 30) }}
                                    </div>
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                        @foreach($students as $student)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition">
                                <td class="sticky left-0 bg-white dark:bg-gray-900 px-4 py-2 font-medium text-gray-800 dark:text-gray-200">
                                    {{ $student->nama_lengkap ?? 'Siswa #' . $student->id }}
                                </td>
                                @foreach($competencies as $comp)
                                    <td class="px-2 py-2 text-center">
                                        <select
                                            wire:model="grades.{{ $student->id }}.{{ $comp->id }}"
                                            class="w-full rounded border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 text-xs py-1 focus:border-primary-500 focus:ring-primary-500
                                                @php
                                                    $g = $grades[$student->id][$comp->id] ?? '';
                                                    echo match($g) {
                                                        'BSB' => 'border-green-400 bg-green-50 dark:bg-green-900/20',
                                                        'BSH' => 'border-blue-400 bg-blue-50 dark:bg-blue-900/20',
                                                        'MB'  => 'border-yellow-400 bg-yellow-50 dark:bg-yellow-900/20',
                                                        'BB'  => 'border-red-400 bg-red-50 dark:bg-red-900/20',
                                                        default => '',
                                                    };
                                                @endphp
                                            ">
                                            <option value="">—</option>
                                            <option value="BSB" @selected(($grades[$student->id][$comp->id] ?? '') === 'BSB')>BSB</option>
                                            <option value="BSH" @selected(($grades[$student->id][$comp->id] ?? '') === 'BSH')>BSH</option>
                                            <option value="MB"  @selected(($grades[$student->id][$comp->id] ?? '') === 'MB')>MB</option>
                                            <option value="BB"  @selected(($grades[$student->id][$comp->id] ?? '') === 'BB')>BB</option>
                                        </select>
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="p-4 border-t border-gray-200 dark:border-gray-700 text-right">
                <button wire:click="save"
                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-success-600 hover:bg-success-700 text-white rounded-lg text-sm font-semibold transition shadow">
                    <x-heroicon-o-check class="w-4 h-4"/>
                    Simpan Semua Nilai
                </button>
            </div>
        </div>

        {{-- Legend --}}
        <div class="mt-4 flex flex-wrap gap-3 text-xs">
            <span class="px-3 py-1 rounded-full bg-green-100 text-green-800 font-semibold">BSB — Berkembang Sangat Baik</span>
            <span class="px-3 py-1 rounded-full bg-blue-100 text-blue-800 font-semibold">BSH — Berkembang Sesuai Harapan</span>
            <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-800 font-semibold">MB — Mulai Berkembang</span>
            <span class="px-3 py-1 rounded-full bg-red-100 text-red-800 font-semibold">BB — Belum Berkembang</span>
        </div>

    @elseif($students && $students->isEmpty())
        <div class="text-center py-12 text-gray-500 dark:text-gray-400">
            <x-heroicon-o-user-group class="w-12 h-12 mx-auto mb-3 opacity-40"/>
            <p>Tidak ada siswa di kelas ini.</p>
            <p class="text-xs mt-1">Pastikan siswa sudah diassign ke kelas yang dipilih.</p>
        </div>

    @elseif(!$academic_year_id || !$classroom_id || !$semester)
        <div class="text-center py-12 text-gray-400 dark:text-gray-600">
            <x-heroicon-o-funnel class="w-12 h-12 mx-auto mb-3 opacity-40"/>
            <p>Pilih tahun ajaran, kelas, dan semester di atas untuk memulai input nilai.</p>
        </div>
    @endif

</x-filament-panels::page>
