<?php
// app/Models/Ride.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ride extends Model
{
    protected $fillable = ['bus_id', 'driver_id', 'status', 'current_lat', 'current_lng', 'started_at', 'ended_at'];

    public function bus()
    {
        return $this->belongsTo(Bus::class);
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }
}