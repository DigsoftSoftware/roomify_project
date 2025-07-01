<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Hotel extends Model
{
    use HasFactory;

    protected $fillable = [
        'owner_id', 'name', 'address', 'latitude', 'longitude', 'description','rating'
    ];

    public function owner()
    {
        return $this->belongsTo(UsersModel::class, 'owner_id');
    }

    public function photos()
    {
        return $this->hasMany(HotelPhoto::class, 'hotel_id');
    }

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

}

