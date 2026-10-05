<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class WellcomeNotify extends Notification
{
    use Queueable;

    /**
     * The password reset token.
     *
     * @var string
     */
    public $token;
    public $gpasswod;

    /**
     * Create a notification instance.
     *
     * @param  string  $token
     * @return void
     */
    public function __construct($token, $gpasswod)
    {
        $this->token = $token;
        $this->gpasswod = $gpasswod;
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
            ->subject('Dobrodošli - '  .config('app.name'))
            ->line('Dobrodošli na sajt '. config('app.name').'!')
            ->line('Vaš generisani password je: '. $this->gpasswod)
            ->line('Ukoliko želite da promenite password, to možete')
            ->line('učiniti klikom na ovaj link ispod:')
            ->action('Reset Password', url('password/reset', $this->token).'?email='.urlencode($notifiable->email));
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
            //
        ];
    }
}
