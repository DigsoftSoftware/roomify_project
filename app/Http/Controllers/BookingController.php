<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use App\Models\UsersModel;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::all();
        return view('admin.section.booking.booking_list', compact('bookings'));
    }

   public function detail($id)
    {
        $booking = Booking::with(['user', 'room.hotel.photos'])->findOrFail($id);
        return view('admin.section.booking.booking_detail', compact('booking'));
    }


}
