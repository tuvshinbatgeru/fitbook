<?php

namespace App\Listeners;

use App\Club;
use App\Events\PlanAddedEvent;
use App\Notifications\NewPlan;
use App\User;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class PlanAddedListener implements ShouldQueue
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
    public function handle(PlanAddedEvent $event)
    {
        $club = Club::find($event->plan->club_id);
        Notification::send($club->followers, new NewPlan($event->plan, $club->short_name));
    }
}
