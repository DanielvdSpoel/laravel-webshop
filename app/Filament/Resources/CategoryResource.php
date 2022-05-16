<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Filament\Resources\CategoryResource\RelationManagers;
use App\Models\Brand;
use App\Models\Category;
use Closure;
use Filament\Forms;
use Filament\Forms\Components\BelongsToManyMultiSelect;
use Filament\Forms\Components\BelongsToSelect;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';

    public array $permissions = ['view', 'create', 'update', 'delete', 'view_any', 'delete_any', 'export'];

    public static function getNavigationGroup(): string
    {
        return __('resources.groups.shop');
    }

    public static function getLabel(): string
    {
        return __('resources.categories.label');
    }

    public static function getPluralLabel(): string
    {
        return __('resources.categories.label_plural');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()
                    ->schema(static::getFormFields())
                    ->columnSpan([
                        'sm' => 2,
                    ]),
                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\Placeholder::make('created_at')
                            ->label(__('forms.labels.created_at'))
                            ->content(fn(?Category $record): string => $record ? $record->created_at->diffForHumans() : '-'),
                        Forms\Components\Placeholder::make('updated_at')
                            ->label(__('forms.labels.updated_at'))
                            ->content(fn(?Category $record): string => $record ? $record->updated_at->diffForHumans() : '-'),
                    ])
                    ->columnSpan(1),
            ])
            ->columns([
                'sm' => 3,
                'lg' => null,
            ]);
    }

    public static function getFormFields(): array
    {
        return [
            Forms\Components\Grid::make()
                ->schema([
                    Forms\Components\TextInput::make('name')
                        ->label(__('forms.labels.name'))
                        ->required()
                        ->reactive()
                        ->afterStateUpdated(fn($state, callable $set) => $set('slug', Str::slug($state))),
                    Forms\Components\TextInput::make('slug')
                        ->label(__('forms.labels.slug'))
                        ->disabled()
                        ->required()
                        ->unique(Category::class, 'slug', fn($record) => $record),
                ]),

            Forms\Components\Toggle::make('is_visible')
                ->label(__('forms.labels.is_visible'))
                ->default(true),
            Forms\Components\MarkdownEditor::make('description')
                ->label(__('forms.labels.description')),

            Forms\Components\Grid::make()
                ->schema([
                    BelongsToSelect::make('parent_id')
                        ->label(__('forms.labels.parent_category'))
                        ->relationship('parent', 'name'),

                    /*BelongsToManyMultiSelect::make('children')
                        ->label(__('forms.labels.children_categories'))
                        ->relationship('children', 'name'),*/

                    /*Select::make('children')
                        ->options(fn(callable $get) => Category::query()->whereNull('parent_id')->where('id', '!=', $get('parent_id'))->pluck('name', 'id')
                        )->multiple()->searchable(),*/

                ]),
        ];
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('slug'),
                Tables\Columns\BooleanColumn::make('is_visible'),
                Tables\Columns\TextColumn::make('parent_id'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime(),
            ])
            ->filters([
                //
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
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'view' => Pages\ViewCategory::route('/{record}'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}
