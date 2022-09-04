<?php

namespace App\Supports;

use App\Models\Category;
use App\Models\PageType;
use Closure;
use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use FilamentCurator\Forms\Components\MediaPicker;

class PageBlocksSupport
{
    static function getContentBuilder(string $pageType, array $blocks): Builder
    {
        return Builder::make($pageType . '_content')
            ->label(__('forms.labels.content'))
            ->blocks($blocks)
            ->hidden(function (Closure $get) use ($pageType) {
                $type = PageType::where('name', $pageType)->first();
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

            Block::make('category_products_list')
                ->label(__('blocks.category_products_list'))
                ->icon('heroicon-o-photograph')
                ->schema([
                    Select::make('category')
                        ->options(Category::all()->pluck('name', 'id'))
                        ->searchable()
                        ->preload()
                        ->label(__('forms.labels.category'))
                        ->required(),
                    TextInput::make('product_count')
                        ->label(__('forms.labels.product_count'))
                        ->numeric()
                        ->minValue(1)
                        ->required(),
                    TextInput::make('header_text')
                        ->label(__('forms.labels.header_text'))
                        ->required(),
                    Select::make('sort_by')
                        ->options([
                            'latest' => __('forms.labels.latest'),
                            'most_purchased' => __('forms.labels.most_purchased'),
                        ])


                ])


        ];

    }


}
