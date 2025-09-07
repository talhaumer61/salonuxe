<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class JobsController extends Controller
{
    public function jobs($action = "list", $href = null)
    {
        $salon = DB::table('salons')
            ->where('id_user', session('user')->id)
            ->where('salon_status', 1)
            ->where('is_deleted', 0)
            ->first();

        if (!$salon) {
            return view('salon.jobs', compact('salon'));
        }

        // Add Job
        if ($action === "add") {
            return view('salon.jobs', compact('action', 'salon'));
        }

        // Edit Job
        if ($action === "edit" && isset($href)) {
            $job = DB::table('salon_jobs')
                ->where('job_href', $href)
                ->where('is_deleted', 0)
                ->where('id_salon', $salon->salon_id)
                ->first();

            if (!$job) {
                return redirect()->route('salon.jobs', ['action' => 'list'])
                    ->with('error', 'Job not found or you do not have permission to edit it.');
            }

            return view('salon.jobs', compact('action', 'job', 'salon', 'href'));
        }

        // Applications list
        if ($action === "applications" && isset($href)) {
            $job = DB::table('salon_jobs')
                ->where('job_href', $href)
                ->where('id_salon', $salon->salon_id)
                ->first();

            if (!$job) {
                return redirect()->route('salon.jobs', ['action' => 'list'])
                    ->with('error', 'Job not found or you do not have permission to view applications.');
            }

            $applications = DB::table('job_applications')
                ->where('job_id', $job->job_id)
                ->orderBy('created_at', 'desc')
                ->paginate(10);

            return view('salon.jobs', compact('action', 'salon', 'job', 'applications', 'href'));
        }

        // Jobs list
        $jobs = DB::table('salon_jobs')
            ->where('is_deleted', 0)
            ->where('id_salon', $salon->salon_id)
            ->paginate(10);

        return view('salon.jobs', compact('action', 'jobs', 'salon'));
    }


    // Add salon job
    public function addJob(Request $request)
    {
        $request->validate([
            'job_title'  => 'required|string|max:255',
            'job_desc'   => 'nullable|string',
            'job_file'   => 'nullable|file|max:4096', // 4MB
        ]);

        // handle file upload
        $filePath = null;
        if ($request->hasFile('job_file')) {
            $file = $request->file('job_file');
            $fileName = time().'_'.Str::random(6).'.'.$file->getClientOriginalExtension();
            $file->move(public_path('uploads/salons/jobs'), $fileName);
            $filePath = 'uploads/salons/jobs/'.$fileName;
        }

        // insert into salon_jobs
        DB::table('salon_jobs')->insert([
            'job_title'   => $request->job_title,
            'job_href'    => Str::random(16),
            'job_desc'    => $request->job_desc,
            'job_file'    => $filePath,
            'job_status'  => 1, // Open by default
            'id_salon'    => session('user')->salon_id,
            'id_added'    => session('user')->id,
            'date_added'  => now(),
        ]);

        sessionMsg('success', 'Job added successfully!', 'success');
        return redirect('/jobs');
    }


    // Edit salon job
    public function editJob(Request $request, $id)
    {
        $request->validate([
            'job_title' => 'required|string|max:255',
            'job_desc'  => 'nullable|string',
            'job_status'=> 'required|in:1,2',
            'job_file'  => 'nullable|file|max:5120', // allow 5MB
        ]);

        $job = DB::table('salon_jobs')->where('job_id', $id)->first();
        if (!$job) {
            return redirect()->back()->with('error', 'Job not found.');
        }

        // Handle file
        $filePath = $job->job_file;
        if ($request->hasFile('job_file')) {
            if ($filePath && file_exists(public_path($filePath))) {
                unlink(public_path($filePath));
            }
            $file = $request->file('job_file');
            $fileName = time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/salons/jobs'), $fileName);
            $filePath = 'uploads/salons/jobs/' . $fileName;
        }

        DB::table('salon_jobs')->where('job_id', $id)->update([
            'job_title'  => $request->job_title,
            'job_desc'   => $request->job_desc,
            'job_status' => $request->job_status,
            'job_file'   => $filePath,
            'date_modify' => now(),
        ]);

        sessionMsg('success', 'Job updated successfully!', 'success');
        return redirect()->route('salon.jobs', 'list');
    }


    public function applyJob(Request $request)
    {
        $request->validate([
            'job_id' => 'required|exists:salon_jobs,job_id',
            'applicant_name' => 'required|string|max:255',
            'applicant_email' => 'required|email',
            'applicant_phone' => 'nullable|string|max:20',
            'cover_letter' => 'nullable|string',
            'resume' => 'nullable|file',
        ]);

        $filePath = null;
        if ($request->hasFile('resume')) {
            $file = $request->file('resume');
            $fileName = time().'_'.Str::random(6).'.'.$file->getClientOriginalExtension();
            $file->move(public_path('uploads/salons/job_applications'), $fileName);
            $filePath = 'uploads/salons/job_applications/'.$fileName;
        }

        // Insert into DB
        $applicationId = DB::table('job_applications')->insertGetId([
            'job_id' => $request->job_id,
            'applicant_name' => $request->applicant_name,
            'applicant_email' => $request->applicant_email,
            'applicant_phone' => $request->applicant_phone,
            'cover_letter' => $request->cover_letter,
            'resume' => $filePath,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Fetch job info for email
        $job = DB::table('salon_jobs')
            ->where('job_id', $request->job_id)
            ->select('job_title')
            ->first();

        if ($job) {
            // Email Logic
            $email = $request->applicant_email;
            $name = $request->applicant_name;

            $subject = "Application Received for {$job->job_title}";
            $content = "<h1>Hi, {$name}!</h1>
                        <p>Thank you for applying to <strong>{$job->job_title}</strong>.</p>
                        <p>We’ve received your application and our team will review it shortly.</p>
                        <p>Best regards,<br>Salonuxe Team</p>";

            sendEmail($email, $subject, $content);
        }

        sessionMsg('Success', 'Your application has been submitted successfully! A confirmation email has been sent.', 'success');
        return back();
    }

    public function respond(Request $request)
    {
        $request->validate([
            'application_id' => 'required|exists:job_applications,id',
            'response' => 'required|string',
        ]);

        // Get the application (with job info for email)
        $application = DB::table('job_applications')
            ->join('salon_jobs', 'job_applications.job_id', '=', 'salon_jobs.job_id')
            ->select(
                'job_applications.*',
                'salon_jobs.job_title'
            )
            ->where('job_applications.id', $request->application_id)
            ->first();

        if (!$application) {
            return redirect()->back()->with('error', 'Application not found.');
        }

        // Save response in DB
        DB::table('job_applications')
            ->where('id', $request->application_id)
            ->update(['response' => $request->response]);

        // Email Logic
        $email = $application->applicant_email;
        $name = $application->applicant_name;

        $subject = "Response to your Job Application";
        $content = "<h1>Hi, {$name}!</h1>
                    <p>Thank you for applying to <strong>{$application->job_title}</strong>.</p>
                    <p>Our response:</p>
                    <p>{$request->response}</p>";

        $wasSent = sendEmail($email, $subject, $content);

        if ($wasSent) {
            sessionMsg('Success','Response saved & email sent to applicant!','success');
            return redirect()->back();
        } else {
            sessionMsg('Error','Response saved but email could not be sent.','danger');
            return redirect()->back();
        }
    }


}
