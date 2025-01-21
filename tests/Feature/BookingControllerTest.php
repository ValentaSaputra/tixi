<?php

namespace Tests\Feature;

use App\Models\User;
use App\Services\BookingService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class BookingControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Create and authenticate a user for protected routes
        $user = User::factory()->create();
        Sanctum::actingAs($user);
    }

    #[Test]
    public function check_booking_returns_details_when_found()
    {
        // Mock the BookingService
        $this->mock(BookingService::class, function ($mock) {
            $mock->shouldReceive('getBookingDetails')
                ->once()
                ->with([
                    'booking_trx_id' => 'TRX123',
                    'phone_number' => '1234567890'
                ])
                ->andReturn([
                    'id' => 1,
                    'booking_trx_id' => 'TRX123',
                    'phone_number' => '1234567890',
                    'status' => 'confirmed'
                ]);
        });

        $response = $this->postJson('/api/checkBooking', [
            'booking_trx_id' => 'TRX123',
            'phone_number' => '1234567890'
        ]);

        $response->assertStatus(200)
                ->assertJson([
                    'id' => 1,
                    'booking_trx_id' => 'TRX123',
                    'phone_number' => '1234567890',
                    'status' => 'confirmed'
                ]);
    }

    #[Test]
    public function check_booking_returns_404_when_not_found()
    {
        // Mock the BookingService
        $this->mock(BookingService::class, function ($mock) {
            $mock->shouldReceive('getBookingDetails')
                ->once()
                ->with([
                    'booking_trx_id' => 'TRX123',
                    'phone_number' => '1234567890'
                ])
                ->andReturn(null);
        });

        $response = $this->postJson('/api/checkBooking', [
            'booking_trx_id' => 'TRX123',
            'phone_number' => '1234567890'
        ]);

        $response->assertStatus(404)
                ->assertJson([
                    'error' => 'Transaction not found'
                ]);
    }

    #[Test]
    public function check_booking_validates_required_fields()
    {
        $response = $this->postJson('/api/checkBooking', []);

        $response->assertStatus(422)
                ->assertJsonValidationErrors([
                    'booking_trx_id',
                    'phone_number'
                ]);
    }


    #[Test]
    public function check_booking_is_throttled()
    {
        // Make 3 requests (the limit according to your route configuration)
        for ($i = 0; $i < 3; $i++) {
            $this->postJson('/api/checkBooking', [
                'booking_trx_id' => 'TRX123',
                'phone_number' => '1234567890'
            ]);
        }

        // The 4th request should be throttled
        $response = $this->postJson('/api/checkBooking', [
            'booking_trx_id' => 'TRX123',
            'phone_number' => '1234567890'
        ]);

        $response->assertStatus(429); // Too Many Requests
    }
}
