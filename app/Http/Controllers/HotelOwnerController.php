<?php

namespace App\Http\Controllers;

use App\Models\UsersModel;
use App\Models\Hotel;
use App\Models\Room;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class HotelOwnerController extends Controller
{
    public function index(){
       $data = [
            'countUsers' => UsersModel::where('role', 'user')->count(),
            'countOwners' => UsersModel::where('role', 'hotel_owner')->count(),
            'countHotels' => Hotel::count(),
            'countRooms' => Room::count(),
            'countBookings' => Booking::count(),
        ];
        return view('admin.section.index.view_dashboard', $data);
    }

    public function indexdata(){
        $users = UsersModel::where('role', 'hotel_owner')->get();
        return view('admin.section.hotels.owners_list', compact('users'));
    }
    public function create()
    {
        $hotelOwners = UsersModel::where('role', 'hotel_owner')->get();
        return view('admin.section.hotels.owners_create', compact('hotelOwners'));
    }

    public function store(Request $request) 
    {
        $request->validate([
            'name' => 'required',
            'username' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'phone' => 'nullable',
            'photo_profile' => 'nullable|image'
        ]);

        $data = $request->except('password', 'photo_profile');
        $data['role'] = $request->input('role', 'hotel_owner');
        $data['password'] = Hash::make($request->password);

        $user = new UsersModel($data);
        if ($request->hasFile('photo_profile')) {
            $path = $request->file('photo_profile')->store('admins', 'public');
            $user->photo_profile = $path;
        }

        $user->save();

        return redirect()->route('hotels.index')->with('success', 'Data Pemilik Hotel berhasil ditambahkan.');
    }

    public function edithw($id){
    $user = UsersModel::findOrFail($id);
    return view('admin.section.hotels.owners_editprofile', compact('user'));
    }

    public function updatehw(Request $request, $id){
        $user = UsersModel::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'username' => 'required|unique:users,username,' . $user->id,
            'phone' => 'nullable',
            'photo_profile' => 'nullable|image',
        ]);

        $data = $request->except(['password', 'photo_profile', 'email']); 
        $data['role'] = $request->input('role', $user->role);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        if ($request->hasFile('photo_profile')) {
            $path = $request->file('photo_profile')->store('admins', 'public');
            $data['photo_profile'] = $path;
        }

        $user->update($data);

        return redirect()->route('dashboard.hotels')->with('success', 'Data Pemilik Hotel berhasil diperbarui.');
    }

    public function edit($id) {
        $user = UsersModel::findOrFail($id);
        return view('admin.section.hotels.owners_edit', compact('user'));
    }

    public function update(Request $request, $id) {
        $user = UsersModel::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'username' => 'required|unique:users,username,' . $user->id,
            'phone' => 'nullable',
            'photo_profile' => 'nullable|image',
        ]);

        $data = $request->except(['password', 'photo_profile', 'email']); 
        $data['role'] = $request->input('role', $user->role);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        if ($request->hasFile('photo_profile')) {
            $path = $request->file('photo_profile')->store('admins', 'public');
            $data['photo_profile'] = $path;
        }

        $user->update($data);

        return redirect()->route('hotels.index')->with('success', 'Data Pemilik Hotel berhasil diperbarui.');
    }

    public function destroy($id) {
        $user = UsersModel::findOrFail($id);
        $user->delete();

        return redirect()->route('hotels.index')->with('success', 'Data Pemilik Hotel berhasil dihapus.');
    }
}
