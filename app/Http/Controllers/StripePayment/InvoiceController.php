<?php

namespace App\Http\Controllers\StripePayment;

use Exception;
use Stripe\StripeClient;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class InvoiceController extends Controller
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

    public function __invoke(Request $request, string $invoiceId)
    {
        // Validate the invoice ID
        if (!$invoiceId || !is_string($invoiceId)) {
            throw new NotFoundHttpException('Invalid invoice ID');
        }

        try {
            $invoice = $this->stripe->invoices->retrieve($invoiceId);
        } catch (Exception $e) {
            throw new NotFoundHttpException('Invoice not found');
        }

        // Return the invoice PDF
        return redirect()->to($invoice->invoice_pdf);
    }
}
