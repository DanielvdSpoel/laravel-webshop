<?php

namespace App\Supports;

use Closure;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class FilamentFormLayout
{
    public array $leftColumnContent = [];
    public array $rightColumnContent = [];
    public array $mainCardContent = [];
    public bool $hasTimestamps = false;

    static function make(): FilamentFormLayout
    {
        return new FilamentFormLayout();
    }

    public function hasSlugAndName(): FilamentFormLayout
    {
        array_push($this->mainCardContent,
            TextInput::make('name')
                ->label(__('forms.labels.name'))
                ->afterStateUpdated(function (Closure $get, Closure $set, ?string $state) {
                    if (!$get('is_slug_changed_manually') && filled($state)) {
                        $set('slug', Str::slug($state));
                    }
                })
                ->reactive()
                ->required(),
            TextInput::make('slug')
                ->label(__('forms.labels.slug'))
                ->afterStateUpdated(function (Closure $set) {
                    $set('is_slug_changed_manually', true);
                })
                ->required(),
            Hidden::make('is_slug_changed_manually')
                ->default(false)
                ->dehydrated(false),
        );
        return $this;
    }

    public function hasTimestamps($hasTimestamps = true): FilamentFormLayout
    {
        $this->hasTimestamps = $hasTimestamps;
        return $this;
    }

    /*public function hasVisibility($hasVisibility = true): FilamentFormLayout
    {
        $this->hasVisibility = $hasVisibility;
        return $this;
    }*/

    public function appendToLeftColumn(array $content): FilamentFormLayout
    {
        array_push($this->leftColumnContent, ...$content);
        return $this;
    }

    public function appendToRightColumn(array $content): FilamentFormLayout
    {
        array_push($this->rightColumnContent, ...$content);
        return $this;
    }

    public function appendToMainCard(array $content): FilamentFormLayout
    {
        array_push($this->mainCardContent, ...$content);
        return $this;
    }

    public function get(): array
    {
        array_unshift($this->leftColumnContent,
            Card::make()
                ->schema([
                    Grid::make()
                        ->schema($this->mainCardContent)->columns([
                            'sm' => 2,
                            'lg' => null,
                        ])

                ]));
        if ($this->hasTimestamps) {
            $this->rightColumnContent[] = Card::make()
                ->schema([
                    Placeholder::make('created_at')
                        ->label(__('forms.labels.created_at'))
                        ->content(fn(?Model $record): string => $record ? $record->created_at->diffForHumans() : '-'),
                    Placeholder::make('updated_at')
                        ->label(__('forms.labels.updated_at'))
                        ->content(fn(?Model $record): string => $record ? $record->updated_at->diffForHumans() : '-'),
                ])->hidden(fn(?Model $record): bool => !$record);
        }



        return [
            Group::make()
                ->schema($this->leftColumnContent)->columnSpan([
                    'sm' => 2,
                ]),
            Group::make()
                ->schema($this->rightColumnContent)->columnSpan(1),
        ];




        //todo implement visibility

    }


}
