<?php

namespace App\Filament\Resources\RoleResource\Pages;

use App\Filament\Resources\RoleResource;
use Filament\Resources\Pages\CreateRecord;
use Spatie\Permission\Models\Permission;

class CreateRole extends CreateRecord
{
    protected static string $resource = RoleResource::class;

    protected function afterCreate()
    {
        //Filter only permissions that are enabled
        $permissions = collect($this->form->getState()['permissions'])->filter(function ($value) {
            return $value;
        });
        $this->record->syncPermissions($permissions->keys());
    }

}
