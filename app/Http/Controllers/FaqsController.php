<?php

namespace App\Http\Controllers;

use App\Models\ServiceType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class FaqsController extends Controller
{
    public function faqs($action = "list", $id = null)
    {
        // Fetch FAQs (not soft-deleted)
        $faqs = DB::table('faqs')->where('is_deleted', 0)->orderByDesc('id')->paginate(10);

        if ($action === "edit" && isset($id)) {
            $faq = DB::table('faqs')->where('id', $id)->where('is_deleted', 0)->firstOrFail();
            return view('admin.faqs', compact('action', 'id', 'faq', 'faqs'));
        } 
        elseif ($action === "add") {
            return view('admin.faqs', compact('action', 'faqs'));
        } 
        elseif ($action === "list" && !isset($id)){
            return view('admin.faqs', compact('action', 'faqs'));
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
            'status' => 'required|in:1,2',
        ]);

        DB::table('faqs')->insert([
            'question'     => $request->question,
            'answer'       => $request->answer,
            'status'       => $request->status,
            'id_added'     => session('user')->id, // optional, if using login
            'date_added'   => now(),
            'is_deleted'   => false,
        ]);

        return redirect('/faqs')->with('success', 'FAQ added successfully.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'question' => 'required|string',
            'answer' => 'required|string',
            'status' => 'required|in:1,2',
        ]);

        DB::table('faqs')->where('id', $id)->update([
            'question'     => $request->question,
            'answer'       => $request->answer,
            'status'       => $request->status,
            'date_modify'  => now(),
            'id_modify'    => session('user')->id ?? null,
        ]);

        return redirect()->route('faqs.index')->with('success', 'FAQ updated successfully.');
    }

}
