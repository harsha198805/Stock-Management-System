<?php

namespace App\Repositories\Interfaces;

use App\Models\Ticket;
use App\Models\TicketReply;
use App\Repositories\TicketRepositoryInterface;
use Illuminate\Support\Str;

class TicketRepository implements TicketRepositoryInterface
{
    public function createTicket(array $data)
    {
        $data['reference'] = strtoupper(Str::random(10));
        $data['is_opened'] = false;

        return Ticket::create($data);
    }

    public function getAllTickets($search = null, $status = null, $startDate = null, $endDate = null)
    {
        return Ticket::when($search, function ($query, $search) {
            $query->where('customer_name', 'like', "%{$search}%");
        })
            ->when($status === 'opened', function ($query) {
                $query->where('is_opened', 1);
            })
            ->when($status === 'pending', function ($query) {
                $query->where('is_opened', 0);
            })
            ->when($startDate, function ($query, $startDate) {
                $query->whereDate('created_at', '>=', $startDate);
            })
            ->when($endDate, function ($query, $endDate) {
                $query->whereDate('created_at', '<=', $endDate);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();
    }

    public function getTicketById(int $id)
    {
        return Ticket::with('replies')->find($id);
    }

    public function getTicketByReference(string $reference)
    {
        return Ticket::where('reference', $reference)->with('replies')->first();
    }

    public function replyToTicket(int $ticketId, array $data)
    {
        $ticket = Ticket::findOrFail($ticketId);
        $ticket->update(['is_opened' => true]);
        return $ticket->replies()->create($data);
    }
}
