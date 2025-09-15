<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SalonQueryController extends Controller
{
    // Owner dashboard: list queries for this salon
    public function ownerIndex()
    {
        $userId = session('user')->id ?? null;
        if (!$userId) return redirect('/login');

        $salon = DB::table('salons')->where('id_user', $userId)->where('is_deleted', 0)->first();
        if (!$salon) {
            session()->flash('error', 'Complete salon profile to view queries.');
            return back();
        }

        $queries = DB::table('salon_queries')
            ->join('users', 'salon_queries.user_id', '=', 'users.id')
            ->leftJoin('salon_jobs', 'salon_queries.job_id', '=', 'salon_jobs.job_id')
            ->select('salon_queries.*', 'users.name as user_name', 'users.email as user_email', 'salon_jobs.job_title')
            ->where('salon_queries.salon_id', $salon->salon_id)
            ->orderByDesc('salon_queries.updated_at')
            ->paginate(12);

        // attach messages for each query
        foreach ($queries as $q) {
            $q->messages = DB::table('salon_query_messages')
                ->where('query_id', $q->id)
                ->orderBy('created_at')
                ->get();
        }

        return view('salon.queries', compact('queries', 'salon'));
    }

    // Owner reply to a query (adds a message, marks replied, optional email to user)
    public function reply(Request $request, $id)
    {
        $userId = session('user')->id ?? null;
        if (!$userId) return redirect('/login');

        $request->validate([
            'message' => 'required|string|max:2000',
        ]);

        // Ensure this query belongs to a salon that this owner owns
        $salon = DB::table('salons')->where('id_user', $userId)->where('is_deleted', 0)->first();
        if (!$salon) {
            session()->flash('error', 'You must complete salon profile.');
            return back();
        }

        $query = DB::table('salon_queries')
            ->where('id', $id)
            ->where('salon_id', $salon->salon_id)
            ->first();

        if (!$query) {
            session()->flash('error', 'Query not found or permission denied.');
            return back();
        }

        // Insert owner message
        DB::table('salon_query_messages')->insert([
            'query_id'    => $id,
            'sender_type' => 'salon',
            'sender_id'   => $userId,
            'message'     => $request->message,
            'created_at'  => now(),
        ]);

        // mark replied
        DB::table('salon_queries')->where('id', $id)->update([
            'is_replied' => true,
            'status'     => 'open',
            'updated_at' => now(),
        ]);

        // Optional: send email to user notifying of reply
        $user = DB::table('users')->where('id', $query->user_id)->first();
        $salonInfo = DB::table('salons')->where('salon_id', $salon->salon_id)->select('salon_name')->first();

        if ($user && function_exists('sendEmail')) {
            $subject = "Response from " . ($salonInfo->salon_name ?? 'Salon');
            $content = "<h1>Hi {$user->name}</h1>
                        <p>You asked:</p>
                        <blockquote>{$this->escapeHtml($query->subject ?? '')} {$this->escapeHtml($query->question ?? '')}</blockquote>
                        <p><strong>Our reply:</strong></p>
                        <p>{$request->message}</p>";

            // sendEmail helper should return true/false
            @sendEmail($user->email, $subject, $content);
        }

        session()->flash('success', 'Reply sent.');
        return back();
    }

    // helper to escape (minimal)
    private function escapeHtml($s) {
        return e($s);
    }
}
