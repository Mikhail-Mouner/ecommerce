<?php

namespace App\Http\Livewire\Frontend;

use App\Http\Livewire\Frontend\traits\InstanceCart;
use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Livewire\Component;

class ProductModalShared extends Component
{
    use InstanceCart;

    public $productModalCount = FALSE;
    public $productModal = [];
    public $qty = 1;
    protected $listeners = [ 'showProductModalAction' ];

    public function showProductModalAction($slug)
    {
        $product = Product::withAvg( 'reviews', 'rating' )->whereSlug( $slug )->first();
        $this->productModal = $product;
        $this->productModalCount = TRUE;
        $this->qty = 1;
    }

    public function decreaseQuantity()
    {
        if ($this->qty > 1) {
            $this->qty--;
        }
    }

    public function increaseQuantity()
    {
        if ($this->qty < $this->productModal->qty) {
            $this->qty++;
        } else {
            $this->sendSweetAlert( 'warning', 'This\'s Maximum Quantity You Can Add!' );
        }
    }

    public function addToCart()
    {
        $this->addInstanceCart( 'default', $this->productModal, $this->qty );
    }

    public function addToWishList()
    {
        $this->addInstanceCart( 'wishlist', $this->productModal );
    }

    public function render()
    {
        return view( 'livewire.frontend.product-modal-shared' );
    }

}
