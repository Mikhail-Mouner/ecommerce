<?php

namespace App\Http\Livewire\Frontend;

use App\Http\Livewire\Frontend\traits\InstanceCart;
use App\Models\ProductCoupon;
use Livewire\Component;

class CheckoutComponent extends Component
{
    use InstanceCart;
    
    public $total = 0;
    public $subtotal = 0;
    public $cart_tax = 0;
    public $coupon_code = NULL;
    public $cart_discount = NULL;
    public $addresses = NULL;

    public $listeners = [
        'updateCart' => 'mount'
    ];

    public function mount()
    {
        $this->addresses = auth()->user()->addresses;
        $this->subtotal = getNumbers()->get( 'subtotal' );
        $this->cart_tax = getNumbers()->get( 'product_taxes' );
        $this->total = getNumbers()->get( 'total' );
        $this->cart_discount = getNumbers()->get( 'discount' );
    }

    public function render()
    {
        return view( 'livewire.frontend.checkout-component' );
    }

    public function applyDiscount()
    {
        if (getNumbers()->get( 'subtotal' ) > 0) {
            $coupon = ProductCoupon::whereRaw( "BINARY code = ? ",$this->coupon_code )->Active()->first();
            if (!$coupon) {
                $this->resetCoupon( 'Coupon is invalid!' );
            } else {
                $coupon_value = $coupon->discount( $this->subtotal );

                if ($coupon_value > 0) {
                    session()->put( 'coupon', [
                        'code' => $coupon->code,
                        'value' => $coupon->value,
                        'discount' => $coupon_value,
                    ] );
                    $this->emitUpdateCart( 'Coupon is applied successfully!' );
                } else {
                    $this->resetCoupon( 'Coupon is invalid!' );
                }

            }
        } else {
            $this->resetCoupon( 'No product available in your cart' );
        }
    }

    protected function resetCoupon($mssg = NULL, $type = 'error')
    {
        $this->coupon_code = '';
        if (!is_null( $mssg )) {
            $this->sendSweetAlert( $type, $mssg );
        }
    }

    public function removeCoupon()
    {
        session()->remove( 'coupon' );
        $this->resetCoupon();
        $this->emitUpdateCart( 'Coupon is removed successfully!' );
    }

}
