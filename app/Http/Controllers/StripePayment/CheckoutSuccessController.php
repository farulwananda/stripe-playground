<?php

namespace App\Http\Controllers\StripePayment;

use Exception;
use Stripe\StripeClient;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class CheckoutSuccessController extends Controller
{
    /**
     * Handle the incoming request.
     */

    private $stripe;

    public function __construct()
    {
        $this->stripe = new StripeClient([
            "api_key" => env('STRIPE_SECRET_KEY'),
        ]);
    }

    public function __invoke(Request $request)
    {
        // Validate the session ID
        $sessionId = $request->get('session_id');
        if (!$sessionId || !is_string($sessionId)) {
            throw new NotFoundHttpException('Session ID is invalid');
        }

        try {
            $session = $this->stripe->checkout->sessions->retrieve($sessionId, ['expand' => ['line_items']]);
        } catch (Exception $e) {
            throw new NotFoundHttpException('Checkout session not found');
        }

        // Get the user ID from the session metadata
        $userId = $session->metadata['user_id'] ?? null;
        if (!$userId || !is_numeric($userId)) {
            throw new NotFoundHttpException('Invalid user ID');
        }

        // Validate the user ID
        $user = Auth::user();
        if ($user->id !== intval($userId)) {
            throw new UnauthorizedHttpException('Unauthorized access');
        }

        $customer = $session->customer_details;
        $lineItems = $session->line_items;
        $totalPrice = $session->amount_total / 100;
        $invoice = $session->invoice;

        return view('payment.success', compact([
            'customer', 'lineItems', 'totalPrice', 'invoice'
        ]));
    }
}
