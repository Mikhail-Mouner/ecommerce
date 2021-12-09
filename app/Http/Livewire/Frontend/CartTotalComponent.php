<?php

namespace App\Http\Livewire\Frontend;

use Gloudemans\Shoppingcart\Facades\Cart;
use Livewire\Component;

class CartTotalComponent extends Component
{
    public $total = 0;
    public $subtotal = 0;

    public function mount()
    {
        $this->total = Cart::subtotal();
        $this->subtotal = Cart::total();
    }


    public function render()
    {
        return view('livewire.frontend.cart-total-component');
    }
}
