<?php

namespace App\Filament\Resources\RoleResource\Pages;

use App\Filament\Resources\RoleResource;
use Filament\Resources\Pages\EditRecord;
use Spatie\Permission\Models\Permission;

class EditRole extends EditRecord
{
    protected static string $resource = RoleResource::class;

    protected function afterSave(): void
    {
        //Filter only permissions that are enabled
        $permissions = collect($this->form->getState()['permissions'])->filter(function ($value) {
            return $value;
        });
        $this->record->syncPermissions($permissions->keys());
    }
}
