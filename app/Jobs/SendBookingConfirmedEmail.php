<?php

namespace App\Jobs;

use App\Mail\OrderConfirmed;
use App\Models\BookingTransaction;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class SendBookingConfirmedEmail implements ShouldQueue
{
    use Queueable;

    protected $booking;

    /**
     * Create a new job instance.
     */
    public function __construct(BookingTransaction $bookingTransaction)
    {
        //
        $this->booking = $bookingTransaction;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //
        Mail::to($this->booking->email)->send(new OrderConfirmed($this->booking));
    }
}
