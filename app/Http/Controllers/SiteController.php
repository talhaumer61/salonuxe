<?php

namespace App\Http\Controllers;

use App\Models\ServiceType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\View;


class SiteController extends Controller
{
    public function home(){
        $services = ServiceType::where('status', 1)
                    ->where('is_deleted', 0)
                    ->inRandomOrder()
                    ->limit(4)
                    ->get();

        return view('home', compact('services'));
    }

    // public function salons(Request $request)
    // {
    //     $query = DB::table('salons')
    //         ->leftJoin('cities', 'salons.id_city', '=', 'cities.id')
    //         ->select('salons.*', 'cities.name as city_name')
    //         ->where('salons.is_deleted', 0)
    //         ->where('salons.salon_status', 1);

    //     if ($request->filled('search')) {
    //         $query->where('salons.salon_name', 'like', '%' . $request->search . '%');
    //     }

    //     if ($request->filled('city')) {
    //         $query->where('cities.name', $request->city);
    //     }

    //     $salons = $query->orderByDesc('salons.date_added')->get();
    //     $cities = DB::table('cities')->pluck('name');

    //     // 👇 Use this for AJAX like in services module
    //     if ($request->ajax()) {
    //         $html = view('salons', compact('salons', 'cities'))->render();
    //         return response()->json(['html' => $html]);
    //     }

    //     return view('salons', compact('salons', 'cities'));
    // }
    public function salons(Request $request)
    {
        $query = DB::table('salons')
            ->leftJoin('cities', 'salons.id_city', '=', 'cities.id')
            ->leftJoin('salon_jobs', function($join) {
                $join->on('salons.salon_id', '=', 'salon_jobs.id_salon')
                    ->where('salon_jobs.job_status', 1); // only open jobs
            })
            ->select(
                'salons.salon_id',
                'salons.salon_name',
                'salons.salon_logo',
                'salons.salon_href',
                'salons.date_added',
                'cities.name as city_name',
                DB::raw('COUNT(salon_jobs.job_id) as open_jobs_count')
            )
            ->where('salons.is_deleted', 0)
            ->where('salons.salon_status', 1)
            ->groupBy(
                'salons.salon_id',
                'salons.salon_name',
                'salons.salon_logo',
                'salons.salon_href',
                'salons.date_added',
                'cities.name'
            );

        // 🔍 Search filter
        if ($request->filled('search')) {
            $query->where('salons.salon_name', 'like', '%' . $request->search . '%');
        }

        // 🏙 City filter
        if ($request->filled('city')) {
            $query->where('cities.name', $request->city);
        }

        // 📋 Get salons
        $salons = $query->orderByDesc('salons.date_added')->get();

        // 🏙 Get all cities for filter dropdown
        $cities = DB::table('cities')->pluck('name');

        // ⚡ AJAX request (filters/search)
        if ($request->ajax()) {
            $html = view('salons', compact('salons', 'cities'))->render();
            return response()->json(['html' => $html]);
        }

        return view('salons', compact('salons', 'cities'));
    }

    public function salonDetail($href)
    {
        // Get salon info
        $salon = DB::table('salons')
            ->leftJoin('cities', 'salons.id_city', '=', 'cities.id')
            ->where('salon_href', $href)
            ->where('salons.is_deleted', 0)
            ->select(
                'salons.*',
                'cities.name as city_name'
            )
            ->first();

        if (!$salon) {
            abort(404);
        }

        // Get this salon's services
        $services = DB::table('services')
            ->join('service_types', 'services.id_type', '=', 'service_types.id')
            ->where('services.id_salon', $salon->salon_id)
            ->where('services.service_status', 1)
            ->where('services.is_deleted', 0)
            ->where('service_types.status', 1)
            ->where('service_types.is_deleted', 0)
            ->select(
                'services.*',
                'service_types.name as type_name',
                'service_types.href as type_href'
            )
            ->get()
            ->groupBy('id_type');

        // Get salon jobs
        $jobs = DB::table('salon_jobs')
            ->where('id_salon', $salon->salon_id)
            ->where('is_deleted', 0)
            ->orderBy('date_added', 'desc')
            ->get();

        return view('salons', compact('salon', 'services', 'jobs', 'href'));
    }



    public function available_services(Request $request, $href = null)
    {
        $query = DB::table('services')
            ->join('service_types', 'services.id_type', '=', 'service_types.id')
            ->join('salons', 'services.id_salon', '=', 'salons.salon_id')
            ->leftJoin('cities', 'salons.id_city', '=', 'cities.id')
            ->where('services.service_status', 1)
            ->where('services.is_deleted', 0)
            ->where('service_types.status', 1)
            ->where('service_types.is_deleted', 0)
            ->where('salons.is_deleted', 0)
            ->where('salons.salon_status', 1)
            ->select(
                'services.*',
                'service_types.name as type_name',
                'service_types.href as type_href',
                'salons.salon_name',
                'salons.salon_logo',
                'cities.name as city_name'
            );

        if ($href) {
            $query->where('service_types.href', $href);
        }

        // Apply filters
        if ($request->filled('search')) {
            $query->where('services.service_name', 'LIKE', '%' . $request->search . '%');
        }

        if ($request->filled('city')) {
            $query->where('cities.name', $request->city);
        }

        if ($request->filled('min_price')) {
            $query->where('services.service_price', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('services.service_price', '<=', $request->max_price);
        }

        $services = $query->inRandomOrder()->get()->groupBy('id_type')->map(fn($g) => $g->take(7));
        $flatServices = $services->flatten(1);
        $cities = DB::table('cities')->pluck('name');

        // If AJAX, return only services section as rendered HTML
        if ($request->ajax()) {
            $html = view('services', compact('services', 'href', 'cities', 'flatServices'))->render();
            return response()->json(['html' => $html]);
        } 

        return view('services', compact('services', 'href', 'cities', 'flatServices'));
    }

    
    public function about() {
        $faqs = DB::table('faqs')
            ->where('is_deleted', 0)
            ->where('status', 1) // show only active ones
            ->orderBy('id', 'desc')
            ->get();

        return view('about', compact('faqs'));
    }
    public function contact(){
        return view('contact');
    }
    public function regiter_salon(){
        return view('salon.signup');
    }

    public function user_login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = DB::table('users')
                ->where(function ($query) use ($request) {
                    $query->where('username', $request->username)
                        ->orWhere('email', $request->username);
                })
                ->first();
        if ($user && $user->login_type == 3) {
            $salon = DB::table('salons')->where('id_user', $user->id)->where('is_deleted', 0)->first();

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

                DB::table('sl_login_history')->insert([
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

    // update user profile
    public function updateProfile(Request $request)
    {
        $userId = session('user')->id;

        // Validation
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $userId,
            'phone' => 'nullable|string|max:20',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Prepare data
        $data = [
            'name' => $request->name,
            'username' => $request->username,
            'phone' => $request->phone,
            'id_modify' => $userId,
            'date_modify' => now()
        ];

        // Handle photo upload
        // 📸 Handle photo upload
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $relativePath = 'uploads/users/' . $filename;

            // Move to public path
            $file->move(public_path('uploads/users'), $filename);

            // Save path like 'images/uploads/users/abc.jpg'
            $data['photo'] = $relativePath;
        }

        // Update user
        DB::table('users')->where('id', $userId)->update($data);

        // Refresh session
        $user = DB::table('users')->where('id', $userId)->first();
        session(['user' => $user]);

        return back()->with('success', 'Profile updated successfully!');
    }
    // Change Password
    public function changePassword(Request $request)
    {
        $user = session('user');
        $dbUser = DB::table(env('USERS'))->where('id', $user->id)->first();

        // ✅ Always validate the new password and its confirmation
        $request->validate([
            'new_password' => 'required|string|min:8',
            'new_password_confirmation' => 'required|same:new_password',
        ]);

        // 🛑 Only require old password for users who have one
        if (!empty($dbUser->password) && !empty($dbUser->salt)) {
            $request->validate([
                'current_password' => 'required|string',
            ]);

            $hashedInput = hash('sha256', $request->current_password . $dbUser->salt);
            for ($i = 0; $i < 65536; $i++) {
                $hashedInput = hash('sha256', $hashedInput . $dbUser->salt);
            }

            if ($hashedInput !== $dbUser->password) {
                return back()->withErrors(['current_password' => 'Current password is incorrect.'])
                    ->withInput()
                    ->with('activeTab', 'password');
            }
        }

        // ✅ Set new password and salt
        $newSalt = bin2hex(random_bytes(16));
        $newHashed = hash('sha256', $request->new_password . $newSalt);
        for ($i = 0; $i < 65536; $i++) {
            $newHashed = hash('sha256', $newHashed . $newSalt);
        }

        DB::table(env('USERS'))->where('id', $user->id)->update([
            'salt' => $newSalt,
            'password' => $newHashed,
            'id_modify' => $user->id,
            'date_modify' => now(),
        ]);

        // Refresh session with updated user data
        $updatedUser = DB::table(env('USERS'))->where('id', $user->id)->first();
        session(['user' => $updatedUser]);

        return back()->with('success', 'Password changed successfully!');
    }


}
