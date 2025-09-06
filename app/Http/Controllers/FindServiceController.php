<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FindServiceController extends Controller
{
    public function showSearchForm()
    {
        // Get all service types
        $serviceTypes = DB::table('service_types')->get();

        // Get all attributes and their options, grouped by service type
        $attributes = DB::table('attributes')
            ->join('attribute_options', 'attributes.id', '=', 'attribute_options.attribute_id')
            ->select('attributes.id as attribute_id', 'attributes.label', 'attributes.input_type', 'attributes.service_type_id', 'attribute_options.id as option_id', 'attribute_options.value')
            ->orderBy('attributes.service_type_id')
            ->get()
            ->groupBy('service_type_id');
        
        return view('find-service', compact('serviceTypes', 'attributes'));
    }

    /**
     * Handle the service search query.
     */
    public function searchServices(Request $request)
    {
        $query = DB::table('services')
            ->select('services.*', 'salons.salon_name as salon_name')
            ->join('salons', 'services.id_salon', '=', 'salons.salon_id')
            ->distinct();

        // Filter by Service Type   
        if ($request->filled('service_type_id')) {
            $query->where('services.id_type', $request->service_type_id);
        }

        // Filter by Dynamic Attributes
        if ($request->filled('attribute_options')) {
            $attributeOptions = $request->input('attribute_options');
            
            $query->join('service_attributes', 'services.service_id', '=', 'service_attributes.service_id');
            $query->whereIn('service_attributes.option_id', $attributeOptions);
        }

        // Filter by Price Range
        if ($request->filled('min_price')) {
            $query->where('services.service_price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('services.service_price', '<=', $request->max_price);
        }
        
        $searchResults = $query->get();
        // Get all service types
        $serviceTypes = DB::table('service_types')->get();

        // Get all attributes and their options, grouped by service type
        $attributes = DB::table('attributes')
            ->join('attribute_options', 'attributes.id', '=', 'attribute_options.attribute_id')
            ->select('attributes.id as attribute_id', 'attributes.label', 'attributes.input_type', 'attributes.service_type_id', 'attribute_options.id as option_id', 'attribute_options.value')
            ->orderBy('attributes.service_type_id')
            ->get()
            ->groupBy('service_type_id');
        
        return view('find-service', ['services' => $searchResults, 'serviceTypes' => $serviceTypes, 'attributes' => $attributes]);
    }
}
