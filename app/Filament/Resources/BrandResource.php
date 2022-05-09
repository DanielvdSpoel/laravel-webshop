<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BrandResource\Pages;
use App\Filament\Resources\BrandResource\RelationManagers;
use App\Models\Brand;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Illuminate\Support\Str;

class BrandResource extends Resource
{
    public array $permissions = ['view', 'create', 'update', 'delete', 'view_any', 'delete_any', 'export'];

    protected static ?string $model = Brand::class;

    protected static ?string $navigationIcon = 'heroicon-o-bookmark-alt';

    public static function getNavigationGroup(): string
    {
        return __('resources.groups.store');
    }

    public static function getLabel(): string
    {
        return __('resources.brands.label');
    }

    public static function getPluralLabel(): string
    {
        return __('resources.brands.label_plural');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()
                    ->schema([
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
                                    ->unique(Brand::class, 'slug', fn($record) => $record),
                            ]),
                        FileUpload::make('logo')
                            ->label(__('forms.labels.logo'))
                            ->image(),

                        Forms\Components\Toggle::make('is_visible')
                            ->label(__('forms.labels.is_visible'))
                            ->default(true),
                        Forms\Components\MarkdownEditor::make('description')
                            ->label(__('forms.labels.description'))
                    ])
                    ->columnSpan([
                        'sm' => 2,
                    ]),
                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\Placeholder::make('created_at')
                            ->label(__('forms.labels.created_at'))
                            ->content(fn(?Brand $record): string => $record ? $record->created_at->diffForHumans() : '-'),
                        Forms\Components\Placeholder::make('updated_at')
                            ->label(__('forms.labels.updated_at'))
                            ->content(fn(?Brand $record): string => $record ? $record->updated_at->diffForHumans() : '-'),
                    ])
                    ->columnSpan(1),
            ])
            ->columns([
                'sm' => 3,
                'lg' => null,
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('logo')->label(__('forms.labels.logo')),

                Tables\Columns\TextColumn::make('name')
                    ->label(__('forms.labels.name'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\BooleanColumn::make('is_visible')
                    ->label(__('forms.labels.is_visible'))
                    ->sortable(),
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
            'index' => Pages\ListBrands::route('/'),
            'create' => Pages\CreateBrand::route('/create'),
            'view' => Pages\ViewBrand::route('/{record}'),
            'edit' => Pages\EditBrand::route('/{record}/edit'),
        ];
    }
}
