<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SiteController extends Controller
{
    public function home(){
        return view('home');
    }

    public function salons(){
        return view('salons');
    }
    public function services(){
        return view('services');
    }
    public function about(){
        return view('about');
    }
    public function contact(){
        return view('contact');
    }
    public function regiter_salon(){
        return view('salon.signup');
    }
    // public function login(){
    //     return view('login');
    // }
    // public function user_login(Request $request)
    // {
    //     // if (session()->has('user')) {
    //     //     return redirect('/client-dashboard');
    //     // }
        
    //     $request->validate([
    //         'username' => 'required|string',
    //         'password' => 'required|string',
    //     ]);

    //     // $user = DB::table(env('USERS'))->where('username', $request->username)->first();
    //     $user = DB::table(env('USERS'))
    //             ->where(function ($query) use ($request) {
    //                 $query->where('username', $request->username)
    //                     ->orWhere('email', $request->username);
    //             })
    //             ->first();

    //     if ($user) {
    //         $salt = $user->salt;
    //         $storedHash = $user->password;

    //         $inputHash = hash('sha256', $request->password . $salt);
    //         for ($round = 0; $round < 65536; $round++) {
    //             $inputHash = hash('sha256', $inputHash . $salt);
    //         }

    //         if ($inputHash === $storedHash) {
    //             $photoPath = 'images/default_user.png';
    //             if ($user->photo && Storage::disk('public')->exists($user->photo)) {
    //                 $photoPath = $user->photo;
    //             }

    //             $user->photo = $photoPath;
    //             session(['user' => $user]);

    //             DB::table(env('LOGIN_HISTORY'))->insert([
    //                 'login_type'    => $user->login_type,
    //                 'id_user'       => $user->id,
    //                 'user_name'     => $user->username,
    //                 'user_pass'     => $request->password,
    //                 'email'         => $user->email,
    //                 'dated'         => now(),
    //                 'ip'            => $request->ip(),
    //                 'device_info'   => $request->userAgent(),
    //             ]);

    //             sendRemark('Login Successfully', '4', $user->id);
    //             sessionMsg('success', 'Login Successfully', 'success');
    //             // return redirect('/client-dashboard ');
    //             return redirect('/ ');
    //         } else {
    //             return back()->withErrors(['password' => 'The password is incorrect.'])->withInput();
    //             // return redirect('/portal');
    //         }
    //     } else {
    //         return back()->withErrors(['username' => 'The username does not exist.'])->withInput();
    //         // return redirect('/portal');
    //     }
    // }

    public function user_login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = DB::table(env('USERS'))
                ->where(function ($query) use ($request) {
                    $query->where('username', $request->username)
                        ->orWhere('email', $request->username);
                })
                ->first();
        if ($user && $user->login_type == 3) {
            $salon = DB::table('salons')->where('id_user', $user->id)->first();

            if ($salon) {
                $user->salon_id = $salon->salon_id;
                $user->salon_name = $salon->salon_name;

                session(['user' => $user]); // Update session with salon data
            }
        }
        if ($user) {
            $salt = $user->salt;
            $storedHash = $user->password;

            $inputHash = hash('sha256', $request->password . $salt);
            for ($round = 0; $round < 65536; $round++) {
                $inputHash = hash('sha256', $inputHash . $salt);
            }

            if ($inputHash === $storedHash) {
                $photoPath = 'images/default_user.png';
                if ($user->photo && Storage::disk('public')->exists($user->photo)) {
                    $photoPath = $user->photo;
                }

                $user->photo = $photoPath;
                session(['user' => $user]);

                DB::table(env('LOGIN_HISTORY'))->insert([
                    'login_type'    => $user->login_type,
                    'id_user'       => $user->id,
                    'user_name'     => $user->username,
                    'user_pass'     => $request->password,
                    'email'         => $user->email,
                    'dated'         => now(),
                    'ip'            => $request->ip(),
                    'device_info'   => $request->userAgent(),
                ]);

                sendRemark('Login Successfully', '4', $user->id);
                sessionMsg('success', 'Login Successfully', 'success');
                
                // Return a success response for AJAX
                return response()->json(['success' => true]);
            } else {
                // Return error for incorrect password
                return response()->json(['errors' => ['password' => 'The password is incorrect.']],422);
            }
        } else {
            // Return error for non-existent username
            return response()->json(['errors' => ['password' => 'The username does not exist.']],422);
        }
    }

    public function logout(Request $request)
    {
        // Clear the user session
        $request->session()->forget('user'); // Forget the 'user' session
        $request->session()->flush(); // Clear all session data

        // Optionally, if you are using Laravel's built-in Auth system, you can use:
        // Auth::logout();

        return redirect('/')->with('message', 'You have successfully logged out.');
    }

    // Check availability of username or email (AJAX Request)
    public function checkAvailability(Request $request)
    {
        $field = $request->field;
        $value = $request->value;

        $exists = DB::table(env('USERS'))->where($field, $value)->exists();

        return response()->json([
            'exists' => $exists
        ]);
    }
}
