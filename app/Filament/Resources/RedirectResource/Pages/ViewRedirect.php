<?php

namespace App\Filament\Resources\RedirectResource\Pages;

use App\Filament\Resources\RedirectResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewRedirect extends ViewRecord
{
    use ViewRecord\Concerns\Translatable;

    protected static string $resource = RedirectResource::class;

    protected function getActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),
            Actions\EditAction::make(),
        ];
    }
}
