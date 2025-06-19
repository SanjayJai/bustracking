<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bus;
use App\Models\Route;

class BusController extends Controller
{
    public function index(Request $request)
    {
        $query = Bus::with('route');

        // Filter by name
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Filter by AC type
        if ($request->filled('ac_type')) {
            $query->where('ac_type', $request->ac_type);
        }

        // Filter by Route
        if ($request->filled('route_id')) {
            $query->where('route_id', $request->route_id);
        }

        $buses = $query->paginate(10);
        $routes = Route::all();

        return view('bus', compact('buses', 'routes'));
    }
}
