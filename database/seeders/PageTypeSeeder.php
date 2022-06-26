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
            'name' => 'basic_page'
        ]);
        PageType::firstOrCreate([
            'name' => 'product_page'
        ]);
        PageType::firstOrCreate([
            'name' => 'brand_page',
        ]);
        PageType::firstOrCreate([
            'name' => 'category_page',
        ]);
    }
}
