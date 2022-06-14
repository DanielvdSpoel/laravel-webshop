<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PageResource\Pages;
use App\Filament\Resources\PageResource\RelationManagers;
use App\Models\Page;
use App\Models\PageType;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Components\BelongsToSelect;
use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Support\Str;

class PageResource extends Resource
{
    use Translatable;

    public static function getTranslatableLocales(): array
    {
        return array_keys(config('webshop.available_languages', ['en']));
    }

    protected static ?string $model = Page::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    public array $permissions = ['view', 'create', 'update', 'delete', 'view_any', 'delete_any', 'export'];

    public static function getNavigationGroup(): string
    {
        return __('resources.groups.content');
    }

    public static function getLabel(): string
    {
        return __('resources.pages.label');
    }

    public static function getPluralLabel(): string
    {
        return __('resources.pages.label_plural');
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
                                    ])->columns([
                                        'sm' => 2,
                                        'lg' => null,
                                    ])

                            ]),
                        Card::make()
                            ->schema([
                                Builder::make('content')
                            ])
                    ])->columnSpan([
                        'sm' => 2,
                    ]),
                Forms\Components\Group::make()
                    ->schema([
                        Card::make()
                            ->schema([
                                Placeholder::make(__('forms.labels.visibility')),
                                        Forms\Components\Toggle::make('is_visible')
                                            ->label(__('forms.labels.is_visible'))
                                            ->default(true)
                                            ->required(),
                            ])->columnSpan(1),
                        Card::make()
                            ->schema([
                                BelongsToSelect::make('type_id')
                                    ->relationship('type', 'name')
                                    ->label(__('forms.labels.type'))
                                    ->searchable()
                                    ->reactive()
                                    ->preload(),

                            ])->columnSpan(1),
                        Forms\Components\Card::make()
                            ->schema([
                                Forms\Components\Placeholder::make('created_at')
                                    ->label(__('forms.labels.created_at'))
                                    ->content(fn(?Page $record): string => $record ? $record->created_at->diffForHumans() : '-'),
                                Forms\Components\Placeholder::make('updated_at')
                                    ->label(__('forms.labels.updated_at'))
                                    ->content(fn(?Page $record): string => $record ? $record->updated_at->diffForHumans() : '-'),
                            ])
                            ->columnSpan(1),
                    ])->columnSpan(1),
            ])->columns([
                'sm' => 3,
                'lg' => null,
            ]);
            /*->schema([
                Forms\Components\TextInput::make('name')
                    ->required(),
                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->maxLength(191),
                Forms\Components\TextInput::make('content'),
                Forms\Components\Toggle::make('is_visible')
                    ->required(),
                Forms\Components\Toggle::make('can_be_deleted')
                    ->required(),
                Forms\Components\TextInput::make('page_type_id'),
            ]);*/
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label(__('forms.labels.name'))->searchable()->sortable(),
                Tables\Columns\BooleanColumn::make('is_visible')->label(__('forms.labels.is_visible'))->sortable(),
                TextColumn::make('type.name')->label(__('forms.labels.type'))->searchable()->sortable(),
            ])
            ->filters([
                SelectFilter::make('type')->relationship('type', 'name')->label(__('forms.labels.type')),
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
            'index' => Pages\ListPages::route('/'),
            'create' => Pages\CreatePage::route('/create'),
            'view' => Pages\ViewPage::route('/{record}'),
            'edit' => Pages\EditPage::route('/{record}/edit'),
        ];
    }
}
