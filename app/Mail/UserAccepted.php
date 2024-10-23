<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class UserAccepted extends Mailable
{
    use Queueable, SerializesModels;

    public $user; // The user object
    public $role; // The role that has been assigned

    /**
     * Create a new message instance.
     *
     * @param User $user
     * @param string $role
     * @return void
     */
    public function __construct(User $user, string $role)
    {
        $this->user = $user;
        $this->role = $role;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.user_accepted') // View file for the email content
                    ->subject('Votre demande a été acceptée') // Email subject
                    ->with([
                        'user' => $this->user, // Pass user data to the view
                        'role' => $this->role, // Pass role data to the view
                    ])
                    ->attach(public_path('recycling-FEAT.png'), [
                        'as' => 'recycling-FEAT.png',
                        'mime' => 'image/png',
                    ]); // Attach image if necessary
    }
}
