<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;


class LogoutTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /**
     * Test if a logged in user can logout
     *
     * @return void
     */
    public function test_user_can_logout()
    {
        $user = User::factory()
            ->create();

        Auth::guard()->setUser($user);

        $response = $this->post(route('logout'));
        $response->assertRedirect(route('login'));
        $this->assertNull(Auth::guard()->getUser());

        //user can't access a protected route after logging out and gets redirected to the login page
        $response = $this->get(route('profile'));
        $response->assertStatus(302);
        $response->assertRedirect(route('login'));
    }
}
