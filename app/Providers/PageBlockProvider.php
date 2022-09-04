<?php

namespace App\Providers;

use App\Models\Category;
use App\Supports\PageBlock;
use App\Supports\PageBlockManager;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use FilamentCurator\Forms\Components\MediaPicker;
use Illuminate\Support\ServiceProvider;

class PageBlockProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(PageBlockManager::class, function ($app) {
            return new PageBlockManager();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(PageBlockManager $pageBlockManager)
    {
        $pageBlockManager->addBlock(new PageBlock('split_hero', __('blocks.split_hero'), 'heroicon-o-photograph', ['basic'], [
            Repeater::make('buttons')
                ->label(__('forms.labels.buttons'))
                ->schema([
                    TextInput::make('button_url')
                        ->label(__('forms.labels.button_url'))
                        ->required(),
                    TextInput::make('button_text')
                        ->label(__('forms.labels.button_text'))
                        ->required(),
                ]),
            TextInput::make('section_title')
                ->label(__('forms.labels.section_title'))
                ->required(),
            TextInput::make('section_description')
                ->label(__('forms.labels.section_description'))
                ->required(),
            MediaPicker::make('background')
                ->label(__('forms.labels.background')),
        ]));
        $pageBlockManager->addBlock(new PageBlock('heading_with_background', __('blocks.full_width_with_background'), 'heroicon-o-photograph', ['basic'], [
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
            MediaPicker::make('background')
                ->label(__('forms.labels.background')),
        ]));
        $pageBlockManager->addBlock(new PageBlock('category_products_list', __('blocks.category_products_list'), 'heroicon-o-photograph', ['basic'], [
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
        ]));

    }
}
