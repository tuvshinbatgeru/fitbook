<?php

namespace App\Listeners;

use App\Events\UserOutTraining;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UserActivityNotification implements ShouldQueue
{
    use InteractsWithQueue;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UserOutTraining  $event
     * @return void
     */
    public function handle(UserOutTraining $event)
    {
        $event->user->activities()->attach($event->club_id, [
            'subscription_id' => $event->subscription_id,
            'start_time' => $event->start_time, 
            'finish_time' => Carbon::now(),
            'duration' => Carbon::now()->diffInMinutes(Carbon::parse($event->start_time)),
        ]);
    }
}
