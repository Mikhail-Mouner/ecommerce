<?php

namespace App\Http\Livewire\Frontend;

use App\Http\Livewire\Frontend\traits\InstanceCart;
use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Livewire\Component;

class ShowProductComponent extends Component
{
    use InstanceCart;

    public $product = [];
    public $qty = 1;

    public function mount($product)
    {
        $this->product = $product;
    }

    public function decreaseQuantity()
    {
        if ($this->qty > 1) {
            $this->qty--;
        }
    }

    public function increaseQuantity()
    {
        if ($this->qty < $this->product->qty) {
            $this->qty++;
        } else {
            $this->sendSweetAlert( 'warning', 'This\'s Maximum Quantity You Can Add!' );
        }
    }

    public function addToCart()
    {
        $product = $this->product;
        $this->addInstanceCart( 'default', $product, $this->qty );

    }

    public function addToWishList()
    {
        $product = $this->product;
        $this->addInstanceCart( 'wishlist', $product );

    }

    public function render()
    {
        return view( 'livewire.frontend.show-product-component' );
    }

}
