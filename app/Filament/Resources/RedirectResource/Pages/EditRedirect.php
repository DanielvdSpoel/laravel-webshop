<?php

namespace App\Filament\Resources\RedirectResource\Pages;

use App\Filament\Resources\RedirectResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRedirect extends EditRecord
{
    use EditRecord\Concerns\Translatable;

    protected static string $resource = RedirectResource::class;

    protected function getActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
            Actions\LocaleSwitcher::make(),
        ];
    }
}
