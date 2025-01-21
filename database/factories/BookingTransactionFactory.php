<?php

namespace Database\Factories;

use App\Models\BookingTransaction;
use App\Models\Ticket;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class BookingTransactionFactory extends Factory
{
    protected $model = BookingTransaction::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'booking_trx_id' => BookingTransaction::generateUniqueTrxId(), // Menggunakan metode generateUniqueTrxId untuk trx_id
            'phone_number' => $this->faker->phoneNumber,
            'email' => $this->faker->safeEmail,
            'proof' => $this->faker->imageUrl(), // Simulasi URL gambar untuk bukti pembayaran
            'total_amount' => $this->faker->randomFloat(2, 1000, 5000), // Total amount dengan 2 desimal
            'total_participant' => $this->faker->numberBetween(1, 10), // Jumlah peserta
            'is_paid' => $this->faker->boolean, // Status pembayaran
            'started_at' => $this->faker->dateTimeBetween('-1 month', 'now'), // Tanggal mulai
            'ticket_id' => Ticket::factory(), // Menggunakan TicketFactory untuk membuat ticket terkait
        ];
    }
}
