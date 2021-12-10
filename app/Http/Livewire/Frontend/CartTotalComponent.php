<?php

namespace App\Http\Livewire\Frontend;

use Gloudemans\Shoppingcart\Facades\Cart;
use Livewire\Component;

class CartTotalComponent extends Component
{
    public $total = 0;
    public $subtotal = 0;
    public $cart_tax = 0;
    public $listeners = [
        'updateCart' => 'mount'
    ];

    public function mount()
    {
        $this->subtotal = Cart::instance('default')->subtotal();
        $this->cart_tax = Cart::instance('default')->tax();
        $this->total = Cart::instance('default')->total();
    }


    public function render()
    {
        return view( 'livewire.frontend.cart-total-component' );
    }

}
