<?php

// app/Events/RideStarted.php
namespace App\Events;

use App\Models\Ride;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class RideStarted implements ShouldBroadcast
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
            'bus_name' => $this->ride->bus->name,
            'route_name' => $this->ride->bus->route->name ?? 'N/A',
            'driver_name' => $this->ride->driver->name ?? 'N/A',
            'latitude' => $this->ride->current_lat ?? 51.505,
            'longitude' => $this->ride->current_lng ?? -0.09,
            'status' => 'Active',
            'ac_type' => $this->ride->bus->ac_type,
        ];
    }
}