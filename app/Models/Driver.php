<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    protected $fillable = [
        'user_id',
        'phone_number',
        'address',
        'city',
        'DOB',
        'license_number',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
  public function buses()
    {
        return $this->hasMany(Bus::class);
    }

  


}
