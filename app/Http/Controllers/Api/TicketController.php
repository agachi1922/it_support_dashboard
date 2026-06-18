<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\UpdateTicketRequest;
use App\Http\Resources\TicketResource;
use App\Models\Ticket;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'search' => [
                'nullable',
                'string',
                'max:100',
            ],
            'status' => [
                'nullable',
                'in:open,in_progress,resolved,closed',
            ],
            'priority' => [
                'nullable',
                'in:low,medium,high,urgent',
            ],
            'category' => [
                'nullable',
                'string',
                'max:100',
            ],
            'per_page' => [
                'nullable',
                'integer',
                'min:1',
                'max:100',
            ],
            'sort_by' => [
                'nullable',
                'in:id,title,category,priority,status,created_at,updated_at',
            ],
            'sort_direction' => [
                'nullable',
                'in:asc,desc',
            ],
        ]);

        $search = $validated['search'] ?? null;
        $status = $validated['status'] ?? null;
        $priority = $validated['priority'] ?? null;
        $category = $validated['category'] ?? null;
        $perPage = $validated['per_page'] ?? 10;
        $sortBy = $validated['sort_by'] ?? 'created_at';
        $sortDirection = $validated['sort_direction'] ?? 'desc';

        $tickets = Ticket::query()
            ->when($search, function ($query, string $search): void {
                $query->where(function ($subQuery) use ($search): void {
                    $subQuery
                        ->where('title', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%")
                        ->orWhere('requester_name', 'like', "%{$search}%")
                        ->orWhere('requester_email', 'like', "%{$search}%")
                        ->orWhere('category', 'like', "%{$search}%");
                });
            })
            ->when(
                $status,
                fn ($query, string $status) => $query->where(
                    'status',
                    $status
                )
            )
            ->when(
                $priority,
                fn ($query, string $priority) => $query->where(
                    'priority',
                    $priority
                )
            )
            ->when(
                $category,
                fn ($query, string $category) => $query->where(
                    'category',
                    $category
                )
            )
            ->orderBy($sortBy, $sortDirection)
            ->paginate($perPage)
            ->withQueryString();

        return response()->json([
            'success' => true,
            'message' => 'Daftar ticket berhasil diambil.',
            'data' => TicketResource::collection(
                $tickets->getCollection()
            ),
            'meta' => [
                'current_page' => $tickets->currentPage(),
                'from' => $tickets->firstItem(),
                'last_page' => $tickets->lastPage(),
                'per_page' => $tickets->perPage(),
                'to' => $tickets->lastItem(),
                'total' => $tickets->total(),
            ],
            'links' => [
                'first' => $tickets->url(1),
                'last' => $tickets->url($tickets->lastPage()),
                'previous' => $tickets->previousPageUrl(),
                'next' => $tickets->nextPageUrl(),
            ],
            'filters' => [
                'search' => $search,
                'status' => $status,
                'priority' => $priority,
                'category' => $category,
                'sort_by' => $sortBy,
                'sort_direction' => $sortDirection,
            ],
            'errors' => null,
        ]);
    }

    public function store(
        StoreTicketRequest $request
    ): JsonResponse {
        $ticket = Ticket::create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Ticket berhasil dibuat.',
            'data' => new TicketResource($ticket),
            'errors' => null,
        ], 201);
    }

    public function show(Ticket $ticket): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => 'Detail ticket berhasil diambil.',
            'data' => new TicketResource($ticket),
            'errors' => null,
        ]);
    }

    public function update(
        UpdateTicketRequest $request,
        Ticket $ticket
    ): JsonResponse {
        $ticket->update($request->validated());
        $ticket->refresh();

        return response()->json([
            'success' => true,
            'message' => 'Ticket berhasil diperbarui.',
            'data' => new TicketResource($ticket),
            'errors' => null,
        ]);
    }

    public function destroy(Ticket $ticket): JsonResponse
    {
        $ticket->delete();

        return response()->json([
            'success' => true,
            'message' => 'Ticket berhasil dihapus.',
            'data' => null,
            'errors' => null,
        ]);
    }
}