<?php

namespace App\Events;

use App\Models\Trips;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TripStarted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $trips;
    private $user;
    /**
     * Create a new event instance.
     */
    public function __construct(Trips $trips, User $user)
    {
        $this->trips = $trips;
        $this->user = $user;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('passenger_' . $this->user->id),
        ];
    }
}
