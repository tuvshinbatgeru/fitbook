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
        for($i = 0; $i < 10000; $i ++)
        {
            $event->user->activities()->attach(1, [
                    'start_time' => Carbon::now(), 
                    'finish_time' => Carbon::now(),
                    'duration' => 120,
                ]);
        }
        
    }
}
