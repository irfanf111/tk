<?php

namespace App\Filament\Resources\RegistrationResource\Pages;

use App\Filament\Resources\RegistrationResource;
use App\Filament\Widgets\PpdbStatsOverview;
use App\Models\Registration;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListRegistrations extends ListRecords
{
    protected static string $resource = RegistrationResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }

    // ─── Tabs Filter Berdasarkan Status ───────────────────────────────────────

    public function getTabs(): array
    {
        $counts = Registration::selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        return [
            'all' => Tab::make('Semua')
                ->icon('heroicon-m-list-bullet')
                ->badge(Registration::whereIn('status', [
                    Registration::STATUS_SUBMITTED,
                    Registration::STATUS_VERIFIED,
                    Registration::STATUS_REJECTED,
                    Registration::STATUS_ACCEPTED,
                    Registration::STATUS_NOT_ACCEPTED,
                ])->count() ?: null),

            Registration::STATUS_SUBMITTED => Tab::make('Menunggu Verifikasi')
                ->icon('heroicon-m-clock')
                ->badgeColor('warning')
                ->badge($counts->get(Registration::STATUS_SUBMITTED) ?: null)
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', Registration::STATUS_SUBMITTED)),

            Registration::STATUS_VERIFIED => Tab::make('Terverifikasi')
                ->icon('heroicon-m-shield-check')
                ->badgeColor('info')
                ->badge($counts->get(Registration::STATUS_VERIFIED) ?: null)
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', Registration::STATUS_VERIFIED)),

            Registration::STATUS_REJECTED => Tab::make('Dikembalikan')
                ->icon('heroicon-m-arrow-uturn-left')
                ->badgeColor('danger')
                ->badge($counts->get(Registration::STATUS_REJECTED) ?: null)
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', Registration::STATUS_REJECTED)),

            Registration::STATUS_ACCEPTED => Tab::make('Diterima')
                ->icon('heroicon-m-check-badge')
                ->badgeColor('success')
                ->badge($counts->get(Registration::STATUS_ACCEPTED) ?: null)
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', Registration::STATUS_ACCEPTED)),

            Registration::STATUS_NOT_ACCEPTED => Tab::make('Tidak Diterima')
                ->icon('heroicon-m-x-circle')
                ->badgeColor('gray')
                ->badge($counts->get(Registration::STATUS_NOT_ACCEPTED) ?: null)
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', Registration::STATUS_NOT_ACCEPTED)),

            Registration::STATUS_DRAFT => Tab::make('Draft')
                ->icon('heroicon-m-pencil')
                ->badgeColor('gray')
                ->badge($counts->get(Registration::STATUS_DRAFT) ?: null)
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', Registration::STATUS_DRAFT)),
        ];
    }

    // ─── Widget Stats di atas tabel ───────────────────────────────────────────

    protected function getHeaderWidgets(): array
    {
        return [
            PpdbStatsOverview::class,
        ];
    }
}
