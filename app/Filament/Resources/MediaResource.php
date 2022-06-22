<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MediaResource\Pages;
use App\Filament\Resources\MediaResource\RelationManagers;
use App\Models\Page;
use App\Models\Product;
use App\Supports\FilamentFormSupport;
use App\Supports\PageBlocksSupport;
use Filament\Forms\Components\BelongsToSelect;
use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class MediaResource extends Resource
{
    public array $permissions = ['view', 'create', 'update', 'delete', 'view_any', 'delete_any'];

    protected static ?string $model = Media::class;

    protected static ?string $navigationIcon = 'heroicon-o-photograph';

    public static function getNavigationGroup(): string
    {
        return __('resources.groups.content');
    }

    public static function getLabel(): string
    {
        return __('resources.media.label');
    }

    public static function getPluralLabel(): string
    {
        return __('resources.media.label_plural');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()
                    ->schema([
                        Section::make(__('forms.labels.image'))
                            ->schema([
                                FileUpload::make('image')
                                    ->disableLabel()
                                    ->panelAspectRatio('2:1')
                            ]),
                    ])->columnSpan([
                        'sm' => 2,
                    ]),

                //Card::make()

                Group::make()
                    ->schema([
                        Section::make(__('forms.labels.meta'))
                            ->schema([
                                TextInput::make('name')
                                    ->label(__('forms.labels.name')),
                                TextInput::make('alt')
                                    ->label(__('forms.labels.alt'))
                                    ->helperText(__('forms.helpers.alt')),
                            ]),
                        FilamentFormSupport::getTimestampCard()->visibleOn(Pages\EditMedia::class)
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
                //
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
            'index' => Pages\ListMedia::route('/'),
            'create' => Pages\CreateMedia::route('/create'),
            'view' => Pages\ViewMedia::route('/{record}'),
            'edit' => Pages\EditMedia::route('/{record}/edit'),
        ];
    }
}
