<?php
// routes/api.php
use App\Models\Ride;
use App\Models\Bus;

Route::get('/bus-locations', function () {
    $activeRides = Ride::where('status', 'Active')
        ->with(['bus', 'bus.route', 'bus.driver'])
        ->get();

    return $activeRides->map(function ($ride) {
        return [
            'id' => $ride->bus->id,
            'name' => $ride->bus->name,
            'latitude' => $ride->current_lat ?? 51.505,
            'longitude' => $ride->current_lng ?? -0.09,
            'route_name' => $ride->bus->route->name ?? 'N/A',
            'driver_name' => $ride->bus->driver->name ?? 'N/A',
            'status' => $ride->status,
            'ac_type' => $ride->bus->ac_type,
        ];
    });
});

Route::get('/bus-status', function () {
    $activeRides = Ride::where('status', 'Active')->get();
    $totalBuses = Bus::count();

    return [
        'on_route' => $activeRides->count(),
        'delayed' => 0, // Add delay logic if needed
        'issue' => 0, // Add issue logic if needed
        'idle' => $totalBuses - $activeRides->count(),
    ];
});

Route::get('/bus-suggestions', function () {
    $query = request('query');
    return Bus::where('name', 'like', "%$query%")->get(['id', 'name']);
});