<?php

namespace App\Filament\Resources\PageResource\Pages;

use App\Filament\Resources\PageResource;
use Filament\Pages\Actions\DeleteAction;
use Filament\Pages\Actions\LocaleSwitcher;
use Filament\Pages\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditPage extends EditRecord
{
    protected static string $resource = PageResource::class;

    use EditRecord\Concerns\Translatable;

    protected function getActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
            LocaleSwitcher::make(),
        ];
    }

    public function updatedActiveFormLocale(): void
    {
        $this->record->setLocale($this->activeFormLocale);
        $this->fillForm();
    }
}
