<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BookingTransaction;
use Illuminate\Http\Request;

class BookingTransactionApiController extends Controller
{
    /**
     * Menampilkan daftar booking dengan pagination.
     */
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 5);

        // Filter berdasarkan status pembayaran
        $query = BookingTransaction::query();

        if ($request->has('is_paid')) {
            $query->where('is_paid', $request->get('is_paid'));
        }

        $bookingTransactions = $query->paginate($perPage);

        return response()->json($bookingTransactions, 200);
    }

}
