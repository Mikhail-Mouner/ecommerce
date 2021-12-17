<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function checkoutPayment(Request $request)
    {
        return $request;
    }

    public function cancelPayment($order_id)
    {
        return $order_id;
    }

    public function completePayment($order_id)
    {
        return $order_id;
    }

    public function weebhook($order_id, $env)
    {
        return $order_id;
    }

}
