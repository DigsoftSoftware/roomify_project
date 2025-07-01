<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Room extends Model
{
    use HasFactory;

    protected $table = 'rooms';

    protected $fillable = [
        'hotel_id',
        'type',
        'price',
        'availability',
    ];

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }
}
