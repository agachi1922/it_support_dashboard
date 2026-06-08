<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\View\View;

class TicketController extends Controller
{
    /**
     * Menampilkan daftar tiket IT.
     */
    public function index(): View
    {
        $tickets = Ticket::query()
            ->latest()
            ->get();

        return view('tickets.index', [
            'tickets' => $tickets,
        ]);
    }
}