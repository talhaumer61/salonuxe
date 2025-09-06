<?php

namespace App\Http\Controllers;

use App\Models\ServiceType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AttributesController extends Controller
{
    // public function index($action = "list", $href = null)
    // {
    //     $serviceTypes = ServiceType::where('is_deleted', 0)->paginate(10);
    //     // Placeholder for future implementation
    //     return view('admin.service_type_attributes', compact('action', 'href', 'serviceTypes'));
    // }
    public function index($action = "list", $href = null)
    {
        if ($action == "list") {
            // Fetch attributes along with their service type name
            $attributes = DB::table('attributes')
                ->join('service_types', 'attributes.service_type_id', '=', 'service_types.id')
                ->select('attributes.*', 'service_types.name as service_type_name')
                ->orderBy('attributes.id', 'desc')
                ->paginate(10);

            // Fetch all attribute options and group them by attribute_id
            $attributeOptions = DB::table('attribute_options')
                ->get()
                ->groupBy('attribute_id');

            // Pass both collections to the list view
            return view('admin.service_type_attributes', compact('action', 'href', 'attributes', 'attributeOptions'));
        }

        if ($action == "add") {
            // Fetch service types for the add form
            $serviceTypes = DB::table('service_types')->where('is_deleted', 0)->get();
            return view('admin.service_type_attributes', compact('action', 'serviceTypes'));
        }

        // Placeholder for edit action
        if ($action == "edit" && $href !== null) {
            // Fetch the attribute details using the provided href (or ID)
            $attribute = DB::table('attributes')
                ->where('id', $href) // Assuming href is the attribute ID
                ->first();

            // If the attribute doesn't exist, redirect back with an error
            if (!$attribute) {
                return redirect()->route('service_type_attributes.list')->with('error', 'Attribute not found.');
            }

            // Fetch all service types for the dropdown
            $serviceTypes = DB::table('service_types')->where('is_deleted', 0)->get();

            // Fetch all options for the specific attribute
            $options = DB::table('attribute_options')
                ->where('attribute_id', $attribute->id)
                ->get();

            return view('admin.service_type_attributes', compact('action', 'attribute', 'serviceTypes', 'options'));
        }


        return view('admin.service_type_attributes', compact('action', 'href'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'service_type_id' => 'required|exists:service_types,id',
            'label'           => 'required|string|max:255',
            'key'             => 'required|string|max:255|unique:attributes,key',
            'input_type'      => 'required|string|in:text,number,select,multiselect,radio,checkbox',
            'is_required'     => 'nullable|boolean',
            'options'         => 'nullable|array',
            'options.*'       => 'nullable|string',
        ]);

        // Save attribute
        $attributeId = DB::table('attributes')->insertGetId([
            'service_type_id' => $request->service_type_id,
            'label'           => $request->label,
            'key'             => Str::slug($request->key, '_'),
            'input_type'      => $request->input_type,
            'is_required'     => $request->has('is_required'),
            'created_at'      => now(),
            'updated_at'      => now(),
        ]);

        // Save options if applicable
        if (in_array($request->input_type, ['select','multiselect','radio','checkbox']) && $request->options) {
            $optionsData = [];
            foreach ($request->options as $option) {
                if (!empty($option)) {
                    $optionsData[] = [
                        'attribute_id' => $attributeId,
                        'value'        => $option,
                        'created_at'   => now(),
                        'updated_at'   => now(),
                    ];
                }
            }

            if (!empty($optionsData)) {
                DB::table('attribute_options')->insert($optionsData);
            }
        }

        sessionMsg('Success', 'Attribute added successfully!', 'success');
        return redirect()->route('service_type_attributes', 'list');
    }

    public function update(Request $request, $id)
    {
        // 1. Validate the request data
        $request->validate([
            'service_type_id' => 'required|exists:service_types,id',
            'label'           => 'required|string|max:255',
            // 'key' should be unique except for the current attribute
            'key'             => 'required|string|max:255|unique:attributes,key,' . $id,
            'input_type'      => 'required|string|in:text,number,select,multiselect,radio,checkbox',
            'is_required'     => 'nullable|boolean',
            'options'         => 'nullable|array',
            'options.*'       => 'nullable|string',
        ]);

        // 2. Update the main attribute record
        DB::table('attributes')
            ->where('id', $id)
            ->update([
                'service_type_id' => $request->service_type_id,
                'label'           => $request->label,
                'key'             => Str::slug($request->key, '_'),
                'input_type'      => $request->input_type,
                'is_required'     => $request->has('is_required'),
                'updated_at'      => now(),
            ]);

        // 3. Handle attribute options
        $optionsData = [];
        $newOptions = $request->options;
        $existingOptions = DB::table('attribute_options')->where('attribute_id', $id)->get();

        // Check if options are applicable for the input type
        if (in_array($request->input_type, ['select', 'multiselect', 'radio', 'checkbox']) && $newOptions) {

            $existingValues = $existingOptions->pluck('value')->toArray();
            $newValues = array_filter($newOptions); // Remove empty values

            // Delete options that are no longer in the new submission
            DB::table('attribute_options')
                ->where('attribute_id', $id)
                ->whereNotIn('value', $newValues)
                ->delete();

            // Insert new options that don't already exist
            foreach ($newValues as $value) {
                if (!in_array($value, $existingValues)) {
                    $optionsData[] = [
                        'attribute_id' => $id,
                        'value'        => $value,
                        'created_at'   => now(),
                        'updated_at'   => now(),
                    ];
                }
            }
            if (!empty($optionsData)) {
                DB::table('attribute_options')->insert($optionsData);
            }
            
        } else {
            // If input type doesn't have options, delete all existing options for this attribute
            DB::table('attribute_options')->where('attribute_id', $id)->delete();
        }

        sessionMsg('success', 'Attribute updated successfully!', 'success');
        return redirect()->route('service_type_attributes', ['action' => 'list']);
    }
}
