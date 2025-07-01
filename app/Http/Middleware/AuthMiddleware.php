<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Session;

class AuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Cek apakah user login
        if (!Session::has('users_id')) {
            return redirect()->route('login')->with('error', 'Anda belum login!');
        }

        // Ambil role dari session
        $userRole = Session::get('users_role');

        // Cek apakah role user sesuai dengan yang diperbolehkan
        if (!in_array($userRole, $roles)) {
            Session::flush();
            return redirect('/login')->with('error', 'Akses ditolak, Silahkan Login Kembali!');
        }

        return $next($request);
    }

}
