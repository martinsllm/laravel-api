<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{

    use RefreshDatabase;
    
    public function test_user_can_login_successfully(): void
    {
        $user = User::factory()->create([
            'email' => 'B0HkD@example.com',
            'password' => bcrypt('password'),
        ]);

        $response = $this->postJson('/api/v1/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertStatus(200);
    }

    public function test_user_can_login_unsuccessfully(): void
    {
        $this->postJson('/api/v1/login', [
            'email' => 'B0HkD@example.com',
            'password' => 'password',
        ])->assertStatus(401);
    }
}
