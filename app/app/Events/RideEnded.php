<?php

// app/Events/RideEnded.php
namespace App\Events;

use App\Models\Ride;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class RideEnded implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets;

    public $ride;

    public function __construct(Ride $ride)
    {
        $this->ride = $ride;
    }

    public function broadcastOn()
    {
        return new Channel('bus-tracking');
    }

    public function broadcastWith()
    {
        return [
            'bus_id' => $this->ride->bus_id,
            'status' => 'Idle',
        ];
    }
}