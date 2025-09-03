<?php
use App\Models\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Message;

// CHECK EXISTANCE GLOBAL VAR
if (!function_exists('globalVar')) {
    function globalVar($key)
    {
        return config('globals.' . $key);
    }
}

// CLEANVARS
function cleanvars($str){ 
	$str = trim($str);
	return is_array($str) ? array_map('cleanvars', $str) : str_replace("\\", "\\\\", htmlspecialchars((stripslashes($str)), ENT_QUOTES)); 
}

// LASTEST ID
function lastId() {
    // Retrieve the last inserted ID using raw SQL
    $lastId = DB::select('SELECT LAST_INSERT_ID() as id')[0]->id;
    
    // Return the last inserted ID
    return $lastId;
}

// LOGIN TYPES
function get_logintypes($id = '') {
	$listlogintypes = array (
								   '1'	=> 'admin',
								   '2'	=> 'client',
								   '3'	=> 'salon'
							);
	if(!empty($id)){
		return $listlogintypes[$id];
	}else{
		return $listlogintypes;
	}
}

// ADMIN TYPES
function get_admtypes($id = '') {
	$listadmtypes = array (
								   '1'	=> 'Super Admin'
							);
	if(!empty($id)){
		return $listadmtypes[$id];
	}else{
		return $listadmtypes;
	}
}

// LOGFILE ACTION
function get_log_action($id = '') {
	$listlogaction = array (
							  '1' => 'Add'		 
							, '2' => 'Update'		 
							, '3' => 'Delete'		
							, '4' => 'Login'	
						 );
	if(!empty($id)){
		return $listlogaction[$id];
	}else{
		return $listlogaction;
	}
}

// SESSION MESSAGE
function sessionMsg($title = "", $msg = "", $type = "") {
	if (!empty($title) && !empty($msg)&& !empty($type)){
        session([
            'msg' => [
                'title' => $title,
                'text' => $msg,
                'type' => $type,
            ]
        ]);
        return true;
	} else {
		return false;
	}
}

// SEND REMARKS
function sendRemark($remarks = "", $action = "", $id_record = "") {
    // Validate the input
    if (!empty($remarks) && !empty($action) && !empty($id_record)) {

        // Retrieve the current logged-in user from session
        $user = session('user');
        
        // Check if the user is authenticated
        if (!$user) {
            return false; // User is not logged in
        }

        // Prepare the data to be logged
        $values = [
            'id_user'        => $user->id,  // Authenticated user's ID
			'urlpath'		 => Request::path(), // full url
            'action'         => cleanvars($action), // Clean and sanitize action
            'id_record'      => cleanvars($id_record), // Clean and sanitize record ID
            'dated'          => now(), // Current timestamp using Laravel's now() helper
            'ip'             => cleanvars(Request::ip()), // Get the IP address of the request
            'remarks'        => cleanvars($remarks), // Clean and sanitize remarks
        ];

        // Insert the log entry into the logs table
        $log = Log::create($values);

        // Return true if the log was created successfully, otherwise false
        return $log ? true : false;
    }

    // Return false if required parameters are missing
    return false;
}

// Get Status
function get_status($id) {
    $liststatus= array (
                            '1' => '<span class="badge bg-success p-2 rounded">Active</span>', 
                            '2' => '<span class="badge bg-danger p-2 rounded">Inactive</span>');
    return $liststatus[$id];
}
// Get Status
function get_service_status($id) {
    $liststatus= array (
                            '1' => '<span class="badge bg-success p-2 rounded">Approved</span>', 
                            '2' => '<span class="badge bg-warning p-2 rounded">Pending</span>',
                            '3' => '<span class="badge bg-danger p-2 rounded">Rejected</span>');
    return $liststatus[$id];
}

// Get Appointment Status
function get_booking_status($id) {
    $liststatus= array (
                            '1' => '<span class="badge bg-success p-2 rounded">Accepted</span>', 
                            '2' => '<span class="badge bg-warning p-2 rounded">Pending</span>',
                            '3' => '<span class="badge bg-danger p-2 rounded">Rejected</span>');
    return $liststatus[$id];
}

// SEND EMAIL (SIMPLE)
function sendEmail($recipientEmail, $subject, $htmlContent) {
    try {
        Mail::html($htmlContent, function (Message $message) use ($recipientEmail, $subject) {
            $message->to($recipientEmail);
            $message->subject($subject);
        });

        return true; // Email sent successfully
    } catch (\Exception $e) {
        // You can log the error for debugging
        // Log::error('Email sending failed: ' . $e->getMessage());
        return false; // Email sending failed
    }
}