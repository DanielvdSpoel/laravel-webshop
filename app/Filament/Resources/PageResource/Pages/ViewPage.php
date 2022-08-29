<?php

namespace App\Filament\Resources\PageResource\Pages;

use App\Filament\Resources\PageResource;
use Filament\Pages\Actions\EditAction;
use Filament\Pages\Actions\LocaleSwitcher;
use Filament\Resources\Pages\ViewRecord;

class ViewPage extends ViewRecord
{
    protected static string $resource = PageResource::class;

    use ViewRecord\Concerns\Translatable;

    protected function getActions(): array
    {
        return [
            EditAction::make(),
            LocaleSwitcher::make(),
        ];
    }
}
