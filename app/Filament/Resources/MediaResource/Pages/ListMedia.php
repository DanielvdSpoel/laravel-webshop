<?php

namespace App\Filament\Resources\MediaResource\Pages;

use App\Filament\Resources\MediaResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\View\View;

class ListMedia extends ListRecords
{
    protected static string $resource = MediaResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make()->label(__('forms.labels.upload'))
        ];
    }
}
