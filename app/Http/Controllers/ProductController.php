<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Order;
use App\Models\Product;
use Stripe\StripeClient;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CheckoutRequest;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class ProductController extends Controller
{

    private $stripe;

    public function __construct()
    {
        $this->stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));
    }

    public function indexCoupon()
    {
        $coupons = $this->stripe->coupons->all([]);
        return view('coupon.index', compact('coupons'));
    }

    public function showCreateCoupon()
    {
        return view('coupon.create');
    }


    public function createCoupon(Request $request)
    {
        $this->stripe->coupons->create([
            'name' => $request->input('name'),
            'percent_off' => $request->input('percent_off'),
        ]);

        // return redirect()->route('coupon.index');
        // sleep(5);
    }

    public function showCoupon(Request $request, $id)
    {
        $promotionCodes = $this->stripe->promotionCodes->all([
            'coupon' => $id
        ]);

        return view('coupon.show', compact('promotionCodes'));
    }

    public function updateCoupon(Request $request, $id)
    {
        $this->stripe->coupons->update($id, [
            'name' => $request->input('name'),
            'percent_off' => $request->input('percent_off'),
        ]);

        return redirect()->route('coupon.index');
    }


    public function indexPromotionCodes($id)
    {

        return view('promotion.index', compact('promotionCodes'));
    }

    public function createPromotionCodes()
    {
        $this->stripe->promotionCodes->create([
            'coupon' => 'wcgIVOZN',
            'code' => 'TEST30',
        ]);
    }

    public function showPromotionCodes($id)
    {
        $promotionCode = $this->stripe->promotionCodes->retrieve($id);

        return view('promotion.show', ['promotionCode' => $promotionCode]);
    }

    public function updatePromotionCodes(Request $request, $id)
    {
        $this->stripe->promotionCodes->update($id, [
            'active' => $request->input('promotionStatus'),
        ]);
    }
}
