<?php

namespace App\Http\Livewire\Frontend;

use App\Http\Livewire\Frontend\traits\InstanceCart;
use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Livewire\Component;

class RelatedProduct extends Component
{
    use InstanceCart;

    public $related_products = [];

    public function mount($related_products)
    {
        $this->related_products = $related_products;
    }

    public function addToCart($id)
    {
        $product = Product::whereId( $id )->first();
        $this->addInstanceCart( 'default', $product );

    }

    public function addToWishList($id)
    {
        $product = Product::whereId( $id )->first();
        $this->addInstanceCart( 'wishlist', $product );

    }

    public function render()
    {
        return view( 'livewire.frontend.related-product' );
    }

}
