<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    /**
     * Display a login form.
     */
    public function loginForm()
    {
        if (auth()->check()) {
            return redirect('/dashboard');
        }
        return view('login');
    }

    /**
     * Confirm the user.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        // $auth = auth();
        if (auth()->attempt($credentials)) {
            // Jika sukses login
            $request->session()->regenerate(); // untuk keamanan session

            $user = auth()->user();
            if($user->is_admin) {
                return response()->json([
                    'success' => true,
                    'redirect' => '/dashboard',
                    'email' => $request->email,
                ]);
            }else{
                return response()->json([
                    'success' => true,
                    'redirect' => '/dashboard-karyawan/' . $user->user_id,
                    'email' => $request->email,
                ]);
            }
        }
        return response()->json([
            'success' => false,
            'message' => 'Email atau password salah'
        ]);
    }

    /**
     * Logout the user.
     */
    public function logout(Request $request)
    {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }


    /**
     * Redirect to Google for authentication.
     */
    public function redirectToGoogle(){
        return Socialite::driver('google')->stateless()->redirect();
    }

    /**
     * Handle the callback from Google after authentication.
     */
    public function handleGoogleCallback(){
        $googleUser = Socialite::driver('google')->stateless()->user();
        
        // Cek apakah user sudah ada di database
        $user = User::firstOrCreate(
            ['email' => $googleUser->getEmail()],
            [
                'name' => $googleUser->getName(),
                'password' => null, // atau bcrypt(str_random(16))
            ]
        );

        if(!$user->hasRole('karyawan')) {
            $user->assignRole('karyawan');
        }

        Auth::login($user);
        if($user->is_admin) {
            return redirect()->route('dashboard');
        }else{
            return redirect()->route('dashboard-karyawan', ['user_id' => $user->user_id]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
