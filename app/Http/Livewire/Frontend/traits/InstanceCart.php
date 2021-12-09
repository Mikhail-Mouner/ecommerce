<?php

namespace App\Http\Livewire\Frontend\traits;

use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;

trait InstanceCart
{
    use SendSweetAlertTrait;

    public function addInstanceCart($instance, $product, $qty = 1)
    {
        $duplicate_check = Cart::instance( $instance )->search( function ($cartItem, $rowId) use ($product) {
            return $cartItem->id === $product->id;
        } );
        if ($duplicate_check->isNotEmpty()) {
            $this->sendSweetAlert( 'error', 'Product Already Exist!' );
        } else {

            Cart::instance( $instance )
                ->add( $product->id, $product->name, $qty, $product->price )
                ->associate( Product::class );

            $this->emit( 'updateCart' );
            $this->sendSweetAlert( 'success', 'Product Added In Your ' . ucfirst( $instance ) . ' Successfully!' );
        }
    }


    public function countInstanceCart($instance)
    {
        return Cart::instance( $instance )->count();
    }

    public function getInstanceCart($instance, $rowId)
    {
        return Cart::instance( $instance )->get( $rowId );
    }

    public function updateQtyCart($rowId, $qty)
    {
        Cart::instance( 'default' )->update( $rowId, $qty );
        $this->emit( 'updateCart' );
    }

    public function removeInstanceCart($instance, $rowId)
    {
        /** TODO::Fix the bug */
        Cart::instance( $instance )->remove( $rowId );
        $this->emit( 'updateCart' );
        $this->sendSweetAlert( 'success', 'Remove Product From Your ' . ucfirst( $instance ) . ' Successfully!' );
    }

}