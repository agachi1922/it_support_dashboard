<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman dashboard Divisi IT.
     */
    public function index(): View
    {
        $tickets = Ticket::query()
            ->latest()
            ->get();

        $statistics = [
            'total' => $tickets->count(),

            'new' => $tickets
                ->where('status', 'Baru')
                ->count(),

            'process' => $tickets
                ->where('status', 'Diproses')
                ->count(),

            'completed' => $tickets
                ->where('status', 'Selesai')
                ->count(),
        ];

        return view('dashboard', [
            'tickets' => $tickets,
            'statistics' => $statistics,
        ]);
    }
}