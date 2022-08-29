<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PageResource\Pages;
use App\Filament\Resources\PageResource\RelationManagers;
use App\Models\Page;
use App\Supports\FilamentFormLayout;
use App\Supports\PageBlocksSupport;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Model;

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
            ->schema(
                FilamentFormLayout::make()
                    ->hasSlugAndName()
                    //->hasVisibility()
                    ->appendToLeftColumn([
                        Card::make()
                            ->schema([
                                PageBlocksSupport::getContentBuilder('basic', PageBlocksSupport::getBasicPageBlocks()),
                                PageBlocksSupport::getContentBuilder('brand', PageBlocksSupport::getBrandPageBlocks()),
                                PageBlocksSupport::getContentBuilder('category', PageBlocksSupport::getCategoryPageBlocks()),
                                PageBlocksSupport::getContentBuilder('product', PageBlocksSupport::getProductPageBlocks()),

                            ])
                    ])
                    ->appendToRightColumn([
                        Card::make()
                            ->schema([
                                Select::make('type_id')
                                    ->relationship('type', 'name')
                                    ->getOptionLabelFromRecordUsing(fn(Model $record) => __('forms.options.page_type.' . $record->name))
                                    ->label(__('forms.labels.type'))
                                    ->searchable()
                                    ->reactive()
                                    ->preload(),

                            ])->columnSpan(1),
                    ])
                    ->hasTimestamps()
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
                TextColumn::make('name')->label(__('forms.labels.name'))->searchable()->sortable(),
                Tables\Columns\BooleanColumn::make('is_visible')->label(__('forms.labels.is_visible'))->sortable(),
                TextColumn::make('type.name')->label(__('forms.labels.type'))->searchable()->sortable(),
            ])
            ->filters([
                SelectFilter::make('type')->relationship('type', 'name')->label(__('forms.labels.type')),
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
            'index' => Pages\ListPages::route('/'),
            'create' => Pages\CreatePage::route('/create'),
            'view' => Pages\ViewPage::route('/{record}'),
            'edit' => Pages\EditPage::route('/{record}/edit'),
        ];
    }
}
