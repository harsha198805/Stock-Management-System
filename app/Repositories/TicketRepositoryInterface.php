<?php
namespace App\Repositories;

interface TicketRepositoryInterface
{
    public function createTicket(array $data);
    public function getAllTickets($search = null, $status = null,$startDate = null, $endDate = null);
    public function getTicketById(int $id);
    public function getTicketByReference(string $reference);
    public function replyToTicket(int $ticketId, array $data);
}