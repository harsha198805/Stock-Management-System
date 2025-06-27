<?php

namespace App\Mail;

use App\Models\TicketReply;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TicketReplyMail extends Mailable
{
    use Queueable, SerializesModels;

    public $reply;

    public function __construct(TicketReply $reply)
    {
        $this->reply = $reply;
    }

    public function build()
    {
        return $this->subject('Response to Your Support Ticket')
                    ->view('emails.ticket_reply');
    }
}

