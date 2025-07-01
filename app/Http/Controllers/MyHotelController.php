<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\HotelPhoto;   
use App\Models\UsersModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MyHotelController extends Controller
{
    public function index()
    {
        $hotels = Hotel::with('owner')->get();
        return view('admin.section.hotels.hotel_list', compact('hotels'));
    }

    public function create()
    {
        $hotelOwners = UsersModel::where('role', 'hotel_owner')->get();
        return view('admin.section.hotels.hotel_create', compact('hotelOwners'));
    }

   public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'name' => 'required|string|max:100',
            'address' => 'required|string',
            'latitude' => 'required',
            'longitude' => 'required',
            'photos' => 'required|array|min:3',
            'photos.*' => 'image|mimes:jpg,jpeg,png|max:2048',
            'rating' => 'nullable|numeric|min:0|max:5',
            'description' => 'nullable|string'
        ]);

        $data = $request->only(['name', 'address', 'description','latitude', 'longitude', 'rating']);
        $data['owner_id'] = $request->input('user_id');
        $hotel = Hotel::create($data);

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $path = $photo->store('hotel_photos', 'public');

                HotelPhoto::create([
                    'hotel_id' => $hotel->id,
                    'photo' => $path,
                ]);
            }
        }

        return redirect()->route('myhotel.index')->with('success', 'Hotel berhasil ditambahkan.');
    }

    public function detail($id)
    {
        $hotel = Hotel::with('photos')->findOrFail($id);
        return view('admin.section.hotels.hotel_detail', compact('hotel'));
    }


    public function edit($id)
    {
        $hotel = Hotel::findOrFail($id);
        $hotelOwners = UsersModel::where('role', 'hotel_owner')->get();
        return view('admin.section.hotels.hotel_edit', compact('hotelOwners', 'hotel'));
    }

   public function update(Request $request, $id)
    {
        $hotel = Hotel::findOrFail($id);

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'photos.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'rating' => 'required|integer|between:1,5',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'address' => 'required|string|max:255',
        ]);

        $data = $request->only(['name', 'address', 'description', 'latitude', 'longitude', 'rating']);
        $data['owner_id'] = $request->input('user_id');

        $hotel->update($data);

        if ($request->hasFile('photos')) {
            foreach ($hotel->photos as $existingPhoto) {
                Storage::delete('public/' . $existingPhoto->photo);
                $existingPhoto->delete();
            }

            foreach ($request->file('photos') as $photo) {
                $path = $photo->store('hotel_photos', 'public');
                HotelPhoto::create([
                    'hotel_id' => $hotel->id,
                    'photo' => $path,
                ]);
            }
        }


        return redirect()->route('myhotel.index')->with('success', 'Hotel berhasil diupdate.');
    }

        
    public function destroy($id)
    {
        $hotel = Hotel::with('photos')->findOrFail($id);

        foreach ($hotel->photos as $photo) {
            if (Storage::disk('public')->exists($photo->photo)) {
                Storage::disk('public')->delete($photo->photo); 
            }
            $photo->delete(); 
        }

        $hotel->delete();

        return redirect()->route('myhotel.index')->with('success', 'Hotel berhasil dihapus.');
    }
}
