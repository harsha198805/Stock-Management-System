<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\TicketService;
use Illuminate\Support\Facades\Validator;

class AgentTicketController extends Controller
{
    protected $ticketService;

    public function __construct(TicketService $ticketService)
    {
        $this->ticketService = $ticketService;
    }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $tickets = $this->ticketService->getAllTickets($search, $status, $startDate, $endDate);

        return view('agent.index', compact('tickets', 'search', 'status', 'startDate', 'endDate'));
    }

    public function show($id)
    {
        $ticket = $this->ticketService->getTicketById($id);

        if (!$ticket) {
            return redirect()->route('agent.tickets')->with('error', 'Ticket not found');
        }

        return view('agent.show', compact('ticket'));
    }

    public function reply(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'reply' => 'required|string|max:1000',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $this->ticketService->replyToTicket($id, [
            'reply' => $request->input('reply'),
        ]);

        return back()->with('success', 'Reply sent successfully');
    }
}
