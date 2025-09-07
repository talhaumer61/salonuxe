<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\ServiceType;
use App\Models\Service;
use Illuminate\Support\Facades\Mail;
use App\Mail\AppointmentStatusUpdated;
use Illuminate\Support\Facades\Log;


class SalonController extends Controller
{
    public function index()
    {   
        return view('salon.dashboard');
    }
    // user profile
    public function profile(){
        if (!session()->has('activeTab')) {
            session(['activeTab' => 'overview']); // Default to 'overview' tab
        }
        return view('salon.profile');
    }

    // salon profile
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

    // Salon Services
    // public function services($action = "list", $href = null) {
    //     $salon = DB::table('salons')
    //         ->where('id_user', session('user')->id)
    //         ->where('salon_status', 1)
    //         ->where('is_deleted', 0)
    //         ->first();

    //     $serviceTypes = ServiceType::where('is_deleted', 0)
    //         ->where('status', 1)
    //         ->get();

    //     $services = Service::where('is_deleted', 0)
    //         ->where('id_salon', session('user')->salon_id)
    //         ->whereIn('service_status', [1, 2])
    //         ->paginate(10);

    //     if ($action === "edit" && isset($href)) {
    //         $service = Service::where('service_href', $href)
    //             ->where('is_deleted', 0)
    //             ->where('id_salon', $salon->salon_id)
    //             ->firstOrFail();

    //         return view('salon.services', compact('action', 'service', 'serviceTypes', 'href', 'salon'));
    //     } 
    //     elseif ($action === "add") {
    //         $serviceTypes = DB::table('service_types')
    //         ->where('is_deleted', 0)
    //         ->where('status', 1)
    //         ->get();

    //         $services = DB::table('services')
    //             ->where('is_deleted', 0)
    //             ->where('id_salon', session('user')->salon_id)
    //             ->whereIn('service_status', [1,2])
    //             ->paginate(10);

    //         // fetch attributes for all types and group by type id
    //         $attributes = DB::table('attributes')
    //             ->whereIn('service_type_id', $serviceTypes->pluck('id'))
    //             ->get()
    //             ->groupBy('service_type_id');

    //         // attach options to each attribute
    //         foreach ($attributes as $serviceTypeId => $group) {
    //             foreach ($group as $attribute) {
    //                 $attribute->options = DB::table('attribute_options')
    //                     ->where('attribute_id', $attribute->id)
    //                     ->get();
    //             }
    //         }

    //         // now pass $attributes (grouped), $serviceTypes, $services, $salon to view
    //         return view('salon.services', compact('action','serviceTypes','services','salon','attributes'));
    //     }
    //     else {
    //         return view('salon.services', compact('action', 'services', 'salon'));
    //     }
    // }
    public function services($action = "list", $href = null)
    {
        $salon = DB::table('salons')
            ->where('id_user', session('user')->id)
            ->where('salon_status', 1)
            ->where('is_deleted', 0)
            ->first();

        // Check if salon exists and has a profile
        if (!$salon) {
            // Your existing logic for un-profiled salons
            return view('salon.services', compact('salon'));
        }

        // Fetch service types and attributes for both add and edit forms
        $serviceTypes = DB::table('service_types')
            ->where('is_deleted', 0)
            ->where('status', 1)
            ->get();
        
        $attributes = DB::table('attributes')
            ->whereIn('service_type_id', $serviceTypes->pluck('id'))
            ->get()
            ->groupBy('service_type_id');

        foreach ($attributes as $serviceTypeId => $group) {
            foreach ($group as $attribute) {
                $attribute->options = DB::table('attribute_options')
                    ->where('attribute_id', $attribute->id)
                    ->get();
            }
        }
        
        // Handle 'edit' action
        if ($action === "edit" && isset($href)) {
            $service = DB::table('services')
                ->where('service_href', $href)
                ->where('is_deleted', 0)
                ->where('id_salon', $salon->salon_id) // Use the correct column name from your salon table
                ->first();

            if (!$service) {
                return redirect()->view('salon.services')->with('error', 'Service not found or you do not have permission to edit it.');
            }

            // Fetch existing attribute values for the service
            $serviceAttributes = DB::table('service_attributes')
                ->where('service_id', $service->service_id)
                ->get();
            
            // Re-organize service attributes for easy access in the view
            $preselectedValues = [];
            foreach ($serviceAttributes as $sa) {
                if ($sa->option_id) {
                    if (!isset($preselectedValues[$sa->attribute_id])) {
                        $preselectedValues[$sa->attribute_id] = [];
                    }
                    $preselectedValues[$sa->attribute_id][] = $sa->option_id;
                } else {
                    $preselectedValues[$sa->attribute_id] = $sa->custom_value;
                }
            }

            return view('salon.services', compact('action', 'service', 'serviceTypes', 'href', 'salon', 'attributes', 'preselectedValues'));
        }
        
        // Handle 'add' action
        if ($action === "add") {
            return view('salon.services', compact('action', 'serviceTypes', 'salon', 'attributes'));
        }
        
        // Handle 'list' action
        $services = DB::table('services')
            ->where('is_deleted', 0)
            ->where('id_salon', $salon->salon_id)
            ->whereIn('service_status', [1,2])
            ->paginate(10);
            
        return view('salon.services', compact('action', 'services', 'salon'));
    }
    // Add salon service
    public function addService(Request $request)
    {
        $request->validate([
            'service_name'  => 'required|string|max:255',
            'service_type_id'=> 'required|exists:service_types,id',
            'service_price' => 'nullable|numeric',
            'service_desc'  => 'nullable|string',
            'service_photo' => 'nullable|image|max:2048',
            'attributes'    => 'nullable|array', // dynamic attributes
        ]);

        // handle photo...
        $photoPath = null;
        if ($request->hasFile('service_photo')) {
            $photo = $request->file('service_photo');
            $photoName = time().'_'.Str::random(6).'.'.$photo->getClientOriginalExtension();
            $photo->move(public_path('uploads/salons/services'), $photoName);
            $photoPath = 'uploads/salons/services/'.$photoName;
        }

        // insert service
        $serviceId = DB::table('services')->insertGetId([
            'service_name'   => $request->service_name,
            'service_href'   => Str::random(16),
            'id_type'        => $request->service_type_id,
            'service_price'  => $request->service_price,
            'service_desc'   => $request->service_desc,
            'service_status' => 2,
            'service_photo'  => $photoPath,
            'id_salon'       => session('user')->salon_id,
            'id_added'       => session('user')->id,
            'date_added'     => now(),
        ]);

        // Save attributes
        // expected structure:
        // attributes[ATTRIBUTE_ID] = single value OR array (for multiple checkbox)
        $attrs = $request->input('attributes', []);
        $insertData = [];

        foreach ($attrs as $attributeId => $val) {
            // if val is array => multiple selected options (checkboxes)
            if (is_array($val)) {
                foreach ($val as $optionId) {
                    $insertData[] = [
                        'service_id'   => $serviceId,
                        'attribute_id' => $attributeId,
                        'option_id'    => $optionId,
                        'custom_value' => null,
                        'created_at'   => now(),
                        'updated_at'   => now(),
                    ];
                }
            } else {
                // single value: could be option id (radio) OR text/number input
                // Decide: check if attribute has options in DB. If it has options, treat as option_id, else treat as custom_value.
                $hasOption = DB::table('attribute_options')
                    ->where('attribute_id', $attributeId)
                    ->where('id', $val)
                    ->exists();

                if ($hasOption) {
                    $insertData[] = [
                        'service_id'   => $serviceId,
                        'attribute_id' => $attributeId,
                        'option_id'    => $val,
                        'custom_value' => null,
                        'created_at'   => now(),
                        'updated_at'   => now(),
                    ];
                } else {
                    // text/number -> save custom value
                    $insertData[] = [
                        'service_id'   => $serviceId,
                        'attribute_id' => $attributeId,
                        'option_id'    => null,
                        'custom_value' => $val,
                        'created_at'   => now(),
                        'updated_at'   => now(),
                    ];
                }
            }
        }

        if (!empty($insertData)) {
            DB::table('service_attributes')->insert($insertData);
        }

        return redirect('/services')->with('success', 'Service added successfully!');
    }

    // Edit salon service
    public function editService(Request $request, $id)
    {
        $request->validate([
            'service_name'  => 'required|string|max:255',
            'service_type_id'=> 'required|exists:service_types,id',
            'service_price' => 'nullable|numeric',
            'service_desc'  => 'nullable|string',
            'service_photo' => 'nullable|image|max:2048',
            'attributes'    => 'nullable|array',
        ]);
        
        $service = DB::table('services')->where('service_id', $id)->first();
        if (!$service) {
            return redirect()->back()->with('error', 'Service not found.');
        }

        $photoPath = $service->service_photo;
        if ($request->hasFile('service_photo')) {
            if ($photoPath && file_exists(public_path($photoPath))) {
                unlink(public_path($photoPath));
            }
            $photo = $request->file('service_photo');
            $photoName = time() . '_' . Str::random(6) . '.' . $photo->getClientOriginalExtension();
            $photo->move(public_path('uploads/salons/services'), $photoName);
            $photoPath = 'uploads/salons/services/' . $photoName;
        }

        DB::table('services')->where('service_id', $id)->update([
            'service_name'   => $request->service_name,
            'id_type'        => $request->service_type_id,
            'service_price'  => $request->service_price,
            'service_desc'   => $request->service_desc,
            'service_photo'  => $photoPath,
            'updated_at'     => now(),
        ]);
        
        // Delete old attributes and save new ones
        DB::table('service_attributes')->where('service_id', $id)->delete();
        
        $attrs = $request->input('attributes', []);
        $insertData = [];

        foreach ($attrs as $attributeId => $val) {
            if (is_array($val)) {
                foreach ($val as $optionId) {
                    $insertData[] = [
                        'service_id'   => $id,
                        'attribute_id' => $attributeId,
                        'option_id'    => $optionId,
                        'custom_value' => null,
                        'created_at'   => now(),
                        'updated_at'   => now(),
                    ];
                }
            } else {
                $hasOption = DB::table('attribute_options')
                    ->where('attribute_id', $attributeId)
                    ->where('id', $val)
                    ->exists();

                if ($hasOption) {
                    $insertData[] = [
                        'service_id'   => $id,
                        'attribute_id' => $attributeId,
                        'option_id'    => $val,
                        'custom_value' => null,
                        'created_at'   => now(),
                        'updated_at'   => now(),
                    ];
                } else {
                    $insertData[] = [
                        'service_id'   => $id,
                        'attribute_id' => $attributeId,
                        'option_id'    => null,
                        'custom_value' => $val,
                        'created_at'   => now(),
                        'updated_at'   => now(),
                    ];
                }
            }
        }
        
        if (!empty($insertData)) {
            DB::table('service_attributes')->insert($insertData);
        }

        session()->flash('success', 'Service updated successfully!');
        return redirect()->view('salon.services');
    }
    // public function editService(Request $request, $href)
    // {
    //     // Find the service by href
    //     $service = Service::where('service_href', $href)
    //                         ->where('id_salon', session('user')->salon_id)
    //                         ->firstOrFail();

    //     // Validate request data
    //     $request->validate([
    //         'service_name'   => 'required|string|max:255',
    //         'id_type'        => 'required|exists:service_types,id',
    //         'service_price'  => 'required|numeric|min:0',
    //         'service_desc'   => 'nullable|string',
    //         'service_photo'  => 'nullable|image|mimes:jpg,jpeg,png,svg|max:2048',
    //     ]);

    //     // Update service details
    //     $service->service_name   = $request->service_name;
    //     $service->id_type        = $request->id_type;
    //     $service->service_price  = $request->service_price;
    //     $service->service_desc   = $request->service_desc;

    //     // Handle image upload
    //     if ($request->hasFile('service_photo')) {
    //         // Delete old photo if exists
    //         if ($service->service_photo && file_exists(public_path($service->service_photo))) {
    //             unlink(public_path($service->service_photo));
    //         }

    //         // Upload new photo
    //         $photo = $request->file('service_photo');
    //         $photoName = time() . '_' . Str::random(10) . '.' . $photo->getClientOriginalExtension();
    //         $photoPath = 'uploads/salons/services/' . $photoName;

    //         // Move to public directory
    //         $photo->move(public_path('uploads/salons/services'), $photoName);

    //         // Update the service photo path
    //         $service->service_photo = $photoPath;
    //     }

    //     // Save the updated service
    //     $service->save();

    //     return redirect('/services')->with('success', 'Service updated successfully!');
    // }

    // Bookings
    public function bookings(){
        $salonId = session('user')->salon_id;

        $appointments = DB::table('appointments')
            ->join('services', 'appointments.id_service', '=', 'services.service_id')
            ->where('appointments.id_salon', $salonId)
            ->where('appointments.is_deleted', 0)
            ->orderByRaw("FIELD(appointments.status, 2, 1, 3)") // 2: Pending, 1: Accepted, 3: Rejected
            ->select(
                'appointments.*',
                'services.*',
            )
            ->paginate(10);

        return view('salon.bookings', compact('appointments'));
    }
    // public function updateStatus(Request $request, $href)
    // {
    //     $appointment = Appointment::where('href', $href)->firstOrFail();
    //     $appointment->status = $request->status;
    //     $appointment->save();

    //     try {
    //         if (!empty($appointment->client_email)) {
    //             Mail::to($appointment->client_email)->send(new AppointmentStatusUpdated($appointment));
    //         }
    //     } catch (\Exception $e) {
    //         Log::error('Mail Error: ' . $e->getMessage());
    //         return response()->json(['success' => false, 'message' => 'Email sending failed.']);
    //     }
    //     return response()->json([
    //         'success' => true,
    //     ]);
    // }

    public function updateStatus(Request $request, $href)
{
    Log::info('updateStatus called', ['href' => $href, 'status' => $request->status]);

    $appointment = Appointment::where('href', $href)->first();

    if (!$appointment) {
        Log::error('Appointment not found', ['href' => $href]);
        return response()->json(['success' => false, 'message' => 'Appointment not found']);
    }

    $appointment->status = $request->status;
    $appointment->save();

    try {
        if (!empty($appointment->client_email)) {
            Mail::to($appointment->client_email)->send(new AppointmentStatusUpdated($appointment));
            Log::info('Email sent', ['to' => $appointment->client_email]);
        }
    } catch (\Throwable $e) {
        Log::error('Email failed', ['error' => $e->getMessage()]);
        // Still return success because status was updated
        return response()->json([
            'success' => true,
            'message' => 'Status updated, but email failed: ' . $e->getMessage(),
        ]);
    }

    return response()->json([
        'success' => true,
        'message' => 'Status and email sent successfully.'
    ]);
}


    // Salon Signup
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
