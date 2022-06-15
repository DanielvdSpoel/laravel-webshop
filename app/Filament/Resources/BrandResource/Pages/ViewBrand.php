<?php

namespace App\Filament\Resources\BrandResource\Pages;

use App\Filament\Resources\BrandResource;
use Filament\Pages\Actions\EditAction;
use Filament\Pages\Actions\LocaleSwitcher;
use Filament\Resources\Pages\ViewRecord;

class ViewBrand extends ViewRecord
{
    protected static string $resource = BrandResource::class;

    use ViewRecord\Concerns\Translatable;

    public static function getTranslatableLocales(): array
    {
        return array_keys(config('webshop.available_languages', ['en']));
    }

    protected function getActions(): array
    {
        return [
            EditAction::make(),
            LocaleSwitcher::make(),
        ];
    }
}
