<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Throwable;

class DashboardController extends Controller
{
    public function index(): View
    {
        try {
            $stats = [
                'total' => Ticket::count(),
                'open' => Ticket::where('status', 'open')->count(),
                'in_progress' => Ticket::where('status', 'in_progress')->count(),
                'resolved' => Ticket::where('status', 'resolved')->count(),
                'urgent' => Ticket::where('priority', 'urgent')->count(),
            ];

            $tickets = Ticket::latest()
                ->limit(8)
                ->get();

            return view('dashboard', [
                'stats' => $stats,
                'tickets' => $tickets,
                'hasError' => false,
                'errorMessage' => null,
            ]);
        } catch (Throwable $exception) {
            return view('dashboard', [
                'stats' => [
                    'total' => 0,
                    'open' => 0,
                    'in_progress' => 0,
                    'resolved' => 0,
                    'urgent' => 0,
                ],
                'tickets' => new Collection(),
                'hasError' => true,
                'errorMessage' => 'Data dashboard gagal dimuat.',
            ]);
        }
    }
}