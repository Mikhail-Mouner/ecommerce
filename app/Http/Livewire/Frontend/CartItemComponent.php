<?php

namespace App\Http\Livewire\Frontend;

use App\Http\Livewire\Frontend\traits\InstanceCart;
use Gloudemans\Shoppingcart\Facades\Cart;
use Livewire\Component;

class CartItemComponent extends Component
{
    use InstanceCart;

    public $item = NULL;
    public $item_qty = 1;

    public function mount()
    {
        $this->item_qty = $this->getInstanceCart( 'default', $this->item )->qty;
    }

    public function decreaseQuantity()
    {
        if ($this->item_qty > 1) {
            $this->updateQtyCart( $this->item, --$this->item_qty );
        }
    }

    public function increaseQuantity()
    {
        if ($this->item_qty < $this->getInstanceCart( 'default', $this->item )->model->qty) {
            $this->updateQtyCart( $this->item, ++$this->item_qty );
        } else {
            $this->sendSweetAlert( 'warning', 'This\'s Maximum Quantity You Can Add!' );
        }
    }

    public function removeFromCart()
    {
        $this->removeInstanceCart( 'default', $this->item );
    }

    public function render()
    {
        return view( 'livewire.frontend.cart-item-component', [
            'cart_item' => $this->getInstanceCart( 'default', $this->item ),
        ] );
    }

}
