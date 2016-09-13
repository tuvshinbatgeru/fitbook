<?php

namespace App\Events;

use App\User;
use App\Events\Event;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class UserOutTraining extends Event 
{
    use SerializesModels;

    public $user;

    public $club_id;

    public $subscription_id;

    public $start_time;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user, $clubId, $subscriptionId, $startTime)
    {
        //
        $this->user = $user;
        $this->club_id = $clubId;
        $this->subscription_id = $subscriptionId;
        $this->start_time = $startTime;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
