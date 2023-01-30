<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_login_rendered()
    {
        $this->get('/login')->assertStatus(200);
    }

    public function test_login_post()
    {
        $user = User::factory()->make();
        $this->post("/login", $user->toArray())
            ->assertRedirect("/");
    }
}
