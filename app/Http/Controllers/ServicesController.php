<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ServiceType;
use Illuminate\Support\Str;

class ServicesController extends Controller
{
    public function service_types($action = "list", $href = null)
{
    // Fetch service types (for listing)
    $serviceTypes = ServiceType::where('is_deleted', 0)->paginate(10);

    if ($action === "edit" && isset($href)) {
        // Fetch the specific service type
        $serviceType = ServiceType::where('href', $href)->where('is_deleted', 0)->firstOrFail();
        return view('admin.service_types', compact('action','href', 'serviceType', 'serviceTypes'));
    } 
    elseif ($action === "add") {
        return view('admin.service_types', compact('action', 'serviceTypes'));
    } 
    elseif ($action === "list" && !isset($href)){
        return view('admin.service_types', compact('action', 'serviceTypes'));
    }
}


    public function add_service_type(Request $request){
        // Validate request
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|integer|in:1,2',
            'description' => 'nullable|string',
            'icon' => 'nullable|image|mimes:jpg,jpeg,png,svg|max:2048', // Image validation
        ]);

        // Handle file upload
        if ($request->hasFile('icon')) {
            $icon = $request->file('icon');
            $timestamp = time();
            
            // Convert service type name to slug format to avoid invalid characters
            $serviceTypeName = Str::slug($request->name);
            $extension = $icon->getClientOriginalExtension();
            
            // Construct filename: service-type-name-timestamp.extension
            $iconName = "{$serviceTypeName}-{$timestamp}.{$extension}";
            $iconPath = 'uploads/admin/service_types/';
            
            // Move file to the target directory
            $icon->move(public_path($iconPath), $iconName);
            
            // Path to store in DB
            $iconUrl = $iconPath . $iconName;
        } else {
            $iconUrl = null;
        }

        // Get logged-in user ID from session
        $user = session('user');

        // Create Service Type
        ServiceType::create([
            'name' => $request->name,
            'href' => Str::slug($request->name, '-'),
            'status' => $request->status,
            'description' => $request->description,
            'icon' => $iconUrl,
            'id_added' => $user->id, // Storing logged-in user ID
            'date_added' => now(),
        ]);

        return redirect('/service-types')->with('success', 'Service Type added successfully!');
    }

    public function edit_service_type(Request $request, $href) {
        // Validate request
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|integer|in:1,2',
            'description' => 'nullable|string',
            'icon' => 'nullable|image|mimes:jpg,jpeg,png,svg|max:2048', // Image validation
        ]);
    
        // Find the service type
        $serviceType = ServiceType::where('href', $href)->where('is_deleted', 0)->firstOrFail();
    
        // Handle file upload if a new icon is provided
        if ($request->hasFile('icon')) {
            $icon = $request->file('icon');
            $timestamp = time();
            $serviceTypeName = Str::slug($request->name);
            $extension = $icon->getClientOriginalExtension();
            $iconName = "{$serviceTypeName}-{$timestamp}.{$extension}";
            $iconPath = 'uploads/admin/service_types/';
            $icon->move(public_path($iconPath), $iconName);
            $serviceType->icon = $iconPath . $iconName;
        }
    
        // Update service type details
        $serviceType->name = $request->name;
        $serviceType->href = Str::slug($request->name, '-');
        $serviceType->status = $request->status;
        $serviceType->description = $request->description;
        $serviceType->save();
    
        return redirect('/service-types')->with('success', 'Service Type updated successfully!');
    }
}
