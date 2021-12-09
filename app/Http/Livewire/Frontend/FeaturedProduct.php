<?php

namespace App\Http\Livewire\Frontend;

use App\Http\Livewire\Frontend\traits\InstanceCart;
use App\Models\Product;
use Livewire\Component;

class FeaturedProduct extends Component
{
    use InstanceCart;

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
        $featured_products = Product::query()
            ->with( 'firstMedia' )
            ->inRandomOrder()
            ->active()
            ->featured()
            ->hasQty()
            ->activeCategory()
            ->take( 8 )
            ->get();


        return view( 'livewire.frontend.featured-product', compact( 'featured_products' ) );
    }

}
