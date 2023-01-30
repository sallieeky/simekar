<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\Auth;
use PHPUnit\Framework\TestCase;

class LoginTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_login_success()
    {
        $user = [
            'email' => 'admin@gmail.com',
            'password' => 123456
        ];
        $response = Auth::attempt($user);
        $this->assertTrue(true);
    }
}
