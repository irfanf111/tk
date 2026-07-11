<?php

namespace App\Filament\Resources\SppPaymentResource\Pages;

use App\Filament\Resources\SppPaymentResource;
use App\Models\SppPayment;
use App\Models\Student;
use Filament\Resources\Pages\Page;
use Illuminate\Support\Carbon;

class RekapSppPayment extends Page
{
    protected static string $resource = SppPaymentResource::class;
    protected static string $view     = 'filament.pages.rekap-spp';

    protected static ?string $title = 'Rekap Pembayaran SPP';

    public string $bulan_filter;

    public function mount(): void
    {
        $this->bulan_filter = now()->format('Y-m');
    }

    public function getBulanOptions(): array
    {
        // Ambil semua bulan yang ada di database + bulan saat ini
        $bulanDiDB = SppPayment::select('bulan')->distinct()->pluck('bulan')->toArray();
        $now       = now();

        // Tambahkan 3 bulan ke depan dan 6 bulan ke belakang
        $months = [];
        for ($i = -6; $i <= 3; $i++) {
            $months[] = $now->copy()->addMonths($i)->format('Y-m');
        }

        $allMonths = collect(array_unique(array_merge($months, $bulanDiDB)))->sort()->reverse()->values();

        $options = [];
        foreach ($allMonths as $m) {
            try {
                $label = Carbon::createFromFormat('Y-m', $m)->translatedFormat('F Y');
                $options[$m] = $label;
            } catch (\Exception $e) {
                $options[$m] = $m;
            }
        }

        return $options;
    }

    public function getStudentsWithStatus(): \Illuminate\Support\Collection
    {
        $bulan    = $this->bulan_filter;
        $students = Student::orderBy('nama_lengkap')->get();

        return $students->map(function ($student) use ($bulan) {
            $payment = SppPayment::where('student_id', $student->id)
                ->where('bulan', $bulan)
                ->first();

            return [
                'id'           => $student->id,
                'nama'         => $student->nama_lengkap ?? 'Siswa #' . $student->id,
                'status'       => $payment?->status ?? 'belum',
                'nominal'      => $payment?->nominal,
                'tanggal_bayar'=> $payment?->tanggal_bayar,
                'keterangan'   => $payment?->keterangan,
                'payment_id'   => $payment?->id,
            ];
        });
    }

    public function getSummary(): array
    {
        $data  = $this->getStudentsWithStatus();
        $total = $data->count();
        $lunas = $data->where('status', 'lunas')->count();
        $belum = $total - $lunas;

        return compact('total', 'lunas', 'belum');
    }
}
