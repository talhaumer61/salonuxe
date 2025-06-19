<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ClientController extends Controller
{
    public function index(){
        return view('client.dashboard');
    }
    public function profile(){
        if (!session()->has('activeTab')) {
            session(['activeTab' => 'overview']); // Default to 'overview' tab
        }
        return view('client.profile');
    }
    // List of Booking of a USer
    public function bookings(){
        $userId = session('user')->id;

        $appointments = DB::table('appointments')
            ->join('salons', 'appointments.id_salon', '=', 'salons.salon_id')
            ->join('services', 'appointments.id_service', '=', 'services.service_id')
            ->where('appointments.id_client', $userId)
            ->where('appointments.is_deleted', false)
            ->select(
                'appointments.*',
                'salons.*',
                'services.*'
            )
            ->paginate(10); 

        return view('client.bookings', compact('appointments'));
    }

    // BOOK A SERVICE
    public function book_appointment($href){
        $service = DB::table('services')
        ->join('salons', 'services.id_salon', '=', 'salons.salon_id')
        ->where('services.service_href', $href)
        ->where('services.is_deleted', false)
        ->where('salons.is_deleted', false)
        ->select('services.*', 'salons.*')
        ->first();

        return view('client.book_appointment', compact('service'));
    }
    public function makeAppointment(Request $request)
    {
        // Validation
        $validated = $request->validate([
            'client_name' => 'required|string|max:255',
            'client_phone' => 'required|string|max:20',
            'client_email' => 'required|email|max:255',
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required',
            'id_client' => 'required|integer',
            'id_salon' => 'required|integer',
            'id_service' => 'required|integer',
        ]);

        // Create appointment
        $appointment = Appointment::create([
            'id_client' => $request->id_client,
            'id_salon' => $request->id_salon,
            'id_service' => $request->id_service,
            'client_name' => $request->client_name,
            'client_phone' => $request->client_phone,
            'client_email' => $request->client_email,
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $request->appointment_time,
            'status' => 2, // default: pending
            'href' => Str::uuid(),
            'id_added' => $request->id_client,
            'date_added' => now(),
        ]);

        return redirect('/my-bookings')->with('success', 'Appointment request submitted successfully.');
    }
    // DELETE APPOINTMENT
    public function deleteAppointment($href)
    {
        $appointment = DB::table('appointments')->where('href', $href)->first();

        if (!$appointment) {
            return back()->with('error', 'Appointment not found.');
        }

        if (!in_array($appointment->status, [2, 3])) {
            return back()->with('error', 'Only pending or rejected appointments can be deleted.');
        }

        DB::table('appointments')->where('href', $href)->update([
            'is_deleted' => 1,
            'id_deleted' => session('user')->id,
            'date_deleted' => now(),
            'ip_deleted' => request()->ip(),
        ]);

        return back()->with('success', 'Appointment deleted successfully.');
    }

    // USER SIGN-UP
    public function signup(Request $request)
    {
        // Validate incoming request
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|string|email|max:255|unique:users,email',
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
        $userId = DB::table('users')->insertGetId([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'salt' => $salt,
            'password' => $hashedPassword,
            'photo' => $photoPath,
            'status' => 1, // Active by default
            'id_role' => 1, // Default Access
            'login_type' => 2, // Default login type (client)
        ]);

        // If user is successfully added
        if ($userId) {
            sendRemark('Signup Successful', '4', $userId); // Log success event
            sessionMsg('success', 'Signup Successful', 'success'); // Show success message to user
            return redirect('/'); // Redirect to login page
        } else {
            // Handle errors during insert
            return back()->withErrors(['error' => 'Failed to create account. Please try again.'])->withInput();
        }
    }
}
