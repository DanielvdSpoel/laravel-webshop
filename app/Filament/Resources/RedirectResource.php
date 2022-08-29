<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RedirectResource\Pages;
use App\Filament\Resources\RedirectResource\RelationManagers;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Page;
use App\Models\Product;
use App\Models\Redirect;
use App\Supports\FilamentFormsSupport;
use Closure;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Resources\Concerns\Translatable;
use FilamentCurator\Forms\Components\MediaPicker;
use Illuminate\Database\Eloquent\Model;


class RedirectResource extends Resource
{
    use Translatable;

    protected static ?string $model = Redirect::class;

    protected static ?string $navigationIcon = 'heroicon-o-switch-horizontal';

    public array $permissions = ['view', 'create', 'update', 'delete', 'view_any', 'delete_any', 'export'];

    public static function getNavigationGroup(): string
    {
        return __('resources.groups.content');
    }

    public static function getLabel(): string
    {
        return __('resources.redirects.label');
    }

    public static function getPluralLabel(): string
    {
        return __('resources.redirects.label_plural');
    }

    public static function getTranslatableLocales(): array
    {
        return array_keys(config('webshop.available_languages', ['en']));
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Card::make()
                            ->schema([
                                Forms\Components\Grid::make()
                                    ->schema([
                                        //MediaPicker::make('background'),
                                        MediaPicker::make('background'),
                                        Forms\Components\TextInput::make('source')
                                            ->label(__('forms.labels.source'))
                                            ->placeholder(__('forms.placeholders.source'))
                                            ->helperText(__('forms.helpers.source'))
                                            ->required(),
                                        Select::make('status_code')
                                            ->label(__('forms.labels.status_code'))
                                            ->options([
                                                '301' => __('forms.options.status_code.301'),
                                                '302' => __('forms.options.status_code.302'),
                                                '303' => __('forms.options.status_code.303'),
                                                '307' => __('forms.options.status_code.307'),
                                                '308' => __('forms.options.status_code.308'),
                                            ])
                                            ->default('301')
                                            ->required(),
                                        Select::make('target_type')
                                            ->label(__('forms.labels.target_type'))
                                            ->afterStateHydrated(function (Select $component, $state, ?Model $record) {
                                                if ($record) {
                                                    if ($record->destination) {
                                                        $component->state('url');
                                                    }
                                                    switch ($record->redirectable_type) {
                                                        case Category::class:
                                                            $component->state('category');
                                                            break;
                                                        case Product::class:
                                                            $component->state('product');
                                                            break;
                                                        case Brand::class:
                                                            $component->state('brand');
                                                            break;
                                                        case Page::class:
                                                            $component->state('page');
                                                            break;
                                                    }
                                                    ray($record);
                                                }
                                            })
                                            ->options([
                                                'page' => __('forms.options.target_type.page'),
                                                'product' => __('forms.options.target_type.product'),
                                                'category' => __('forms.options.target_type.category'),
                                                'url' => __('forms.options.target_type.url'),
                                                'brand' => __('forms.options.target_type.brand'),
                                            ])
                                            ->afterStateUpdated(function (Closure $set) {
                                                $set('redirectable_type', null);
                                                $set('redirectable_id', null);
                                            })
                                            ->required()
                                            ->reactive(),

                                        Forms\Components\TextInput::make('destination')
                                            ->label(__('forms.labels.destination'))
                                            ->hidden(function (Closure $get) {
                                                return $get('target_type') !== 'url';
                                            })
                                            ->placeholder(__('forms.placeholders.destination'))
                                            ->required(),
                                        Select::make('page')
                                            ->options(Page::all()->pluck('name', 'id'))
                                            ->hidden(function (Closure $get) {
                                                return $get('target_type') !== 'page';
                                            })
                                            ->afterStateUpdated(function (Closure $set, $state) {
                                                $set('redirectable_type', Page::class);
                                                $set('redirectable_id', $state);
                                            })
                                            ->afterStateHydrated(function (Select $component, $state, ?Model $record) {
                                                if ($record && $record->redirectable_type === Page::class) {
                                                    $component->state($record->redirectable_id);
                                                }
                                            })
                                            ->label(__('forms.labels.page'))
                                            ->searchable()
                                            ->required()
                                            ->preload(),
                                        Select::make('category')
                                            ->options(Category::all()->pluck('name', 'id'))
                                            ->hidden(function (Closure $get) {
                                                return $get('target_type') !== 'category';
                                            })
                                            ->afterStateHydrated(function (Select $component, $state, ?Model $record) {
                                                if ($record && $record->redirectable_type === Category::class) {
                                                    $component->state($record->redirectable_id);
                                                }
                                            })
                                            ->afterStateUpdated(function (Closure $set, $state) {
                                                $set('redirectable_type', Category::class);
                                                $set('redirectable_id', $state);
                                            })
                                            ->label(__('forms.labels.category'))
                                            ->searchable()
                                            ->required()
                                            ->preload(),


                                        Select::make('product')
                                            ->options(Product::all()->pluck('name', 'id'))
                                            ->hidden(function (Closure $get) {
                                                return $get('target_type') !== 'product';
                                            })
                                            ->afterStateUpdated(function (Closure $set, $state) {
                                                $set('redirectable_type', Product::class);
                                                $set('redirectable_id', $state);
                                            })
                                            ->afterStateHydrated(function (Select $component, $state, ?Model $record) {
                                                if ($record && $record->redirectable_type === Product::class) {
                                                    $component->state($record->redirectable_id);
                                                }
                                            })
                                            ->label(__('forms.labels.product'))
                                            ->searchable()
                                            ->required()
                                            ->preload(),

                                        Select::make('brand')
                                            ->options(Brand::all()->pluck('name', 'id'))
                                            ->hidden(function (Closure $get) {
                                                return $get('target_type') !== 'brand';
                                            })
                                            ->afterStateUpdated(function (Closure $set, $state) {
                                                $set('redirectable_type', Product::class);
                                                $set('redirectable_id', $state);
                                            })
                                            ->afterStateHydrated(function (Select $component, $state, ?Model $record) {
                                                if ($record && $record->redirectable_type === Brand::class) {
                                                    $component->state($record->redirectable_id);
                                                }
                                            })
                                            ->label(__('forms.labels.brand'))
                                            ->searchable()
                                            ->required()
                                            ->preload(),

                                        Forms\Components\Hidden::make('redirectable_id'),
                                        Forms\Components\Hidden::make('redirectable_type')


                                    ])->columns([
                                        'sm' => 2,
                                        'lg' => null,
                                    ])

                            ]),
                    ])->columnSpan([
                        'sm' => 2,
                    ]),
                Forms\Components\Group::make()
                    ->schema([
                        FilamentFormsSupport::timestampCard()->hiddenOn(Pages\CreateRedirect::class)

                    ])->columnSpan(1),
            ])->columns([
                'sm' => 3,
                'lg' => null,
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('source')
                    ->label(__('forms.labels.source'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('destination')
                    ->label(__('forms.labels.destination'))
                    ->getStateUsing(function (Model $record) {
                        if ($record->destination) {
                            return $record->destination;
                        }
                        if ($record->redirectable_type === Page::class) {
                            return "page";
                        }
                        if ($record->redirectable_type === Category::class) {
                            return "category";
                        }
                        if ($record->redirectable_type === Product::class) {
                            return "product";
                        }
                        return null;
                    })
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status_code')
                    ->label(__('forms.labels.status_code'))
                    ->formatStateUsing(function (string $state) {
                        return __('forms.options.status_code.' . $state);
                    })
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRedirects::route('/'),
            'create' => Pages\CreateRedirect::route('/create'),
            'view' => Pages\ViewRedirect::route('/{record}'),
            'edit' => Pages\EditRedirect::route('/{record}/edit'),
        ];
    }
}
