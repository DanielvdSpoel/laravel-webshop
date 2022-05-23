<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Inertia\Testing\AssertableInertia as Assert;

class LoginTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /**
     * Test if the user can see the login page
     *
     * @return void
     */
    public function test_user_can_see_login_page(): void
    {
        $response = $this->get(route('login'));
        $response->assertStatus(200);
        $response->assertInertia(fn (Assert $page) => $page
                ->component('Auth/Login')
            );
    }

    /**
     * Test if the user cannot login if he is already logged in
     *
     * @return void
     */
    public function test_user_cannot_see_login_page_when_authenticated(): void
    {
        $user = User::factory()
            ->create();

        $response = $this->actingAs($user)->get(route('login'));

        $response->assertRedirect(RouteServiceProvider::HOME);
    }


    /**
     * Test if the user can login
     *
     * @return void
     */
    public function test_user_can_login(): void
    {
        $user = User::factory()
            ->create();


        $response = $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'password'
        ])->assertSessionDoesntHaveErrors();


        $response->assertRedirect(RouteServiceProvider::HOME);
    }

    public function test_user_cannot_login_if_password_is_incorrect()
    {
        $user = User::factory()
            ->create();

        $response = $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'incorrect_password'
        ]);

        $response->assertSessionHasErrors([
            'email' => __('auth.failed')
        ]);
    }
}
