<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CentreUpdateMail extends Mailable
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
        return $this->subject('Centre de recyclage mis à jour')
            ->view('emails.centre-updated');
    }
}
