<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use Illuminate\Support\Facades\DB;
use Stripe\Stripe;
use Stripe\Transfer;
use Stripe\Checkout\Session;

class PaymentController extends Controller
{
    public function createCheckoutSession(Request $request, $href)
    {
        $appointment = Appointment::where('href', $href)->firstOrFail();

        // Ensure this appointment is accepted and ready for advance payment
        if ($appointment->status !== 1 || !$appointment->advance_amount) {
            return redirect()->back()->with('error', 'Appointment not ready for payment.');
        }

        Stripe::setApiKey(config('stripe.secret'));

        // ✅ Amount in PKR (Stripe uses smallest currency unit = paisa)
        $amountInPaisa = intval($appointment->advance_amount * 100);

        // ✅ Create Stripe Checkout Session
        $session = Session::create([
            'payment_method_types' => ['card'],
            'mode' => 'payment',
            'line_items' => [[
                'price_data' => [
                    'currency' => 'pkr', // Show as PKR in test mode
                    'product_data' => [
                        'name' => 'Advance Payment for Salon Booking #' . $appointment->id,
                    ],
                    'unit_amount' => $amountInPaisa, // PKR in paisa
                ],
                'quantity' => 1,
            ]],
            'metadata' => [
                'appointment_href' => $appointment->href,
            ],
            'success_url' => route('payment.success', ['session_id' => '{CHECKOUT_SESSION_ID}']),
            'cancel_url' => route('payment.cancel'),
        ]);

        // ✅ Save session ID + mark as confirmed + record advance paid
        $appointment->stripe_session_id = $session->id;
        $appointment->advance_paid = $appointment->advance_amount;
        $appointment->status = 4; // 4 = Confirmed
        $appointment->save();

        return redirect($session->url);
    }

    public function success(Request $request)
    {
        // Optional: You can verify the session if needed
        $sessionId = $request->query('session_id');

        if ($sessionId) {
            $appointment = Appointment::where('stripe_session_id', $sessionId)->first();
            if ($appointment) {
                $appointment->status = 4; // Confirmed
                $appointment->advance_paid = $appointment->advance_amount;
                $appointment->save();
            }
        }

        sessionMsg('success', 'Payment successful! Your booking has been confirmed.', 'success');
        return redirect()->route('client.bookings');
    }

    public function cancel()
    {
        sessionMsg('danger', 'Payment was cancelled. Please try again.', 'danger');
        return redirect()->route('client.bookings')->with('error', 'Payment was cancelled. Please try again.');
    }

    public function markCompleted(Request $request, $appointmentId)
{
    // Fetch appointment
    $appointment = DB::table('appointments')->where('id', $appointmentId)->first();

    if (!$appointment) {
        return back()->with('error', 'Appointment not found.');
    }

    $user = session('user');

    // Update completion flag based on role
    if ($user->login_type === 3) { // Salon
        DB::table('appointments')
            ->where('id', $appointmentId)
            ->update(['salon_completed' => true]);
    } elseif ($user->login_type === 2) { // Client
        DB::table('appointments')
            ->where('id', $appointmentId)
            ->update(['client_completed' => true]);
    }

    // Re-fetch latest
    $appointment = DB::table('appointments')->where('id', $appointmentId)->first();

    // If both have marked completed, release funds
    if ($appointment->salon_completed && $appointment->client_completed) {
        $this->releaseFunds($appointment);
    }

    sessionMsg('success', 'Marked as completed successfully.', 'success');
    return back()->with('success', 'Marked as completed successfully.');
}

public function releaseFunds($appointment)
{
    // Prevent duplicate payout
    $existingPayout = DB::table('payouts')
        ->where('appointment_id', $appointment->id)
        ->exists();

    if ($existingPayout) {
        return;
    }

    // Fetch related salon
    $salon = DB::table('salons')->where('salon_id', $appointment->id_salon)->first();
    if (!$salon) {
        sessionMsg('danger', 'Salon not found for payout.', 'danger');
        return;
    }

    // Commission calculation
    $amountPKR = $appointment->total_amount;
    $commissionPercent = 10;
    $commissionPKR = ($amountPKR * $commissionPercent) / 100;
    $netAmountPKR = $amountPKR - $commissionPKR;

    /**
     * ⚙ Convert PKR to USD for Stripe (test mode)
     * Use a static approximate rate for demo, e.g. 1 USD = 280 PKR
     */
    $usdRate = 280; // static demo conversion rate
    $netAmountUSD = $netAmountPKR / $usdRate;

    // Stripe amount in cents
    $transferAmount = intval($netAmountUSD * 100);

    \Stripe\Stripe::setApiKey(config('stripe.secret'));

    try {
        // Perform the transfer (using USD for test mode)
        $transfer = \Stripe\Transfer::create([
            'amount' => $transferAmount,
            'currency' => 'usd', // must be supported by your Stripe test account
            'destination' => $salon->stripe_account_id,
            'transfer_group' => 'appointment_' . $appointment->id,
        ]);

        // Log payout in PKR
        DB::table('payouts')->insert([
            'appointment_id' => $appointment->id,
            'salon_id' => $salon->salon_id,
            'amount' => $amountPKR,
            'commission' => $commissionPKR,
            'net_amount' => $netAmountPKR,
            'stripe_transfer_id' => $transfer->id,
            'status' => 'completed',
            'message' => 'Released in USD (test mode)',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        sessionMsg('success', 'Funds successfully released to salon.', 'success');

    } catch (\Exception $e) {
        DB::table('payouts')->insert([
            'appointment_id' => $appointment->id,
            'salon_id' => $salon->salon_id,
            'amount' => $amountPKR,
            'commission' => $commissionPKR,
            'net_amount' => $netAmountPKR,
            'status' => 'failed',
            'message' => $e->getMessage(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        sessionMsg('danger', 'Payout failed: ' . $e->getMessage(), 'danger');
    }
}

    // public function markCompleted(Request $request, $appointmentId)
    // {
    //     // Fetch appointment via Query Builder
    //     $appointment = DB::table('appointments')->where('id', $appointmentId)->first();

    //     if (!$appointment) {
    //         return back()->with('error', 'Appointment not found.');
    //     }

    //     $user =session('user');

    //     // Update completion flags based on role
    //     if ($user->login_type === 3) {
    //         DB::table('appointments')->where('id', $appointmentId)->update([
    //             'salon_completed' => true,
    //         ]);
    //         $appointment->salon_completed = true;
    //     } elseif ($user->login_type === 2) {
    //         DB::table('appointments')->where('id', $appointmentId)->update([
    //             'client_completed' => true,
    //         ]);
    //         $appointment->client_completed = true;
    //     }

    //     // ✅ Re-fetch updated appointment after update
    //     $appointment = DB::table('appointments')->where('id', $appointmentId)->first();
    //     // If both have marked completed, release funds
    //     if ($appointment->salon_completed && $appointment->client_completed) {
    //         $this->releaseFunds($appointment);
    //     }

    //     sessionMsg('success', 'Marked as completed successfully.', 'success');
    //     return back()->with('success', 'Marked as completed successfully.');
    // }

    // public function releaseFunds($appointment)
    // {
    //     // Prevent duplicate payout
    //     $existingPayout = DB::table('payouts')
    //         ->where('appointment_id', $appointment->id)
    //         ->exists();

    //     if ($existingPayout) {
    //         return;
    //     }

    //     // Fetch related salon
    //     $salon = DB::table('salons')->where('salon_id', $appointment->id_salon)->first();
    //     if (!$salon) {
    //         sessionMsg('danger', 'Salon not found for payout.', 'danger');
    //         return;
    //     }

    //     // Calculate payout (in PKR)
    //     $amount = $appointment->total_amount; // PKR
    //     $commissionPercent = 10; // Example
    //     $commission = ($amount * $commissionPercent) / 100;
    //     $netAmount = $amount - $commission;

    //     // Convert PKR to smallest unit (paisa)
    //     $transferAmount = intval($netAmount * 100); // Stripe works in smallest units

    //     Stripe::setApiKey(config('stripe.secret'));

    //     try {
    //         // Perform Stripe transfer (for test/simulation)
    //         $transfer = Transfer::create([
    //             'amount' => $transferAmount,
    //             'currency' => 'pkr', // using PKR for test mode
    //             'destination' => $salon->stripe_account_id,
    //             'transfer_group' => 'appointment_' . $appointment->id,
    //         ]);

    //         // Record successful payout
    //         DB::table('payouts')->insert([
    //             'appointment_id' => $appointment->id,
    //             'salon_id' => $salon->salon_id,
    //             'amount' => $amount,
    //             'commission' => $commission,
    //             'net_amount' => $netAmount,
    //             'stripe_transfer_id' => $transfer->id,
    //             'status' => 'completed',
    //             'created_at' => now(),
    //             'updated_at' => now(),
    //         ]);

    //         sessionMsg('success', 'Payout successfully released to salon.', 'success');

    //     } catch (\Exception $e) {
    //         // Record failed payout
    //         DB::table('payouts')->insert([
    //             'appointment_id' => $appointment->id,
    //             'salon_id' => $salon->salon_id,
    //             'amount' => $amount,
    //             'commission' => $commission,
    //             'net_amount' => $netAmount,
    //             'status' => 'failed',
    //             'created_at' => now(),
    //             'updated_at' => now(),
    //         ]);

    //         sessionMsg('danger', 'Payout failed: ' . $e->getMessage(), 'danger');
    //     }
    // }

}
