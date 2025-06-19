<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    protected $fillable = [
        'name',
        'start_point',
        'end_point',
        'stops',
    ];

    protected $casts = [
        'stops' => 'array', // Cast to array if stops stored as JSON
    ];
}