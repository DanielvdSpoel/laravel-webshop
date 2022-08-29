<?php

use App\Filament\Resources\MediaResource\Pages\CreateMedia;
use App\Filament\Resources\MediaResource\Pages\EditMedia;
use App\Filament\Resources\MediaResource\Pages\ListMedia;
use FilamentCurator\Resources\MediaResource as CuratorMediaResource;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Forms\Components\View;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ViewField;
use Filament\Tables\Actions\DeleteAction;
use Filament\Forms\Components\Placeholder;
use FilamentCurator\Forms\Components\MediaUpload;
use FilamentCurator\Tables\Columns\ThumbnailColumn;

class MediaResource extends CuratorMediaResource
{
    public static function getNavigationGroup(): string
    {
        return __('resources.groups.content');
    }

    public array $permissions = ['view', 'create', 'update', 'delete', 'view_any', 'delete_any', 'export'];

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()
                    ->schema([
                        Section::make(__('filament-curator::resource.labels.file'))
                            ->hidden(function ($livewire) {
                                return $livewire instanceof EditMedia;
                            })
                            ->schema([
                                MediaUpload::make('filename')
                                    ->preserveFilenames(config('filament-curator.preserve_file_names'))
                                    ->disableLabel()
                                    ->maxWidth(5000)
                                    ->acceptedFileTypes(config('filament-curator.accepted_file_types'))
                                    ->directory(config('filament-curator.directory', 'images'))
                                    ->disk(config('filament-curator.disk', 'public'))
                                    ->required()
                                    ->maxFiles(1)
                                    ->panelAspectRatio('24:9')
                            ]),
                        Section::make(__('filament-curator::resource.labels.preview'))
                            ->hidden(function ($livewire) {
                                return $livewire instanceof CreateMedia;
                            })
                            ->schema([
                                ViewField::make('preview')
                                    ->view('filament-curator::components.media-preview')
                                    ->disableLabel()
                                    ->afterStateHydrated(function ($component, $state, $record) {
                                        $component->state($record);
                                    }),
                            ]),
                        Section::make('Details')
                            ->schema([
                                Placeholder::make('uploaded_on')
                                    ->label(__('filament-curator::resource.labels.uploaded_on'))
                                    ->content(fn ($record): string => $record ? $record->created_at->format('F j, Y') : '-'),
                                Placeholder::make('file_type')
                                    ->label(__('filament-curator::resource.labels.file_type'))
                                    ->content(fn ($record): string => $record ? $record->type : '-'),
                                Placeholder::make('file_size')
                                    ->label(__('filament-curator::resource.labels.file_size'))
                                    ->content(fn ($record): string => $record ? $record->sizeForHumans() : '-'),
                                Placeholder::make('dimensions')
                                    ->label(__('filament-curator::resource.labels.dimensions'))
                                    ->content(fn ($record): string => $record ? $record->width . ' x ' . $record->height : '-'),
                                Placeholder::make('file_url')
                                    ->label(__('filament-curator::resource.labels.file_url'))
                                    ->content(fn ($record): string => $record ? $record->url : '-')->columnSpan(['lg' => 4]),
                            ])
                            ->columns(['lg' => 4])
                            ->visibleOn('edit'),
                    ])
                    ->columnSpan([
                        'lg' => 'full',
                        'xl' => 2
                    ]),
                Group::make()
                    ->schema([
                        Section::make('Meta')
                            ->schema([
                                TextInput::make('alt')
                                    ->label(__('filament-curator::media-form.labels.alt'))
                                    ->extraInputAttributes(['aria-describedby' => "resource-alt-helper"]),
                                View::make('filament-curator::alt-helper')
                                    ->extraAttributes(['id' => 'resource-alt-helper']),
                                TextInput::make('title')
                                    ->label(__('filament-curator::media-form.labels.title')),
                                Textarea::make('caption')
                                    ->label(__('filament-curator::media-form.labels.caption'))
                                    ->rows(2),
                                Textarea::make('description')
                                    ->label(__('filament-curator::media-form.labels.description'))
                                    ->rows(2),
                            ])
                    ])->columnSpan([
                        'lg' => 'full',
                        'xl' => 1,
                    ]),
            ])->columns([
                'lg' => 3,
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ThumbnailColumn::make('thumbnail_url')->size(40),
                TextColumn::make('title')
                    ->label(__('forms.labels.title'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('ext')
                    ->label(__('filament-curator::resource.labels.ext'))
                    ->sortable(),
                TextColumn::make('updated_at')
                    ->label(__('filament-curator::resource.labels.updated_at'))
                    ->date()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make()->iconButton(),
                DeleteAction::make()->iconButton(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListMedia::route('/'),
            'create' => CreateMedia::route('/create'),
            'edit' => EditMedia::route('/{record}/edit'),
        ];
    }
}
