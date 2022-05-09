<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CreateOwnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $owner = Employee::create([
            'first_name' => 'Webshop',
            'last_name' => 'Owner',
            'email' => 'd.vanderspoel@mediamere.com',
            'password' => Hash::make('password'),
        ]);
        $owner->assignRole('owner');
    }
}
