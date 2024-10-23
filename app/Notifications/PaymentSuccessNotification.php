<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PaymentSuccessNotification extends Notification
{
    use Queueable;

    protected $annonce;
    protected $payer;

    public function __construct($annonce, $payer)
    {
        $this->annonce = $annonce;
        $this->payer = $payer;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Un paiement a été effectué pour votre annonce')
            ->greeting('Bonjour ' . $notifiable->name . ',')
            ->line("L'utilisateur " . $this->payer->name . " a effectué un paiement de " . $this->annonce->price . " TND pour votre annonce.")
            ->line('Détails de l\'annonce :')
            ->line('Type de déchet : ' . $this->annonce->type_dechet)
            ->line('Description : ' . $this->annonce->description)
            ->action('Voir votre annonce', url('/annonces/' . $this->annonce->id))
            ->line('Merci d\'utiliser notre plateforme !');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            // Les informations qui peuvent être enregistrées dans une base de données de notifications
        ];
    }
}
