<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Hotel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::with('hotel')->get();
        return view('admin.section.room.room_list', compact('rooms'));
    }

    public function create()
    {
        $hotels = Hotel::all();
        return view('admin.section.room.room_create', compact('hotels'));
    }

   public function store(Request $request)
    {
        $request->validate([
            'hotel_id' => 'required|exists:hotels,id',
            'type' => 'required|string|max:50',
            'price' => 'required|numeric',
            'availability' => 'required|boolean',
        ]);

        Room::create([
            'hotel_id' => $request->hotel_id,
            'type' => $request->type,
            'price' => $request->price,
            'availability' => $request->availability,
        ]);

        return redirect()->route('room.index')->with('success', 'Data kamar berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $room = Room::findOrFail($id);
        $hotels = Hotel::all();
        return view('admin.section.room.room_edit', compact('room', 'hotels'));
    }

    public function update(Request $request, $id)
    {
        $room = Room::findOrFail($id);

        $request->validate([
            'hotel_id' => 'required|exists:hotels,id',
            'type' => 'required|string|max:50',
            'price' => 'required|numeric',
            'availability' => 'required|boolean',
        ]);

        $room->update([
            'hotel_id' => $request->hotel_id,
            'type' => $request->type,
            'price' => $request->price,
            'availability' => $request->availability,
        ]);

        return redirect()->route('room.index')->with('success', 'Data kamar berhasil diperbarui.');
    }


    public function destroy($id)
    {
        $room = Room::findOrFail($id);
        $room->delete();

        return redirect()->route('room.index')->with('success', 'Data kamar berhasil dihapus.');
    }
}
