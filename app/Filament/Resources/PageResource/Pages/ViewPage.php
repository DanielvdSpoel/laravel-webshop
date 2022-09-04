<?php

namespace App\Filament\Resources\PageResource\Pages;

use App\Filament\Resources\PageResource;
use App\Models\PageType;
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

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $pageType = PageType::find($this->record->page_type_id);
        $data[$pageType->name . '_content'] = $this->record->content;
        return $data;
    }
}
