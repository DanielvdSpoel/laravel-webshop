<?php

namespace App\Supports;

use App\Models\Product;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Placeholder;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component as Livewire;

class FilamentFormsSupport
{

    static function timestampCard(): Card
    {
        return Card::make()
            ->schema([
                Placeholder::make('created_at')
                    ->label(__('forms.labels.created_at'))
                    ->content(fn(?Model $record): string => $record ? $record->created_at->diffForHumans() : '-'),
                Placeholder::make('updated_at')
                    ->label(__('forms.labels.updated_at'))
                    ->content(fn(?Model $record): string => $record ? $record->updated_at->diffForHumans() : '-'),
            ])
            ->columnSpan(1);
    }

}
