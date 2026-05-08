<?php

namespace App\Filament\Resources\SchoolIdentityResource\Pages;

use App\Filament\Resources\SchoolIdentityResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSchoolIdentity extends EditRecord
{
    protected static string $resource = SchoolIdentityResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\DeleteAction::make()];
    }
}
