<?php
// app/Http/Controllers/BusTrackerController.php

namespace App\Http\Controllers;

use App\Models\Bus;
use Illuminate\Http\Request;

class BusTrackerController extends Controller
{
    public function show(Bus $bus)
    {
        $ride = $bus->activeRide()->first();

        if (!$ride || !$ride->current_lat || !$ride->current_lng) {
            return back()->with('error', 'Bus location not available right now.');
        }

        return view('track', compact('bus', 'ride'));
    }
}

