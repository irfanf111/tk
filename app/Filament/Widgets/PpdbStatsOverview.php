<?php

namespace App\Filament\Widgets;

use App\Models\Registration;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class PpdbStatsOverview extends BaseWidget
{
    // Jangan tampilkan di Dashboard global — hanya muncul di halaman PPDB
    protected static bool $isDiscovered = false;

    protected static ?string $pollingInterval = '30s';

    protected function getStats(): array
    {
        $submitted    = Registration::where('status', Registration::STATUS_SUBMITTED)->count();
        $verified     = Registration::where('status', Registration::STATUS_VERIFIED)->count();
        $rejected     = Registration::where('status', Registration::STATUS_REJECTED)->count();
        $accepted     = Registration::where('status', Registration::STATUS_ACCEPTED)->count();
        $notAccepted  = Registration::where('status', Registration::STATUS_NOT_ACCEPTED)->count();
        $total        = Registration::whereIn('status', [
            Registration::STATUS_SUBMITTED,
            Registration::STATUS_VERIFIED,
            Registration::STATUS_REJECTED,
            Registration::STATUS_ACCEPTED,
            Registration::STATUS_NOT_ACCEPTED,
        ])->count();

        return [
            Stat::make('Total Pendaftar', $total)
                ->description('Semua pendaftar aktif')
                ->descriptionIcon('heroicon-m-clipboard-document-list')
                ->color('primary'),

            Stat::make('Menunggu Verifikasi', $submitted)
                ->description('Perlu tindakan segera')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),

            Stat::make('Terverifikasi', $verified)
                ->description('Sedang dalam proses')
                ->descriptionIcon('heroicon-m-shield-check')
                ->color('info'),

            Stat::make('Dikembalikan', $rejected)
                ->description('Perlu perbaikan dokumen')
                ->descriptionIcon('heroicon-m-arrow-uturn-left')
                ->color('danger'),

            Stat::make('Diterima', $accepted)
                ->description('Resmi diterima sebagai siswa baru')
                ->descriptionIcon('heroicon-m-check-badge')
                ->color('success'),

            Stat::make('Tidak Diterima', $notAccepted)
                ->description('Tidak memenuhi syarat / kuota penuh')
                ->descriptionIcon('heroicon-m-x-circle')
                ->color('gray'),
        ];
    }
}
