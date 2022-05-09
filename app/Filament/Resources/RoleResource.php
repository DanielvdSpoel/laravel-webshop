<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RoleResource\Pages;
use App\Filament\Resources\RoleResource\RelationManagers;
use App\Models\Role;
use Closure;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Filament\Forms\Components\Component;

class RoleResource extends Resource
{
    public array $permissions = ['view', 'create', 'update', 'delete', 'view_any', 'delete_any'];
    protected static ?string $model = \Spatie\Permission\Models\Role::class;

    protected static ?string $navigationIcon = 'heroicon-o-shield-check';

    public static function getNavigationGroup(): string
    {
        return __('resources.groups.management');
    }

    public static function getLabel(): string
    {
        return __('resources.roles.label');
    }

    public static function getPluralLabel(): string
    {
        return __('resources.roles.label_plural');
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label(__('forms.labels.name'))
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Hidden::make('guard_name')
                            ->default(config('filament.auth.guard')),
                        Forms\Components\Toggle::make('select_all')
                            ->onIcon('heroicon-s-shield-check')
                            ->offIcon('heroicon-s-shield-exclamation')
                            ->label(__('forms.labels.select_all'))
                            ->helperText(__('forms.helpers.select_all'))
                            ->reactive()
                            ->afterStateUpdated(function (Closure $set, $state) {
                                static::setAllCheckboxesState($set, $state);
                            })
                    ])->columns(),
                Forms\Components\Section::make(__('forms.labels.permissions_title'))
                    ->schema([
                        Forms\Components\Grid::make([
                            'sm' => 2,
                            'lg' => 3,
                        ])
                            ->schema(static::getEntitiesCards())
                            ->columns([
                                'sm' => 2,
                                'lg' => 3
                            ])
                    ])

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable()->label(__('forms.labels.name')),
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
            'index' => Pages\ListRoles::route('/'),
            'create' => Pages\CreateRole::route('/create'),
            'edit' => Pages\EditRole::route('/{record}/edit'),
        ];
    }

    protected static function getEntities(): array
    {
        return Permission::all()->pluck('name')->reduce(function ($names, $permission) {
            $name = explode('_', $permission);
            $name = end($name);
            $names[$name] = $name;
            return $names;
        }, []);

    }

    protected static function getEntitiesCards(): array
    {
        return collect(static::getEntities())->reduce(function ($entities, $entity) {
            $entities[] = Forms\Components\Card::make()
                ->schema([
                    Forms\Components\Toggle::make($entity)
                        ->label(__('forms.labels.permissions.' . $entity))
                        ->onIcon('heroicon-s-lock-open')
                        ->offIcon('heroicon-s-lock-closed')
                        ->reactive()
                        ->afterStateUpdated(function (Closure $set, Closure $get, $state) use ($entity) {
                            static::checkForAllSelected($get, $set, $state);
                            static::setAllCheckboxesState($set, $state, $entity);
                        })
                    ,
                    Forms\Components\Fieldset::make(__('forms.labels.permissions_label'))
                        ->extraAttributes(['class' => 'text-primary-600', 'style' => 'border-color:var(--primary)'])
                        ->columns([
                            'default' => 2,
                            'xl' => 2
                        ])
                        ->schema(static::getPermissionCheckboxes($entity))
                ])
                ->columns(2)
                ->columnSpan(1);
            return $entities;
        }, []);
    }

    protected static function getPermissionCheckboxes($entity): array
    {
        return Permission::where('name', 'like', '%_' . $entity)->get()->pluck('name')->reduce(function ($permissions, $permission) use ($entity) {
            $permissions[] = Forms\Components\Checkbox::make('permissions.' . $permission)
                ->disabled(function () use ($permission) {
                    return !static::canTogglePermission($permission);
                })
                ->label(__('forms.labels.permissions.' . explode('_' . $entity, $permission)[0]))
                ->extraAttributes(['class' => 'text-primary-600'])
                ->disabled(function () use ($permission) {
                    return !static::canTogglePermission($permission);
                })
                ->reactive()
                ->afterStateUpdated(function (Closure $set, Closure $get, $state) use ($entity) {
                    static::checkForAllSelected($get, $set, $state, $entity);
                })->afterStateHydrated(function (Component $component, ?Model $record, Closure $get, Closure $set) use ($entity, $permission) {
                    if ($record && $record->hasPermissionTo($permission)) {
                        $component->state(true);
                    }
                });

            return $permissions;
        }, []);
    }

    protected static function canTogglePermission($permission): bool
    {
        return true;
        if (auth()->user()->hasRole(config('webshop.super_admin_role'))) {
            return true;
        }
        return auth()->user()->can($permission);
    }

    protected static function setAllCheckboxesState(Closure $set, $state, $entity = null): void
    {
        if ($entity) {
            foreach (Permission::where('name', 'like', '%_' . $entity)->get()->pluck('name') as $permission) {
                $set('permissions.' . $permission, $state);
            }
        } else {
            foreach (static::getEntities() as $entity) {
                $set($entity, $state);
                foreach (Permission::where('name', 'like', '%_' . $entity)->get()->pluck('name') as $permission) {
                    $set('permissions.' . $permission, $state);
                }
            }
        }
    }

    protected static function checkForAllSelected(Closure $get, Closure $set, $state, $entity = null): void
    {
        if ($entity) {
            $states = collect([]);
            foreach (Permission::where('name', 'like', '%_' . $entity)->get()->pluck('name') as $permission) {
                $states->push($get('permissions.' . $permission));
            }
            ray($states);
            if ($states->containsStrict(!$state)) {
                $set($entity, false);
                $set('select_all', false);
            } else {
                $set($entity, true);
                static::checkForAllSelected($get, $set, $state);
            }
        } else {
            $states = collect([]);
            foreach (static::getEntities() as $entity) {
                $states->push($get($entity));
            }
            if ($state) {
                if (!$states->containsStrict(false)) {
                    $set('select_all', true);
                }
            } else {
                $set('select_all', false);
            }
        }
    }
}
