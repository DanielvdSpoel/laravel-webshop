<?php

namespace App\Filament\Resources\MediaResource\Pages;

use Filament\Pages\Actions\Action;
use Filament\Pages\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use MediaResource;

class EditMedia extends EditRecord
{
    protected static string $resource = MediaResource::class;

    public function getActions(): array
    {
        return [
            Action::make('save')->action('save'),
            Action::make('preview')->color('secondary')->url($this->record->url)->openUrlInNewTab(),
            DeleteAction::make(),
        ];
    }
}
