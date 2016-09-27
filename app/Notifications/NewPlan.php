<?php

namespace App\Notifications;

//use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
//use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NewPlan extends Notification
{
    //use Queueable;

    public $plan;

    public $clubShortName;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($plan, $short_name)
    {
        //
        $this->plan = $plan;

        $this->clubShortName = $short_name;
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
        //just test
        return [
            'plan_id' => $this->plan->id,
            'name' => $this->plan->name,
            'description' => $this->plan->description,
            'release_date' => $this->plan->created_at,
            'club_short_name' => $this->clubShortName,
        ];
    }
}
