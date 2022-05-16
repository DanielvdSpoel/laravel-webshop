<?php

namespace App\Filament\Resources\CategoryResource\Pages;

use App\Filament\Resources\CategoryResource;
use App\Models\Category;
use Filament\Resources\Pages\EditRecord;

class EditCategory extends EditRecord
{
    protected static string $resource = CategoryResource::class;

    protected function afterSave()
    {
        foreach ($this->form->getState()['children'] as $child) {
            $this->record->children()->save(Category::find($child));
        }

        //$this->record->syncPermissions($permissions->keys());
    }

}
