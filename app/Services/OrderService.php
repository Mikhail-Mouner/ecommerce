<?php


namespace App\Services;


use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\ProductCoupon;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderService
{
    public function createOrder($request)
    {
        $order = Order::create( [
            'ref_id' => 'ORD-' . Str::random( 15 ),
            'user_id' => auth()->id(),
            'user_address_id' => $request['customer_address_id'],
            'shipping_company_id' => $request['shipping_company_id'],
            'payment_method_id' => $request['payment_method_id'],
            'sub_total' => getNumbers()->get( 'subtotal' ),
            'discount_code' => session()->has( 'coupon' ) ? session()->get( 'coupon' )['code'] : NULL,
            'discount' => getNumbers()->get( 'discount' ),
            'shipping' => getNumbers()->get( 'shipping' ),
            'tax' => getNumbers()->get( 'tax' ),
            'total' => getNumbers()->get( 'total' ),
        ] );

        foreach (Cart::content() as $item) {
            OrderProduct::create( [
                'order_id' => $order->id,
                'product_id' => $item->model->id,
                'qty' => $item->qty,
            ] );
            $product = Product::find( $item->model->id );
            $product->decrement( 'qty', $item->qty );
        }

        return $order;
    }

}