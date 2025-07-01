<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Hotel;
use App\Models\Room;
use App\Models\UsersModel;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index(){
        $data = [
            'countUsers' => UsersModel::where('role', 'user')->count(),
            'countOwners' => UsersModel::where('role', 'hotel_owner')->count(),
            'countHotels' => Hotel::count(),
            'countRooms' => Room::count(),
            'countBookings' => Booking::count(),
        ];

        $bookingsPerMonth = Booking::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(*) as total')
        )
            ->whereYear('created_at', Carbon::now()->year)
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->pluck('total', 'month');

        $monthlyData = collect(range(1, 12))->map(function ($month) use ($bookingsPerMonth) {
            return $bookingsPerMonth->get($month, 0);
        });

        $data['bookingsPerMonth'] = $monthlyData;

        return view('admin.section.index.view_dashboard', $data);
    }

    public function indexdata(){
        $users = UsersModel::where('role', 'admin')->get();
        return view('admin.section.admins.admin_list', compact('users'));
    }

    public function create() {
        return view('admin.section.admins.admin_create');
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
        $data['role'] = $request->input('role', 'admin');
        $data['password'] = Hash::make($request->password);

        $user = new UsersModel($data);
        if ($request->hasFile('photo_profile')) {
            $path = $request->file('photo_profile')->store('admins', 'public');
            $user->photo_profile = $path;
        }

        $user->save();

        return redirect()->route('admin.index')->with('success', 'Data Admin berhasil ditambahkan.');
    }


    public function edit($id) {
        $user = UsersModel::findOrFail($id);
        return view('admin.section.admins.admin_edit', compact('user'));
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

        return redirect()->route('admin.index')->with('success', 'Data Admin berhasil diperbarui.');
    }

    public function destroy($id) {
        $user = UsersModel::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.index')->with('success', 'Data Admin berhasil dihapus.');
    }
}

