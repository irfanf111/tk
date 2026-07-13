<?php

namespace App\Filament\Resources\TagihanSppResource\Pages;

use App\Filament\Resources\TagihanSppResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTagihanSpp extends EditRecord
{
    protected static string $resource = TagihanSppResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
