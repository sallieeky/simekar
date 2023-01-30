<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_dashboard_rendered()
    {
        $this->withoutExceptionHandling();
        $user = User::where("id", 2)->first();
        $this->actingAs($user);
        $response = $this->get('/');
        $response->assertStatus(200);
    }
}
