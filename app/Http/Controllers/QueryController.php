<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QueryController extends Controller
{
    // Show logged-in user's queries (My Queries page)
    public function myQueries()
    {
        $userId = session('user')->id ?? null;
        if (!$userId) {
            return redirect('/login'); // or however you handle unauthenticated users
        }

        // fetch user's queries with salon name and optional job title
        $queries = DB::table('salon_queries')
            ->leftJoin('salons', 'salon_queries.salon_id', '=', 'salons.salon_id')
            ->leftJoin('salon_jobs', 'salon_queries.job_id', '=', 'salon_jobs.job_id')
            ->select(
                'salon_queries.*',
                'salons.salon_name',
                'salon_jobs.job_title'
            )
            ->where('salon_queries.user_id', $userId)
            ->orderByDesc('salon_queries.updated_at')
            ->get();

        // attach messages for each query (thread)
        foreach ($queries as $q) {
            $q->messages = DB::table('salon_query_messages')
                ->where('query_id', $q->id)
                ->orderBy('created_at')
                ->get();
        }

        // Also pass salons list for "Start New Query" modal (optional)
        $salons = DB::table('salons')
            ->where('is_deleted', 0)
            ->where('salon_status', 1)
            ->select('salon_id', 'salon_name')
            ->orderBy('salon_name')
            ->get();

        return view('client.queries', compact('queries', 'salons'));
    }

    // Start a new query (first message)
    public function store(Request $request)
    {
        $userId = session('user')->id ?? null;
        if (!$userId) return redirect('/login');

        $request->validate([
            'salon_id' => 'required|exists:salons,salon_id',
            'job_id'   => 'nullable|exists:salon_jobs,job_id',
            'subject'  => 'nullable|string|max:255',
            'message'  => 'required|string|max:2000',
        ]);

        $queryId = DB::table('salon_queries')->insertGetId([
            'job_id'     => $request->job_id,
            'salon_id'   => $request->salon_id,
            'user_id'    => $userId,
            'subject'    => $request->subject,
            'status'     => 'open',
            'is_replied' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('salon_query_messages')->insert([
            'query_id'    => $queryId,
            'sender_type' => 'user',
            'sender_id'   => $userId,
            'message'     => $request->message,
            'created_at'  => now(),
        ]);

        // Optional: notify salon owner (email or internal notification)

        session()->flash('success', 'Your question has been submitted.');
        return back();
    }

    // Add a message to existing query (user continues thread)
    public function sendMessage(Request $request, $id)
    {
        $userId = session('user')->id ?? null;
        if (!$userId) return redirect('/login');

        $request->validate([
            'message' => 'required|string|max:2000',
        ]);

        // Ensure query belongs to this user (security)
        $query = DB::table('salon_queries')->where('id', $id)->where('user_id', $userId)->first();
        if (!$query) {
            session()->flash('error', 'Query not found or permission denied.');
            return back();
        }

        DB::table('salon_query_messages')->insert([
            'query_id'    => $id,
            'sender_type' => 'user',
            'sender_id'   => $userId,
            'message'     => $request->message,
            'created_at'  => now(),
        ]);

        // update query updated_at and clear is_replied
        DB::table('salon_queries')->where('id', $id)->update([
            'updated_at' => now(),
            'is_replied' => false,
            'status'     => 'open',
        ]);

        session()->flash('success', 'Message sent.');
        return back();
    }

    public function salonThread($salonId)
    {
        $userId = session('user')->id ?? null;
        if (!$userId) return redirect('/login');

        // Find existing query between this user & salon
        $query = DB::table('salon_queries')
            ->where('user_id', $userId)
            ->where('salon_id', $salonId)
            ->first();

        $messages = [];
        if ($query) {
            $messages = DB::table('salon_query_messages')
                ->where('query_id', $query->id)
                ->orderBy('created_at', 'asc')
                ->get();
        }

        // Also fetch salon name
        $salon = DB::table('salons')->where('salon_id', $salonId)->first();

        return view('include.salons', compact('query', 'messages', 'salon'));
    }

}
