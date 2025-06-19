<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class DatabaseController extends Controller
{
    public function deleteRecord(Request $request)
    {
        dd($request);
        $request->validate([
            'table' => 'required|string',
            'id' => 'required|integer',
            'column' => 'required|string',
        ]);

        $table = $request->input('table');
        $id = $request->input('id');
        $column = $request->input('column');

        // Check if record exists
        $record = DB::table($table)->where($column, $id)->first();
        if (!$record) {
            return response()->json(['status' => 'error', 'message' => 'Record not found'], 404);
        }

        // Get logged-in user ID from session
        $user = session('user');  
        $userId = is_array($user) ? $user['id'] : $user->id; 
        // Soft delete (Mark as deleted)
        DB::table($table)->where($column, $id)->update([
            'is_deleted' => 1,
            'id_deleted' => $userId,
            'ip_deleted' => request()->ip(),
            'date_deleted' => now(),
        ]);

        return response()->json(['status' => 'success', 'message' => 'Record successfully deleted']);
    }
}
