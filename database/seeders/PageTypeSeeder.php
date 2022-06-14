<?php

namespace Database\Seeders;

use App\Models\PageType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PageTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $type =  PageType::firstOrCreate([
            'name' => 'Basic page'
        ]);
        $type->pages()->firstOrCreate([
            'name' => [
                'en' => 'Home',
                'nl' => 'Home',
                'de' => 'Home',
            ],
            'slug' => '',
            'can_be_deleted' => false,
        ]);
        PageType::firstOrCreate([
            'name' => 'Product page'
        ]);
        PageType::firstOrCreate([
            'name' => 'Brand page',
        ]);
        PageType::firstOrCreate([
            'name' => 'Category page',
        ]);
    }
}
