<?php

namespace App\Filament\Resources\PageResource\Pages;

use App\Filament\Resources\PageResource;
use Filament\Pages\Actions\LocaleSwitcher;
use Filament\Resources\Pages\CreateRecord;

class CreatePage extends CreateRecord
{
    protected static string $resource = PageResource::class;

    use CreateRecord\Concerns\Translatable;

    protected function getActions(): array
    {
        return [
            LocaleSwitcher::make(),
        ];
    }

}
