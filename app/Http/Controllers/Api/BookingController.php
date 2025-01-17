<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\StoreCheckBookingRequest;
use App\Services\BookingService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class BookingController extends Controller
{
    protected $bookingService;

    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }

    public function checkBooking(StoreCheckBookingRequest $request)
    {
        $validated = $request->validated();

       
        $bookingDetails = $this->bookingService->getBookingDetails($validated);

        
        if ($bookingDetails) {
            return response()->json($bookingDetails, 200);
        }

        
        return response()->json(['error' => 'Transaction not found'], 404);
    }
}