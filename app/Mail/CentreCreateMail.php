<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CentreCreateMail extends Mailable
{
    use Queueable, SerializesModels;

    public $centre;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($centre)
    {
        $this->centre = $centre;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Centre de recyclage créé avec succès')
            ->view('emails.centre-created');
    }
}
