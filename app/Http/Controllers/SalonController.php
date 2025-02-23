<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SalonController extends Controller
{
    public function index()
    {
        return view('salon.dashboard');
    }
    public function profile(){
        return view('salon.profile');
    }
    public function salon_profile()
    {
        $userId = session('user')->id; // Assuming user_id is stored in session
        $cities = DB::table('cities')->select('id', 'name')->get();
        $salon = DB::table('salons')->where('id_user', $userId)->first(); 

        return view('salon.salon_profile', compact('cities', 'salon'));
    }

    // Add Salon Profile
    public function addSalon(Request $request)
    {
        $request->validate([
            'salon_name' => 'required|string|max:255',
            'salon_address' => 'required|string|max:255',
            'id_city' => 'nullable|integer',
            'salon_logo' => 'nullable|image|mimes:jpg,jpeg,png,svg|max:2048',
            'opening_time' => 'required|string',
            'closing_time' => 'required|string',
            'salon_phone' => 'required|string|max:20',
            'salon_email' => 'required|email|max:255|unique:salons,salon_email',
        ]);

        $userId = session('user')->id;

        $logoPath = null;
        if ($request->hasFile('salon_logo')) {
            $destinationPath = public_path('uploads/salons/logos'); // Set the directory
            $file = $request->file('salon_logo');
        
            // Generate filename with salon name and timestamp
            $salonName = str_replace(' ', '_', strtolower($request->salon_name)); // Convert salon name to lowercase and replace spaces with underscores
            $filename = $salonName . '-' . time() . '.' . $file->getClientOriginalExtension();
        
            $file->move($destinationPath, $filename); // Move the file
            $logoPath = 'uploads/salons/logos/' . $filename; // Save relative path in DB
        }

        DB::table('salons')->insert([
            'id_user' => $userId,
            'salon_name' => $request->salon_name,
            'salon_href' => Str::slug($request->salon_name, '-'),
            'salon_address' => $request->salon_address,
            'id_city' => $request->id_city,
            'salon_logo' => $logoPath,
            'opening_time' => $request->opening_time,
            'closing_time' => $request->closing_time,
            'salon_phone' => $request->salon_phone,
            'salon_email' => $request->salon_email,
            'salon_about' => $request->salon_about,
            'salon_status' => 1, // Active by default
            'id_added' => $userId,
            'date_added' => now(),
        ]);

        return redirect()->back()->with('success', 'Salon added successfully');
    }

    // Update Salon Profile
    public function updateSalon(Request $request)
    {
        $request->validate([
            'salon_name' => 'required|string|max:255',
            'salon_address' => 'required|string|max:255',
            'id_city' => 'nullable|integer',
            'opening_time' => 'required|string',
            'closing_time' => 'required|string',
            'salon_phone' => 'required|string|max:20',
            'salon_email' => 'required|email|max:255',
        ]);

        $userId = session('user')->id;

        $salon = DB::table('salons')->where('id_user', $userId)->first();
        if (!$salon) {
            return redirect()->back()->with('error', 'Salon not found.');
        }

        $logoPath = $salon->salon_logo;

        if ($request->hasFile('salon_logo')) {
            // Delete the old logo if it exists
            if ($salon->salon_logo && file_exists(public_path($salon->salon_logo))) {
                unlink(public_path($salon->salon_logo));
            }
        
            // Store new logo with salon name and timestamp
            $destinationPath = public_path('uploads/salons/logos');
            $file = $request->file('salon_logo');
            
            // Generate filename with salon name and timestamp
            $salonName = str_replace(' ', '_', strtolower($salon->salon_name)); // Convert salon name to lowercase and replace spaces with underscores
            $filename = $salonName . '-' . time() . '.' . $file->getClientOriginalExtension();
            
            $file->move($destinationPath, $filename);
            
            // Update logo path
            $logoPath = 'uploads/salons/logos/' . $filename;
        }

        DB::table('salons')->where('id_user', $userId)->update([
            'salon_name' => $request->salon_name,
            'salon_href' => Str::slug($request->salon_name, '-'),
            'salon_address' => $request->salon_address,
            'id_city' => $request->id_city,
            'salon_logo' => $logoPath,
            'opening_time' => $request->opening_time,
            'closing_time' => $request->closing_time,
            'salon_phone' => $request->salon_phone,
            'salon_email' => $request->salon_email,
            'salon_about' => $request->salon_about,
            'id_modify' => $userId,
            'date_modify' => now(),
        ]);

        return redirect()->back()->with('success', 'Salon updated successfully');
    }


    public function bookings(){
        return view('salon.bookings');
    }
    public function signup(Request $request)
    {
        // Validate incoming request
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:' . env('USERS') . ',username',
            'email' => 'required|string|email|max:255|unique:' . env('USERS') . ',email',
            'password' => 'required|string|min:8|confirmed', // Password confirmation field required
        ]);

        // Generate a unique salt
        $salt = bin2hex(random_bytes(16)); // Generates a 32-character unique salt

        // Hash the password
        $password = $request->password;
        $hashedPassword = hash('sha256', $password . $salt);
        for ($round = 0; $round < 65536; $round++) {
            $hashedPassword = hash('sha256', $hashedPassword . $salt);
        }

        // Default photo path
        $photoPath = 'images/default_user.png';

        // Insert user into the database
        $userId = DB::table(env('USERS'))->insertGetId([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'salt' => $salt,
            'password' => $hashedPassword,
            'photo' => $photoPath,
            'status' => 1, // Active by default
            'id_role' => 1, // Default Access
            'login_type' => 3, // Default login type (salon)
        ]);

        // If user is successfully added
        if ($userId) {

            // Fetch the newly created user
            $user = DB::table(env('USERS'))->where('id', $userId)->first();

            // Store user session (log them in)
            session(['user' => $user]);

            sendRemark('Signup Successful', '4', $userId); // Log success event
            sessionMsg('success', 'Signup Successful', 'success'); // Show success message to user
            return redirect('/'); // Redirect to home page
        } else {
            // Handle errors during insert
            return back()->withErrors(['error' => 'Failed to create account. Please try again.'])->withInput();
        }
    }
}
