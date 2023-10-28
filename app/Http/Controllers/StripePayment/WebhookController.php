<?php

namespace App\Http\Controllers\StripePayment;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WebhookController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        // This is your Stripe CLI webhook secret for testing your endpoint locally.
        $endpoint_secret = env('STRIPE_WEBHOOK_SECRET');

        $payload = @file_get_contents('php://input');
        $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
        $event = null;

        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload,
                $sig_header,
                $endpoint_secret
            );
        } catch (\UnexpectedValueException $e) {
            // Invalid payload
            return response('', 400);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            // Invalid signature
            return response('', 400);
        }

        // Handle the event
        switch ($event->type) {
            case 'checkout.session.completed':
                $session = $event->data->object;
                $order = Order::where('session_id', $session->id)->first();
                if ($order && $order->status === 'UNPAID') {
                    $order->status = 'PAID';
                    $order->save();
                }

            default:
                echo 'Received unknown event type ' . $event->type;
        }

        return response('');
    }
}
