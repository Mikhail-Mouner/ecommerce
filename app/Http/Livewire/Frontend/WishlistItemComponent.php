<?php

namespace App\Http\Livewire\Frontend;

use App\Http\Livewire\Frontend\traits\InstanceCart;
use Livewire\Component;

class WishlistItemComponent extends Component
{
    use InstanceCart;

    public $item = NULL;

    public function removeFromCart()
    {
        $this->removeInstanceCart( 'wishlist', $this->item );
    }
    public function moveToCart()
    {
        $this->addInstanceCart( 'default', $this->item );
        $this->removeInstanceCart( 'wishlist', $this->item );
    }

    public function render()
    {
        return view( 'livewire.frontend.wishlist-item-component', [
            'cart_item' => $this->getInstanceCart( 'wishlist', $this->item ),
        ] );
    }

}
