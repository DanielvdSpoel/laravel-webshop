<?php

namespace Database\Seeders;

use Filament\Facades\Filament;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (Filament::getResources() as $resource) {
            $name = Str::lower(Str::before(Str::afterLast($resource, '\\'), 'Resource'));
            $class = new $resource();
            foreach ($class->permissions as $permission) {
                Permission::firstOrCreate([
                    'name' => $permission . '_' . $name,
                    'guard_name' => config('filament.auth.guard')
                ]);
            }
        }
    }
}
