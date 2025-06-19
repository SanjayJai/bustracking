<?php

// app/Models/Bus.php
namespace App\Models;
use App\Models\Route;
use App\Models\Driver;
use App\Models\Ride;


use Illuminate\Database\Eloquent\Model;

class Bus extends Model
{
    protected $fillable = ['name', 'ac_type', 'route_id', 'driver_id', 'image'];

    public function route()
    {
        return $this->belongsTo(Route::class);
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

   public function activeRide()
{
    return $this->hasOne(Ride::class)->latestOfMany();
}

    
}