<?php

namespace App\Http\Livewire;

use App\Models\Bus;
use App\Models\Ride;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class DriverDashboard extends Component
{
    // Properties for manual location input
    public $manualLat;
    public $manualLng;

    // Validation rules
    protected $rules = [
        'manualLat' => 'required|numeric|between:-90,90',
        'manualLng' => 'required|numeric|between:-180,180',
    ];

    /**
     * Start a new ride for the specified bus.
     */
    public function startRide($busId)
    {
        // Verify the bus exists and is assigned to the authenticated driver
        $bus = Bus::findOrFail($busId);
        if (Auth::user()->id !== $bus->driver_id) {
            $this->addError('bus', 'You are not assigned to this bus.');
            return;
        }

        // Check if the driver already has an active ride
        if (Ride::where('driver_id', Auth::user()->id)->where('status', 'Active')->exists()) {
            $this->addError('bus', 'You already have an active ride.');
            return;
        }

        // Create a new ride
        $ride = Ride::create([
            'bus_id' => $busId,
            'driver_id' => Auth::user()->id,
            'status' => 'Active',
            'started_at' => now(),
        ]);

        // Broadcast the ride start event
        event(new \App\Events\RideStarted($ride));

        // Notify the frontend
        $this->dispatchBrowserEvent('ride-started', ['message' => 'Ride started successfully for bus: ' . $bus->name]);
    }

    /**
     * End the active ride for the authenticated driver.
     */
    public function stopRide()
    {
        $ride = Ride::where('driver_id', Auth::user()->id)
            ->where('status', 'Active')
            ->first();

        if (!$ride) {
            $this->addError('ride', 'No active ride found.');
            return;
        }

        $ride->update([
            'status' => 'Ended',
            'ended_at' => now(),
        ]);

        // Broadcast the ride end event
        event(new \App\Events\RideEnded($ride));

        // Notify the frontend
        $this->dispatchBrowserEvent('ride-stopped', ['message' => 'Ride ended successfully.']);
    }

    /**
     * Update the ride location using geolocation data.
     */
    public function updateLocation($lat, $lng)
    {
        $ride = Ride::where('driver_id', Auth::user()->id)
            ->where('status', 'Active')
            ->first();

        if (!$ride) {
            $this->dispatchBrowserEvent('error', ['message' => 'No active ride found.']);
            return;
        }

        $ride->update([
            'current_lat' => $lat,
            'current_lng' => $lng,
        ]);

        // Optionally broadcast location update
        event(new \App\Events\RideLocationUpdated($ride));
    }

    /**
     * Submit manual location input.
     */
    public function submitManualLocation()
    {
        $this->validate();

        $ride = Ride::where('driver_id', Auth::user()->id)
            ->where('status', 'Active')
            ->first();

        if (!$ride) {
            $this->addError('ride', 'No active ride found.');
            return;
        }

        $ride->update([
            'current_lat' => $this->manualLat,
            'current_lng' => $this->manualLng,
        ]);

        // Broadcast the location update
        event(new \App\Events\RideLocationUpdated($ride));

        // Reset form and notify
        $this->manualLat = null;
        $this->manualLng = null;
        $this->dispatchBrowserEvent('location-updated', ['message' => 'Location updated manually.']);
    }

    /**
     * Render the component.
     */
    public function render()
    {
        return view('livewire.driver-dashboard', [
            'activeRide' => Ride::where('driver_id', Auth::user()->id)
                ->where('status', 'Active')
                ->with('bus')
                ->first(),
            'buses' => Bus::where('driver_id', Auth::user()->id)->get(),
        ]);
    }
}