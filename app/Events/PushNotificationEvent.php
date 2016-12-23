<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class PushNotificationEvent implements ShouldBroadcast
{
    use SerializesModels;

    public $title;

    public $direction;

    public $lang;

    public $body;

    public $tag;

    public $icon;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($title, $direction, $lang, $body, $tag, $icon)
    {
        $this->title = $title;
        $this->direction = $direction;
        $this->lang = $lang;
        $this->body = $body;
        $this->tag = $tag;
        $this->icon = $icon;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return ['push-notification'];
    }
}
