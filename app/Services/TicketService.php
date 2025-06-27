<?php

namespace App\Services;


use App\Repositories\TicketRepositoryInterface;
use App\Mail\TicketCreatedMail;
use App\Mail\TicketReplyMail;
use Illuminate\Support\Facades\Mail;

class TicketService
{
    protected $ticketRepository;

    public function __construct(TicketRepositoryInterface $ticketRepository)
    {
        $this->ticketRepository = $ticketRepository;
    }

    public function createTicket(array $data)
    {
        $ticket = $this->ticketRepository->createTicket($data);
        Mail::to($ticket->email)->send(new TicketCreatedMail($ticket));
        return $ticket;
    }

    public function getAllTickets($search = null, $status = null, $startDate = null, $endDate = null)
    {
        return $this->ticketRepository->getAllTickets($search, $status, $startDate, $endDate);
    }

    public function getTicketById(int $id)
    {
        return $this->ticketRepository->getTicketById($id);
    }

    public function getTicketByReference(string $reference)
    {
        return $this->ticketRepository->getTicketByReference($reference);
    }

    public function replyToTicket(int $ticketId, array $data)
    {
        $reply = $this->ticketRepository->replyToTicket($ticketId, $data);
        Mail::to($reply->ticket->email)->send(new TicketReplyMail($reply));
        return $reply;
    }

}
