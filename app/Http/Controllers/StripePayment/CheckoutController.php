<?php

namespace App\Http\Controllers\StripePayment;

use App\Models\Cart;
use Stripe\StripeClient;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
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

    public function index()
    {
        return view('payment.index');
    }

    public function __invoke(Request $request)
    {
        $carts = Cart::all();
        $lineItems = [];
        $totalPrice = 0;

        foreach ($carts as $cart) {
            $totalPrice += $cart->price * $cart->quantity;
            $lineItem = [
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $cart->name,
                    ],
                    'unit_amount' => $cart->price * 100,
                ],
                'quantity' => $cart->quantity,
            ];

            $lineItems[] = $lineItem;
        }

        $checkoutSession = $this->stripe->checkout->sessions->create([
            'line_items' => $lineItems,
            'mode' => 'payment',
            'invoice_creation' => ['enabled' => true],
            'ui_mode' => 'embedded',
            'allow_promotion_codes' => true,
            'metadata' => [
                'user_id' => Auth::user()->id,
            ],
            'return_url' => route('payment.success') . "?session_id={CHECKOUT_SESSION_ID}",
        ]);

        // $order = new Order();
        // $order->status = 'UNPAID';
        // $order->total_price = $totalPrice;
        // $order->session_id = $checkout_session->id;
        // $order->save();

        return response()->json(['clientSecret' => $checkoutSession->client_secret])->header('Content-Type', 'application/json');
    }
}
