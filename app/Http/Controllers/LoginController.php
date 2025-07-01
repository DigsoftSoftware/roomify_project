<?php

namespace App\Http\Controllers;

use App\Models\UsersModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function index(){
        return view ('auth.section.login_layout');
    }
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = UsersModel::where('email', $credentials['email'])->first();

        if ($user && Hash::check($credentials['password'], $user->password)) {
            $request->session()->regenerate();

            Session::put('users_id', $user->id);
            Session::put('users_name', $user->name);
            Session::put('users_username', $user->username);
            Session::put('users_email', $user->email);
            Session::put('users_photo', $user->photo_profile);
            Session::put('users_role', $user->role);

            $roleRedirects = [
                'admin' => route('dashboard.admin'),
                'hotel_owner' => route('dashboard.hotels'), 
                'user' => route('home_login'),
            ];

            if (!array_key_exists($user->role, $roleRedirects)) {
                return response()->json([
                    'message' => 'Role tidak dikenali atau tidak punya akses!'
                ], 403);
            }

            return response()->json([
                'message' => 'Login berhasil!',
                'redirect' => $roleRedirects[$user->role]
            ]);
        }

        return response()->json([
            'message' => 'Email atau password salah!'
        ], 401);
    }


    public function pilihandaftar()
    {
        return view('auth.section.pilihan_register');
    }
    public function indexHotelOwner()
    {
        return view('auth.section.register_hotel_owner');
    }

    public function registerHotelOwner(Request $request)
    {
        response()->json($request->all()); 
    
        $validatedData = $request->validate([
            'username' => 'required|string|max:15',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'password' => 'required',
        ]);
    
        $users = UsersModel::create([
            'username'=> $validatedData['username'],
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
            'role' => 'hotel_owner',
        ]);
    
        return response()->json([
            'success' => true,
            'message' => 'Pendaftaran berhasil! Silakan login.',
            'redirect' => route('login')
        ]);
    }
    public function indexUsers()
    {
        return view('auth.section.register_user');
    }

    public function registerUsers(Request $request)
    {
        response()->json($request->all()); 
    
        $validatedData = $request->validate([
            'username' => 'required|string|max:15',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'password' => 'required',
        ]);
    
        $users = UsersModel::create([
            'username'=> $validatedData['username'],
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
            'role' => 'user',
        ]);
    
        return response()->json([
            'success' => true,
            'message' => 'Pendaftaran berhasil! Silakan login.',
            'redirect' => route('login')
        ]);
    }
    
    public function logout(Request $request)
    { 
        Session::flush();
        return redirect()->route('login')->with('success', 'Anda telah logout.');
    }
}
