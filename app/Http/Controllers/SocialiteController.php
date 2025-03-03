<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Exception;

class SocialiteController extends Controller
{
    // Controla los valores que da el login 
    public function googleAuthentication()
{
    try {
        $googleUser = Socialite::driver('google')->stateless()->user(); // Aquí agregamos stateless()
        $user = User::where('google_id', $googleUser->id)->first();

        if ($user) {
            Auth::login($user);
            return redirect()->route('dashboard');
        } else {
            $userdata = User::create([
                'name' => $googleUser->name,
                'email' => $googleUser->email,
                'password' => Hash::make('12345678'),
                'google_id' => $googleUser->id,
                'role' => "operario"
            ]);

            if ($userdata) {
                Auth::login($userdata);
                return redirect()->route('dashboard');
            }
        }
    } catch (Exception $e) {
        \Log::error('Google Auth Error: ' . $e->getMessage());
        return redirect()->route('login')->with('error', 'No se pudo iniciar sesión con Google.');
    }
}


    // Función que controla el login con Google
    public function googlelogin()
    {
        return Socialite::driver('google')->redirect();
    }
}
