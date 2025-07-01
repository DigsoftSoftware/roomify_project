<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
    
        $payment = Payment::with(['booking.user', 'booking.room.hotel'])->get();
        return view('admin.section.payment.payment_list', compact('payment'));
    }

   public function detail($id)
    {
        $payment = Payment::with(['booking.user', 'booking.room.hotel.photos'])->findOrFail($id);
        return view('admin.section.payment.payment_detail', compact('payment'));
    }
}
