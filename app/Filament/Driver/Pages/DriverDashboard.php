<?php

namespace App\Filament\Driver\Pages;

use Filament\Pages\Page;
use App\Models\Ride;
use App\Models\Bus;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Filament\Notifications\Notification;

class DriverDashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-truck';
    protected static string $view = 'filament.driver.pages.driver-dashboard';

    public $buses = [];
    public $activeRide;
    public $manualLat;
    public $manualLng;

    public function mount()
    {
        $user = Auth::user();
        $this->buses = Bus::where('driver_id', $user->id)->get();
        $this->activeRide = Ride::where('driver_id', $user->id)
            ->where('status', 'active')
            ->latest()
            ->first();
    }

    public function startRide($busId)
    {
        $user = Auth::user();
        $active = Ride::where('driver_id', $user->id)
            ->where('status', 'active')
            ->first();

        if ($active) {
            Notification::make()
                ->title('You already have an active ride.')
                ->danger()
                ->send();
            return;
        }

        $ride = Ride::create([
            'driver_id' => $user->id,
            'bus_id' => $busId,
            'started_at' => Carbon::now(),
            'status' => 'active',
        ]);
        $this->activeRide = $ride;
        Notification::make()
            ->title('Ride started! Now sharing location.')
            ->success()
            ->send();
    }

    public function stopRide()
    {
        $user = Auth::user();
        $activeRide = Ride::where('driver_id', $user->id)
            ->where('status', 'active')
            ->first();

        if ($activeRide) {
            $activeRide->ended_at = now();
            $activeRide->status = 'ended';
            $activeRide->save();
            $this->activeRide = null;
            Notification::make()
                ->title('Ride ended.')
                ->success()
                ->send();
        } else {
            Notification::make()
                ->title('No active ride found.')
                ->danger()
                ->send();
        }
    }

    public function updateLocation($lat, $lng)
    {
        $user = Auth::user();
        $ride = Ride::where('driver_id', $user->id)
            ->where('status', 'active')
            ->first();

        if ($ride) {
            $ride->update([
                'current_lat' => $lat,
                'current_lng' => $lng,
            ]);
            Notification::make()
                ->title('Location updated!')
                ->success()
                ->send();
        }
    }

    public function submitManualLocation()
    {
        $this->updateLocation($this->manualLat, $this->manualLng);
        $this->manualLat = null;
        $this->manualLng = null;
    }
}