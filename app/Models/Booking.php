<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'room_id','kode_bookings', 'check_in', 'check_out', 'total_price', 'status'
    ];

    public function user()
    {
        return $this->belongsTo(UsersModel::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class, 'booking_id'); 
    }
}
