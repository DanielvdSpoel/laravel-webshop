<?php

namespace Tests\Feature;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class HomePageTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_can_visit_home_page()
    {
        Category::factory(5)->create();
        $this->get(route('home'))
            ->assertInertia(fn (Assert $page) => $page
                ->component('Home')
                ->has('categories', 5)

            );
    }
}
