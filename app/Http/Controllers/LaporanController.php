<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\UsersModel; 
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    public function index()
    {
        $users = UsersModel::where('role', 'user')->orderBy('name')->get();
        return view('admin.section.laporan.laporan_list', compact('users'));
    }

     public function cetak(Request $request)
    {
        $request->validate([
            'jenis' => 'required|in:semua,per_user',
            'user_id' => 'required_if:jenis,per_user|exists:users,id'
        ]);

        $jenis = $request->get('jenis');

        if ($jenis == 'semua') {
            $bookings = Booking::with(['user', 'room.hotel'])
                ->whereIn('status', ['confirmed', 'cancelled'])
                ->get();

             if ($bookings->isEmpty()) {
                return view('admin.section.laporan.laporan_kosong', [
                    'message' => 'Tidak ada data pemesanan sama sekali untuk dicetak.'
                ]);
            }

            $pdf = Pdf::loadView('admin.section.laporan.laporan_pdf_semua', ['bookings' => $bookings]);

        } elseif ($jenis == 'per_user') {
            $userId = $request->get('user_id');
            $user = UsersModel::findOrFail($userId);
            $bookings = Booking::with(['room.hotel'])
                ->where('user_id', $userId)
                ->get();

            if ($bookings->isEmpty()) {
                return view('admin.section.laporan.laporan_kosong', [
                    'message' => "Tidak ada data pemesanan yang dapat dicetak untuk user '{$user->name}'."
                ]);
            }
            
            $pdf = Pdf::loadView('admin.section.laporan.laporan_pdf_per_user', ['bookings' => $bookings, 'user' => $user]);
        }

        $pdf->setPaper('a4', 'landscape');
        return $pdf->stream("laporan_{$jenis}.pdf");
    }
}