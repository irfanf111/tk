<x-filament-panels::page>
    {{-- ── Header Filter ──────────────────────────────────────────────────── --}}
    <div class="p-6 bg-white rounded-xl shadow dark:bg-gray-900 mb-6">
        <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">
            Rekap Pembayaran SPP per Bulan
        </h2>
        <div class="flex items-center gap-4">
            <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Pilih Bulan:</label>
            <select wire:model.live="bulan_filter"
                class="rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                @foreach($this->getBulanOptions() as $value => $label)
                    <option value="{{ $value }}" @selected($bulan_filter === $value)>{{ $label }}</option>
                @endforeach
            </select>
        </div>
    </div>

    @php
        $students = $this->getStudentsWithStatus();
        $summary  = $this->getSummary();
        try {
            $bulanLabel = \Carbon\Carbon::createFromFormat('Y-m', $bulan_filter)->translatedFormat('F Y');
        } catch (\Exception $e) {
            $bulanLabel = $bulan_filter;
        }
    @endphp

    {{-- ── Summary Cards ──────────────────────────────────────────────────── --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-white dark:bg-gray-900 rounded-xl shadow p-5 border-l-4 border-blue-500">
            <p class="text-xs text-gray-500 dark:text-gray-400 uppercase font-semibold tracking-wide">Total Siswa</p>
            <p class="text-3xl font-bold text-blue-600 mt-1">{{ $summary['total'] }}</p>
        </div>
        <div class="bg-white dark:bg-gray-900 rounded-xl shadow p-5 border-l-4 border-green-500">
            <p class="text-xs text-gray-500 dark:text-gray-400 uppercase font-semibold tracking-wide">Sudah Lunas</p>
            <p class="text-3xl font-bold text-green-600 mt-1">{{ $summary['lunas'] }}</p>
        </div>
        <div class="bg-white dark:bg-gray-900 rounded-xl shadow p-5 border-l-4 border-red-500">
            <p class="text-xs text-gray-500 dark:text-gray-400 uppercase font-semibold tracking-wide">Belum Bayar</p>
            <p class="text-3xl font-bold text-red-600 mt-1">{{ $summary['belum'] }}</p>
        </div>
    </div>

    {{-- ── Tabel Rekap ─────────────────────────────────────────────────────── --}}
    <div class="bg-white rounded-xl shadow dark:bg-gray-900 overflow-hidden">
        <div class="p-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="font-semibold text-gray-800 dark:text-gray-100">
                Status Pembayaran — {{ $bulanLabel }}
            </h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 dark:bg-gray-800">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold text-gray-700 dark:text-gray-300">#</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-700 dark:text-gray-300">Nama Siswa</th>
                        <th class="px-4 py-3 text-center font-semibold text-gray-700 dark:text-gray-300">Status</th>
                        <th class="px-4 py-3 text-right font-semibold text-gray-700 dark:text-gray-300">Nominal</th>
                        <th class="px-4 py-3 text-center font-semibold text-gray-700 dark:text-gray-300">Tgl Bayar</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-700 dark:text-gray-300">Keterangan</th>
                        <th class="px-4 py-3 text-center font-semibold text-gray-700 dark:text-gray-300">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    @foreach($students as $i => $data)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition">
                            <td class="px-4 py-3 text-gray-500">{{ $i + 1 }}</td>
                            <td class="px-4 py-3 font-medium text-gray-800 dark:text-gray-200">
                                {{ $data['nama'] }}
                            </td>
                            <td class="px-4 py-3 text-center">
                                @if($data['status'] === 'lunas')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                        Lunas
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                                        Belum
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-right text-gray-700 dark:text-gray-300">
                                @if($data['nominal'])
                                    Rp {{ number_format($data['nominal'], 0, ',', '.') }}
                                @else
                                    <span class="text-gray-400">—</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-center text-gray-600 dark:text-gray-400">
                                @if($data['tanggal_bayar'])
                                    {{ \Carbon\Carbon::parse($data['tanggal_bayar'])->format('d M Y') }}
                                @else
                                    <span class="text-gray-400">—</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-gray-600 dark:text-gray-400 max-w-xs">
                                <span class="text-xs">{{ $data['keterangan'] ?? '—' }}</span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                @if($data['payment_id'])
                                    <a href="{{ \App\Filament\Resources\SppPaymentResource::getUrl('edit', ['record' => $data['payment_id']]) }}"
                                        class="text-xs px-2 py-1 rounded bg-blue-100 text-blue-700 hover:bg-blue-200 transition font-medium">
                                        Edit
                                    </a>
                                @else
                                    <a href="{{ \App\Filament\Resources\SppPaymentResource::getUrl('create') }}?student_id={{ $data['id'] }}&bulan={{ $bulan_filter }}"
                                        class="text-xs px-2 py-1 rounded bg-green-100 text-green-700 hover:bg-green-200 transition font-medium">
                                        Catat
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-filament-panels::page>
