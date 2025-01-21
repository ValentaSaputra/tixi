<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_displays_registration_form()
    {
        $response = $this->get('/registerasi'); // Menggunakan rute yang sesuai
        $response->assertStatus(200);
        $response->assertViewIs('registerasi'); // Pastikan view registerasi sesuai dengan yang ada
    }

    #[Test]
    public function it_registers_a_new_user()
    {
        $data = [
            'name' => 'Test User',
            'email' => 'test233@gmail.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->post('/registerasi', $data); // Menggunakan rute yang sesuai

        $response->assertRedirect('/login'); // Menggunakan rute yang sesuai setelah berhasil registrasi
        $this->assertDatabaseHas('users', [
            'email' => 'test233@gmail.com',
        ]);
    }

    #[Test]
    public function it_displays_email_error_if_already_registered()
    {
        User::factory()->create(['email' => 'test233@gmail.com']);

        $data = [
            'name' => 'Test User',
            'email' => 'test233@gmail.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->post('/registerasi', $data); // Menggunakan rute yang sesuai

        $response->assertRedirect(); 
        $response->assertSessionHas('email_error', 'Email sudah terdaftar'); // Pastikan session error ditangani dengan benar
    }

    #[Test]
    public function it_displays_login_form()
    {
        $response = $this->get('/login'); // Menggunakan rute yang sesuai
        $response->assertStatus(200);
        $response->assertViewIs('login');
    }

    #[Test]
    public function it_logs_in_a_user_with_correct_credentials()
    {
        $user = User::factory()->create([
            'email' => 'test233@gmail.com',
            'password' => Hash::make('password123'),
        ]);

        $data = [
            'email' => 'test233@gmail.com',
            'password' => 'password123',
        ];

        $response = $this->post('/login', $data); // Menggunakan rute yang sesuai

        $response->assertRedirect('/'); // Pastikan rute setelah login sesuai
        $this->assertAuthenticatedAs($user);
    }

    #[Test]
    public function it_fails_to_log_in_with_incorrect_credentials()
    {
        $user = User::factory()->create([
            'email' => 'test233@gmail.com',
            'password' => Hash::make('password123'),
        ]);

        $data = [
            'email' => 'test233@gmail.com',
            'password' => 'wrongpassword',
        ];

        $response = $this->post('/login', $data); // Menggunakan rute yang sesuai

        $response->assertRedirect();
        $response->assertSessionHas('gagal', 'Email atau password anda salah');
        $this->assertGuest();
    }
}
