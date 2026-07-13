<?php

namespace App\Filament\Resources\TagihanSppResource\Pages;

use App\Filament\Resources\TagihanSppResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTagihanSpps extends ListRecords
{
    protected static string $resource = TagihanSppResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Buat Tagihan Manual'),
        ];
    }
}
