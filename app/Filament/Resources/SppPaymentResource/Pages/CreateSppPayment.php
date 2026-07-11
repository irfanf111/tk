<?php

namespace App\Filament\Resources\SppPaymentResource\Pages;

use App\Filament\Resources\SppPaymentResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateSppPayment extends CreateRecord
{
    protected static string $resource = SppPaymentResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Pastikan dicatat_oleh terisi dengan admin yang sedang login
        $data['dicatat_oleh'] = $data['dicatat_oleh'] ?? Auth::id();
        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
