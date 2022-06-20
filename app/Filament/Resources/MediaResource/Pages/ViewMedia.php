<?php

namespace App\Filament\Resources\MediaResource\Pages;

use App\Filament\Resources\MediaResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewMedia extends ViewRecord
{
    protected static string $resource = MediaResource::class;

    protected function getActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
