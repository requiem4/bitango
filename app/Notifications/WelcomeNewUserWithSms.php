<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Channels\SMSChannel;
use App\Messages\SmsMessage;
use App\Messages\ElkSmsMessage;
use Illuminate\Notifications\Messages\VonageMessage;

class WelcomeNewUserWithSms extends Notification implements ShouldQueue
{
    use Queueable;

    public $phone = '';

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [SMSChannel::class]; // 'vonage' - could user for a future
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
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }
    /**
     * Get the Elks sms representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \App\Messages\ElkSmsMessage
     */
    public function toElksSms($notifiable)
    {
        // We are assuming we are notifying a user or a model that has a telephone attribute/field.
        // And the telephone number is correctly formatted.
        return (new ElkSmsMessage)
                    ->from('ObiWan')
                    ->to($notifiable->telephone)
                    ->line("These aren't the droids you are looking for.");
    }

    /**
     * Get the sms representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \App\Messages\SmsMessage
     */
    public function toSms($notifiable)
    {
        // We are assuming we are notifying a user or a model that has a telephone attribute/field.
        return (new SmsMessage)
                    ->from('ObiWan')
                    ->to($notifiable->phone)
                    ->line("These aren't the droids you are looking for.");
    }

    /**
     * Get the Vonage / SMS representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\VonageMessage
     */
    public function toVonage($notifiable)
    {
        return (new VonageMessage)
                    ->content('Your SMS message content')
                    ->from('15554443333');
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
