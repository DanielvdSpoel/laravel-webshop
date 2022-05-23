<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Inertia\Testing\AssertableInertia as Assert;

class PasswordResetTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    public function test_user_can_visit_password_reset_page()
    {
        $this->get(route('password.request'))
            ->assertInertia(fn(Assert $page) => $page
                ->component('Auth/PasswordEmail')
            );

    }

    public function test_user_can_request_a_password_reset()
    {
        $user = User::factory()->create();

        $this->post(route('password.request'), [
            'email' => $user->email
        ]);

        $this->assertDatabaseHas('password_resets', ['email' => $user->email]);
    }

    public function test_user_needs_a_valid_token_to_reset_their_password()
    {
        // Using a UUID as an addition to the password, because default passwords could fail the 'uncompromised' validation rule.
        $password = $this->faker->uuid() . $this->faker->password(8);

        $user = User::factory()->create();

        $this->post(route('password.reset'), [
                'email' => $user->email,
                'password' => $password,
                'password_confirmation' => $password,
                'token' => $this->faker->uuid()
            ])->assertSessionHasErrors([
                'email' => __('passwords.token')
            ]);;
    }

}
