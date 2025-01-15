<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function index()
    {
        // Ambil semua data tiket
        $tickets = Ticket::all();

        // Kembalikan dalam format JSON
        return response()->json($tickets, 200);
    }

    public function show($id)
{
    // Cari tiket berdasarkan ID
    $ticket = Ticket::find($id);

    // Jika tiket ditemukan, kembalikan dalam format JSON, jika tidak, kembalikan pesan error
    if ($ticket) {
        return response()->json($ticket, 200);
    } else {
        return response()->json(['message' => 'Ticket not found'], 404);
    }
}

}
