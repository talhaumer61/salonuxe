<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class GoogleAuthController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Check if user already exists
            $user = DB::table('users')->where('email', $googleUser->getEmail())->first();

            if ($user) {
                // Existing user — login & store session
                // Auth::loginUsingId($user->id);
                session(['user' => $user]);
            } else {
                // Create a new user without password
                $username = explode('@', $googleUser->getEmail())[0] . rand(1000, 9999);
                $photoPath = $googleUser->getAvatar() ?? 'images/default_user.png';

                $userId = DB::table('users')->insertGetId([
                    'name'        => $googleUser->getName(),
                    'email'       => $googleUser->getEmail(),
                    'username'    => $username,
                    'salt'        => null,
                    'password'    => null,
                    'photo'       => $photoPath,
                    'status'      => 1,
                    'id_role'     => 1,
                    'login_type'  => 2, // Google login
                    'date_added'  => now(),
                ]);

                $user = DB::table('users')->where('id', $userId)->first();

                // Store entire user in session
                // Auth::loginUsingId($user->id);
                session(['user' => $user]);

                sendRemark('Signup Successful via Google', '4', $userId);
                sessionMsg('success', 'Signup Successful via Google', 'success');
            }

            return redirect('/user-profile')->with('activeTab', 'password');

        } catch (\Exception $e) {
            Log::error('Google OAuth Error: ' . $e->getMessage());
            return redirect('/')->withErrors(['google_error' => 'Google login failed.']);
        }
    }

    public function redirectToGoogleSalon()
    {
        return Socialite::driver('google')
            ->with(['redirect_uri' => route('google.salon.callback')])
            ->redirect();
    }

    public function handleGoogleCallbackSalon()
    {
        try {
            $googleUser = Socialite::driver('google')
            ->with(['redirect_uri' => route('google.salon.callback')])
            ->user();

            $user = DB::table('users')->where('email', $googleUser->getEmail())->first();

            if ($user) {
                Auth::loginUsingId($user->id);
                session(['user' => $user, 'user_id' => $user->id]);
            } else {
                $username = explode('@', $googleUser->getEmail())[0] . rand(1000, 9999);
                $photoPath = $googleUser->getAvatar() ?? 'images/default_user.png';

                $userId = DB::table('users')->insertGetId([
                    'name'       => $googleUser->getName(),
                    'email'      => $googleUser->getEmail(),
                    'username'   => $username,
                    'salt'       => null,
                    'password'   => null,
                    'photo'      => $photoPath,
                    'status'     => 1,
                    'id_role'    => 1,
                    'login_type' => 3, // 👉 salon owner
                    'date_added' => now(),
                ]);

                $user = DB::table('users')->where('id', $userId)->first();
                Auth::loginUsingId($user->id);
                session(['user' => $user, 'user_id' => $user->id]);

                sendRemark('Signup Successful via Google (Salon)', '4', $userId);
                sessionMsg('success', 'Signup Successful via Google', 'success');
            }

            return redirect('/profile')->with('activeTab', 'password'); // or salon dashboard

        } catch (\Exception $e) {
            Log::error('Salon Google Signup Error: ' . $e->getMessage());
            return redirect('/register-salon')->withErrors(['google_error' => 'Google login failed.']);
        }
    }




}
