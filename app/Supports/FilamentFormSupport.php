<?php

namespace App\Supports;

use App\Models\Page;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Placeholder;

class FilamentFormSupport
{
    static function getTimestampCard(): Card
    {
        return Card::make()
            ->schema([
                Placeholder::make('created_at')
                    ->label(__('forms.labels.created_at'))
                    ->content(fn(?Page $record): string => $record ? $record->created_at->diffForHumans() : '-'),
                Placeholder::make('updated_at')
                    ->label(__('forms.labels.updated_at'))
                    ->content(fn(?Page $record): string => $record ? $record->updated_at->diffForHumans() : '-'),
            ])
            ->columnSpan(1);

    }

}
