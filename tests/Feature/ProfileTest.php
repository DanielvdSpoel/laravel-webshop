<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Inertia\Testing\AssertableInertia as Assert;
use Inertia\Testing\Concerns\Has;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_can_see_profile()
    {
        $user = User::factory()
            ->create();
        $this->actingAs($user)->get(route('profile.account'))->assertInertia(fn (Assert $page) => $page
            ->component('Profile/Account')
            ->has('user')
        );
    }

    public function test_user_can_update_profile()
    {
        $user = User::factory()
            ->create([
                'first_name' => 'voornaam'
            ]);
        $this->actingAs($user)->patch(route('profile.update'), [
            'first_name' => 'john'
        ])->assertRedirect();

        $this->assertDatabaseHas('users', [
            'first_name' => 'john'
        ]);
    }

    public function test_user_can_update_password()
    {
        $user = User::factory()
            ->create([
                'password' => Hash::make('password')
            ]);
        $this->actingAs($user)->patch(route('profile.update'), [
            'current_password' => 'password',
            'new_password' => 'NewPassword',
            'new_password_confirmation' => 'NewPassword'
        ])->assertRedirect()->assertSessionDoesntHaveErrors();

    }

    public function test_user_cant_update_password_without_old_password()
    {
        $user = User::factory()
            ->create([
                'password' => Hash::make('password')
            ]);
        $this->actingAs($user)->patch(route('profile.update'), [
            'new_password' => 'NewPassword',
            'new_password_confirmation' => 'NewPassword'
        ])->assertSessionHasErrors()->assertRedirect();
    }

    public function test_user_can_update_email()
    {
        $user = User::factory()
            ->create([
                'password' => Hash::make('password')
            ]);
        $email = $this->faker->email;
        $this->actingAs($user)->patch(route('profile.update'), [
            'current_password' => 'password',
            'email' => $email
        ])->assertRedirect();
        $this->assertDatabaseHas('users', [
            'email' => $email
        ]);
    }

    public function test_user_cant_update_email_with_incorrect_password()
    {
        $user = User::factory()
            ->create([
                'password' => Hash::make('password')
            ]);
        $email = $this->faker->email;
        $this->actingAs($user)->patch(route('profile.update'), [
            'current_password' => 'invalid_password',
            'email' => $email
        ])->assertSessionHasErrors([
            'current_password' => trans('validation.current_password')
        ]);
    }
}
