<?php

namespace App\Supports;

use App\Forms\Components\MediaPicker;
use App\Models\PageType;
use Closure;
use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\TextInput;

class PageBlocksSupport
{
    static function getContentBuilder(string $pageType, array $blocks): Builder
    {
        return Builder::make($pageType . '_content')
            ->label(__('forms.labels.content'))
            ->blocks($blocks)
            ->hidden(function (Closure $get) use ($pageType) {
                $type = PageType::where('name', $pageType .  '_page')->first();
                return $get('type_id') != $type->id;
            });
    }
    static function getBrandPageBlocks(): array
    {
        return [

        ];
    }

    static function getProductPageBlocks(): array
    {
        return [

        ];
    }

    static function getCategoryPageBlocks(): array
    {
        return [

        ];
    }

    static function getBasicPageBlocks(): array
    {
        return [
            Block::make('heading_with_background')
                ->label(__('blocks.full-width_with_background'))
                ->icon('heroicon-o-photograph')
                ->schema([
                    TextInput::make('button_url')
                        ->label(__('forms.labels.button_url'))
                        ->required(),
                    TextInput::make('button_text')
                        ->label(__('forms.labels.button_text'))
                        ->required(),
                    TextInput::make('section_title')
                        ->label(__('forms.labels.section_title'))
                        ->required(),
                    TextInput::make('section_description')
                        ->label(__('forms.labels.section_description'))
                        ->required(),
                    FileUpload::make('background')
                        ->label(__('forms.labels.background'))
                        ->image()
                ])

        ];

    }


}
