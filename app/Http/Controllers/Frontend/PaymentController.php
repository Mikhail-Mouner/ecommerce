<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderTransaction;
use App\Models\Product;
use App\Models\ProductCoupon;
use App\Services\OmnipayService;
use App\Services\OrderService;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function checkoutPayment(Request $request)
    {
        $order = ( new OrderService() )->createOrder( $request->except( [ 'token', 'submit' ] ) );
        $omnipay = new OmnipayService();
        $response = $omnipay->purchase( [
            'amount' => $order->total,
            'transactionId' => $order->id,
            'currency' => $order->currency,
            'cancelUrl' => $omnipay->getCancelUrl( $order->id ),
            'returnUrl' => $omnipay->getReturnUrl( $order->id ),
        ] );

        if ($response->isRedirect()) {
            $response->redirect();
        }
        toast( $response->getMessage(), 'error' );

        $order->transactions()->create( [
            'transaction' => OrderTransaction::NEW_ORDER,
        ] );

        return redirect()->route( 'frontend.index' );
    }

    public function cancelPayment($order_id)
    {
        $order = Order::find( $order_id );
        $order->update( [
            'order_status' => Order::CANCELED,
        ] );
        $order->products()->each( function ($order_product) {
            $order_product->increment( 'qty', $order_product->pivot->qty );
        } );

        toast( "You have Canceled Your order payment!", 'error' );

        return redirect()->route( 'frontend.index' );
    }

    public function completePayment($order_id)
    {
        $order = Order::find( $order_id );
        $omnipay = new OmnipayService();
        $response = $omnipay->complete( [
            'amount' => $order->total,
            'transactionId' => $order->id,
            'currency' => $order->currency,
            'cancelUrl' => $omnipay->getCancelUrl( $order->id ),
            'returnUrl' => $omnipay->getCompleteUrl( $order->id ),
            'notifyUrl' => $omnipay->getNotifyUrl( $order->id ),
        ] );

        if ($response->isSuccessful()) {
            $order->update( [
                'order_status' => Order::PAYMENT_COMPLETED,
            ] );
            $order->transactions()->create( [
                'transaction' => OrderTransaction::PAYMENT_COMPLETED,
                'transaction_no' => $response->getTransactionReference(),
                'payment_result' => 'success',
            ] );

            if (session()->has( 'coupon' )) {
                $coupon = ProductCoupon::whereCode( session()->get( 'coupon' )['code'] )->first();
                $coupon->increment( 'used_times' );
            }
            Cart::instance( 'default' )->destroy();
            session()->forget( [
                'coupon',
                'saved_shipping_company_id',
                'saved_customer_address_id',
                'saved_payment_method_id',
                'shipping',
            ] );
            toast( 'Your recent payment is successful with reference code: ' . $response->getTransactionReference(),
                'success' );
        }


        return redirect()->route('frontend.index');
    }


    public function weebhook($order_id, $env)
    {
        return $order_id;
    }

}
