<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Appointment;
use Stripe\Webhook;

class StripeWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $secret = config('stripe.webhook_secret');

        try {
            $event = Webhook::constructEvent($payload, $sigHeader, $secret);
        } catch (\Exception $e) {
            Log::error('Stripe webhook error', ['error' => $e->getMessage()]);
            return response('Invalid signature', 400);
        }

        if ($event->type === 'checkout.session.completed') {
            $session = $event->data->object;
            $href = $session->metadata->appointment_href ?? null;

            if ($href) {
                $appointment = Appointment::where('href', $href)->first();
                if ($appointment) {
                    $appointment->advance_paid = $appointment->advance_amount;
                    $appointment->stripe_payment_intent_id = $session->payment_intent;
                    $appointment->status = 'advance_paid';
                    $appointment->save();

                    Log::info('Appointment advance successfully paid', ['href' => $href]);
                }
            }
        }

        return response('Webhook handled', 200);
    }
}
