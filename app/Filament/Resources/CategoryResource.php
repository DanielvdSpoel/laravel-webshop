<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Filament\Resources\CategoryResource\RelationManagers;
use App\Models\Brand;
use App\Models\Category;
use App\Models\PageType;
use App\Supports\FilamentFormLayout;
use Closure;
use Filament\Forms;
use Filament\Forms\Components\BelongsToManyMultiSelect;
use Filament\Forms\Components\BelongsToSelect;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TagsColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CategoryResource extends Resource
{
    use Translatable;

    public static function getTranslatableLocales(): array
    {
        return array_keys(config('webshop.available_languages', ['en']));
    }

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
            ->schema(
                FilamentFormLayout::make()
                    ->hasSlugAndName()
                    ->hasTimestamps()
                    ->appendToLeftColumn([
                        Card::make()
                            ->schema([
                                Forms\Components\MarkdownEditor::make('description')
                                    ->label(__('forms.labels.description')),
                            ]),
                    ])
                    ->appendToRightColumn([
                        Card::make()
                            ->schema([
                                Select::make('parent_id')
                                    ->label(__('forms.labels.parent_category'))
                                    ->options(function (?Model $record) {
                                        if ($record) {
                                            return Category::where('id', '!=', $record->id)
                                                ->whereNull('parent_id')
                                                ->pluck('name', 'id');
                                        }
                                        return Category::pluck('name', 'id');
                                    })
                                    ->searchable()
                                    ->preload(),
                            ]),
                    ])
                    ->get()
            )->columns([
                'sm' => 3,
                'lg' => null,
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('forms.labels.name'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('parent.name')
                    ->label(__('forms.labels.parent_category'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('product_count')
                    ->getStateUsing(fn(?Category $record): ?string => $record ? $record->products->count() : null)
                    ->label(__('forms.labels.product_count'))
                    ->sortable(),
                Tables\Columns\BooleanColumn::make('is_visible')
                    ->label(__('forms.labels.is_visible'))
                    ->sortable(),
                TagsColumn::make('children')->getStateUsing(fn(?Category $record): ?array => $record->children()->pluck('name')->toArray())
                    ->label(__('forms.labels.children_categories'))
            ])
            ->filters([
                SelectFilter::make('parent_id')->relationship('parent', 'name')->label(__('forms.labels.parent_category')),
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
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'view' => Pages\ViewCategory::route('/{record}'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}
