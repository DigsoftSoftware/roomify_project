<?php

namespace App\Http\Controllers;

use App\Models\UsersModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function index(){
        $users = UsersModel::where('role', 'user')->get();
        return view('admin.section.users.users_list', compact('users'));
    }

    public function create() {
        return view('admin.section.users.users_create');
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
        $data['role'] = $request->input('role', 'user');
        $data['password'] = Hash::make($request->password);

        $user = new UsersModel($data);
        if ($request->hasFile('photo_profile')) {
            $path = $request->file('photo_profile')->store('users', 'public');
            $user->photo_profile = $path;
        }

        $user->save();

        return redirect()->route('users.index')->with('success', 'Data Users berhasil ditambahkan.');
    }


    public function edit($id) {
        $user = UsersModel::findOrFail($id);
        return view('admin.section.users.users_edit', compact('user'));
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

        return redirect()->route('users.index')->with('success', 'Data Users berhasil diperbarui.');
    }
    public function destroy($id) {
        $user = UsersModel::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')->with('success', 'Data Users berhasil dihapus.');
    }
}

