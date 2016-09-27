<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class TeacherRequestRecieved extends Notification
{
    use Queueable;

    public $user;

    public $recieved_at;

    public $description;

    public $club;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user, $club, $recieved_at, $description)
    {
        //
        $this->user = $user;

        $this->club = $club;

        $this->recieved_at = $recieved_at;

        $this->description = $description;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
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
                    ->action('Notification Action', 'https://laravel.com')
                    ->line('Thank you for using our application!');
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
            'username' => $this->user->username,
            'user_first_name' => $this->user->first_name,
            'user_last_name' => $this->user->last_name,
            'image_url' => $this->user->avatar_url,
            'description' => $this->description,
            'recieved_at' => $this->recieved_at,
            'club_id' => $this->club->club_id,
            'club_short_name' => $this->club->short_name,
        ];
    }
}
