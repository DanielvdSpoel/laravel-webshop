<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Brand;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Components\BelongsToSelect;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Support\Str;

class ProductResource extends Resource
{
    use Translatable;

    public static function getTranslatableLocales(): array
    {
        return array_keys(config('webshop.available_languages', ['en']));
    }

    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public array $permissions = ['view', 'create', 'update', 'delete', 'view_any', 'delete_any', 'export'];

    public static function getNavigationGroup(): string
    {
        return __('resources.groups.shop');
    }

    public static function getLabel(): string
    {
        return __('resources.products.label');
    }

    public static function getPluralLabel(): string
    {
        return __('resources.products.label_plural');
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
                                        Forms\Components\TextInput::make('name')
                                            ->required()
                                            ->label(__('forms.labels.name'))
                                            ->reactive()
                                            ->afterStateUpdated(fn($state, callable $set) => $set('slug', Str::slug($state))),
                                        Forms\Components\TextInput::make('slug')
                                            ->label(__('forms.labels.slug'))
                                            ->disabled()
                                            ->required()
                                            ->unique(Product::class, 'slug', fn($record) => $record),
                                        Forms\Components\MarkdownEditor::make('description')
                                            ->label(__('forms.labels.description'))
                                            ->toolbarButtons([
                                                'bold',
                                                'edit',
                                                'italic',
                                                'link',
                                                'preview',
                                                'strike',
                                            ])
                                            ->columnSpan([
                                                'sm' => 2,
                                            ]),
                                    ])->columns([
                                        'sm' => 2,
                                        'lg' => null,
                                    ])

                            ]),
                        Card::make()
                            ->schema([
                                SpatieMediaLibraryFileUpload::make('images')
                                    ->label(__('forms.labels.images'))
                                    ->multiple()
                                    ->enableReordering(),
                            ]),
                    ])->columnSpan([
                        'sm' => 2,
                    ]),
                Forms\Components\Group::make()
                    ->schema([
                        Card::make()
                            ->schema([
                                Placeholder::make(__('forms.labels.visibility'))
                            ])->columnSpan(1),
                        Card::make()
                            ->schema([
                                Placeholder::make(__('forms.labels.connections')),
                                BelongsToSelect::make('brand_id')
                                    ->relationship('brand', 'name')
                                    ->createOptionForm(BrandResource::getFormFields())
                                    ->label(__('forms.labels.brand'))
                                    ->searchable()
                                    ->preload(),
                                Forms\Components\BelongsToManyMultiSelect::make('categories')
                                    ->relationship('categories', 'name')
                                    ->createOptionForm(CategoryResource::getFormFields())
                                    ->label(__('forms.labels.categories'))
                                    ->searchable()
                                    ->preload(),

                            ])->columnSpan(1),
                        Forms\Components\Card::make()
                            ->schema([
                                Forms\Components\Placeholder::make('created_at')
                                    ->label(__('forms.labels.created_at'))
                                    ->content(fn(?Product $record): string => $record ? $record->created_at->diffForHumans() : '-'),
                                Forms\Components\Placeholder::make('updated_at')
                                    ->label(__('forms.labels.updated_at'))
                                    ->content(fn(?Product $record): string => $record ? $record->updated_at->diffForHumans() : '-'),
                            ])
                            ->columnSpan(1),
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
                SpatieMediaLibraryImageColumn::make('images')->label(''), //__('forms.labels.images')
                TextColumn::make('name')->label(__('forms.labels.name'))->searchable()->sortable(),
                TextColumn::make('description')->limit('50')->label(__('forms.labels.description'))->searchable()->wrap(),
                TextColumn::make('brand.name')->label(__('forms.labels.brand'))->searchable()->sortable(),
            ])
            ->filters([
                SelectFilter::make('brand')->relationship('brand', 'name')->label(__('forms.labels.brand')),

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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'view' => Pages\ViewProduct::route('/{record}'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
