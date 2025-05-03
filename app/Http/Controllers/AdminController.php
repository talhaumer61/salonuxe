<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function index(){
        return view('admin.dashboard');
    }
    public function adminLogin(){
        return view('admin.login');
    }
    public function profile(){
        return view('admin.profile');
    }
    public function appointments(){
        return view('admin.bookings');
    }
    public function added_services(){
        $services = DB::table('services')
        ->join('salons', 'services.id_salon', '=', 'salons.salon_id')
        ->join('service_types', 'services.id_type', '=', 'service_types.id')
        ->where('services.is_deleted', false)
        ->whereIn('services.service_status', [1, 2, 3])
        ->select(
            'services.*',
            'service_types.name AS category',
            'salons.salon_name'
        )
        ->orderByRaw("FIELD(services.service_status, 2, 1, 3)")
        ->paginate(10);

        return view('admin.services', compact('services'));
    }
    // // APPROVE/REJECT SERVICE
    public function changeStatus($href, $status)
    {
        // Optional: validate status
        if (!in_array($status, [1, 3])) {
            return redirect()->back()->with('error', 'Invalid status selected.');
        }

        $service = DB::table('services')->where('service_href', $href)->first();

        if (!$service) {
            return redirect()->back()->with('error', 'Service not found.');
        }

        DB::table('services')
            ->where('service_href', $href)
            ->update([
                'service_status' => $status
            ]);

        return redirect()->back()->with('success', 'Service status updated successfully.');
    }

    public function users(){
        $users = DB::table('users')
        ->where('is_deleted', 0)
        // ->where('status', 1)
        ->where('login_type', 2)
        ->paginate(10); // Fetch all matching users
    
        return view('admin.users', compact('users'));

    }
    
    public function login(Request $request)
    {
        // if (session()->has('user')) {
        //     return redirect('/client-dashboard');
        // }
        
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // $user = DB::table(env('USERS'))->where('username', $request->username)->first();
        $user = DB::table(env('USERS'))
                ->where(function ($query) use ($request) {
                    $query->where('username', $request->username)
                        ->orWhere('email', $request->username);
                })
                ->first();

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
                // return redirect('/client-dashboard ');
                return redirect('/admin');
            } else {
                return back()->withErrors(['password' => 'The password is incorrect.'])->withInput();
                // return redirect('/portal');
            }
        } else {
            return back()->withErrors(['username' => 'The username does not exist.'])->withInput();
            // return redirect('/portal');
        }
    }
}
