<?php

namespace App\Http\Livewire\Frontend;

use App\Http\Livewire\Frontend\traits\InstanceCart;
use Gloudemans\Shoppingcart\Facades\Cart;
use Livewire\Component;

class Carts extends Component
{
    use InstanceCart;
    public $cart_count = 0;
    public $wishlist_count = 0;
    public $listeners = [ 'updateCart' ];

    public function mount()
    {
        $this->updateCart();
    }

    public function updateCart()
    {
        $this->cart_count = $this->countInstanceCart( 'default' );
        $this->wishlist_count = $this->countInstanceCart( 'wishlist' );
    }


    public function render()
    {
        return view( 'livewire.frontend.carts' );
    }

}
