<?php

namespace App\Filament\Resources\RegistrationResource\Pages;

use App\Filament\Resources\RegistrationResource;
use App\Models\Registration;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRegistration extends EditRecord
{
    protected static string $resource = RegistrationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make()
                ->label('Lihat Detail'),
            Actions\DeleteAction::make()
                ->label('Hapus'),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Otomatis isi verified_at jika status berubah ke verified/accepted/rejected/not_accepted
        if (
            ! empty($data['status']) &&
            in_array($data['status'], [
                Registration::STATUS_VERIFIED,
                Registration::STATUS_REJECTED,
                Registration::STATUS_ACCEPTED,
                Registration::STATUS_NOT_ACCEPTED,
            ]) &&
            empty($data['verified_at'])
        ) {
            $data['verified_at'] = now();
        }

        // Otomatis isi verified_by dengan admin yang sedang login jika belum diisi
        if (! empty($data['status']) && $data['status'] !== Registration::STATUS_DRAFT && empty($data['verified_by'])) {
            $data['verified_by'] = auth()->id();
        }

        return $data;
    }
}
