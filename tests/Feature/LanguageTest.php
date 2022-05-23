<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LanguageTest extends TestCase
{
    use WithFaker, RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_can_switch_language()
    {
        $lang = $this->faker->randomElement(array_keys(config('webshop.available_languages')));
        $this->patch(route('update-language'), [
            'language' => $lang
        ])->assertSessionHas('locale', $lang)->assertRedirect();
    }
}
