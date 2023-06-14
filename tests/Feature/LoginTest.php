<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\User;
use Tests\TestCase;

class LoginTest extends TestCase
{

    use RefreshDatabase;

    public function test_login(): void
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create();

        $response = $this->postJson('/api/v1/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure(['access_token']);
    }

    public function test_login_with_wrong_password(): void
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create();

        $response = $this->postJson('/api/v1/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $response->assertStatus(422);
    }

    public function test_login_with_wrong_email(): void
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create();

        $response = $this->postJson('/api/v1/login', [
            'email' => 'email@email.com',
            'password' => 'password',
        ]);

        $response->assertStatus(422);
    }

    public function test_login_with_wrong_email_and_password(): void
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create();

        $response = $this->postJson('/api/v1/login', [
            'email' => 'email@email.com',
            'password' => 'wrong-password',
        ]);

        $response->assertStatus(422);
    }
}
