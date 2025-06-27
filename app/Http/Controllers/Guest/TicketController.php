<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\TicketService;
use Illuminate\Support\Facades\Validator;

class TicketController extends Controller
{
    protected $ticketService;

    public function __construct(TicketService $ticketService)
    {
        $this->ticketService = $ticketService;
    }

    public function create()
    {
        return view('guest.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|digits_between:9,12|numeric',
            'description' => 'required|string|max:5000',
        ]);

        $ticket = $this->ticketService->createTicket($validated);

        return response()->json(['reference' => $ticket->reference]);
    }

    public function thankyou(Request $request)
    {
        $reference = $request->query('ref');
        return view('guest.thankyou', compact('reference'));
    }

    public function status()
    {
        return view('guest.status');
    }

    public function checkStatus(Request $request)
    {
        $request->validate([
            'reference' => 'required|string|max:20'
        ]);

        $ticket = $this->ticketService->getTicketByReference($request->reference);

        if (!$ticket) {
            return back()->with('error', 'Invalid reference number');
        }

        return view('guest.view', ['ticket' => $ticket]);
    }
}
