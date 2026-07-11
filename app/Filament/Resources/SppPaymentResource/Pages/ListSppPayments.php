<?php

namespace App\Filament\Resources\SppPaymentResource\Pages;

use App\Filament\Resources\SppPaymentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSppPayments extends ListRecords
{
    protected static string $resource = SppPaymentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('rekap')
                ->label('Lihat Rekap')
                ->icon('heroicon-o-table-cells')
                ->color('info')
                ->url(SppPaymentResource::getUrl('rekap')),

            Actions\CreateAction::make()
                ->label('Catat Pembayaran'),
        ];
    }
}
