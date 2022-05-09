<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmployeeResource\Pages;
use App\Filament\Resources\EmployeeResource\RelationManagers;
use App\Models\Employee;
use Filament\Forms;
use Filament\Forms\Components\BelongsToManyMultiSelect;
use Filament\Resources\Form;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Pages\Page;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TagsColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Phpsa\FilamentPasswordReveal\Password;

class EmployeeResource extends Resource
{
    public array $permissions = ['view', 'create', 'update', 'delete', 'view_any', 'delete_any'];

    protected static ?string $model = Employee::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function getNavigationGroup(): string
    {
        return __('resources.groups.management');
    }

    public static function getLabel(): string
    {
        return __('resources.employees.label');
    }

    public static function getPluralLabel(): string
    {
        return __('resources.employees.label_plural');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('first_name')
                    ->label(__('forms.labels.first_name'))
                    ->required()
                    ->maxLength(191),
                Forms\Components\TextInput::make('last_name')
                    ->label(__('forms.labels.last_name'))
                    ->required()
                    ->maxLength(191),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->label(__('forms.labels.email'))
                    ->unique(ignorable: fn (?Model $record): ?Model => $record)
                    ->required()
                    ->maxLength(191),
                BelongsToManyMultiSelect::make('roles')
                    ->label(__('forms.labels.roles'))
                    ->preload()
                    ->relationship('roles', 'name'),
                Password::make('password')->label(trans('forms.labels.password'))
                    ->maxLength(255)
                    ->hidden(fn (Page $livewire) => !$livewire instanceof CreateRecord)
            ->dehydrateStateUsing(fn ($state) => !empty($state) ? Hash::make($state) : ""),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                Tables\Columns\TextColumn::make('name')->label(__('forms.labels.name'))->searchable()
                    ->formatStateUsing(fn (?string $state, ?Model $record): string => $record->first_name . ' ' . $record->last_name),
                Tables\Columns\TextColumn::make('email')->label(__('forms.labels.email'))->searchable(),
                TagsColumn::make('roles.name')
                    ->label(__('forms.labels.roles')),

            ])
            ->filters([
                SelectFilter::make('role')->relationship('roles', 'name')
                    ->label(__('resources.filters.has_role')),
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
            'index' => Pages\ListEmployees::route('/'),
            'create' => Pages\CreateEmployee::route('/create'),
            'view' => Pages\ViewEmployee::route('/{record}'),
            'edit' => Pages\EditEmployee::route('/{record}/edit'),
        ];
    }
}
