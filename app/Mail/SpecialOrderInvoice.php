<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SpecialOrderInvoice extends Mailable
{
    use Queueable, SerializesModels;

    public $specialOrder;

    public function __construct($specialOrder)
    {
        $this->specialOrder = $specialOrder;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Special Order Invoice - ' . $this->specialOrder->order_number,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.special-order-invoice',
            with: ['specialOrder' => $this->specialOrder]
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
