<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Menu;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();
        $notification = array(
            'message' => 'User Login Successfully',
            'alert-type' => 'success',
        );


        $user = Auth::user();
        $userRole = $user->role; // Misalnya: 'admin' atau 'user'

        
         // Get menus and store them in the session
        // Query untuk menampilkan menu utama berdasarkan role pengguna
        $menus = Menu::whereNull('parent_id') // Ambil menu utama (yang tidak memiliki parent)
        ->where(function ($query) use ($userRole) {
            // Filter berdasarkan role pengguna
            if ($userRole == 'Admin') {
                // Admin bisa mengakses menu dengan role 'admin', 'user', atau 'all users'
                $query->whereIn('role', ['Admin', 'User']);
            } elseif ($userRole == 'User') {
                // User hanya bisa mengakses menu dengan role 'user' atau 'all users'
                $query->whereIn('role', ['User']);
            } 
        })
        ->with(['children' => function ($query) use ($userRole) {
            // Filter submenu berdasarkan role pengguna
            if ($userRole == 'Admin') {
                // Admin bisa mengakses submenu dengan role 'admin', 'user', atau 'all users'
                $query->whereIn('role', ['Admin', 'User']);
            } elseif ($userRole == 'User') {
                // User hanya bisa mengakses submenu dengan role 'user' atau 'all users'
                $query->whereIn('role', ['User']);
            }
        }])
        ->orderBy('order') // Urutkan menu berdasarkan kolom 'order'
        ->get();

        // Store menus in the session
        $request->session()->put('menus', $menus);
        
        return redirect()->intended(RouteServiceProvider::HOME)->with($notification);
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
