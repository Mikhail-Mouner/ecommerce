<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use Gloudemans\Shoppingcart\Facades\Cart;

class FrontendController extends Controller
{
    public function index()
    {
        $categories = ProductCategory::active()->whereParentId( NULL )->get();

        return view( 'front-end.index', compact( [ 'categories' ] ) );
    }

    public function cart()
    {
        return view( 'front-end.cart' );
    }

    public function wishlist()
    {
        return view( 'front-end.wishlist' );
    }

    public function shop($slug = NULL)
    {
        return view( 'front-end.shop' ,compact('slug'));
    }

    public function product($slug)
    {
        $product = Product::query()
            ->with( 'media' )
            ->with( 'category' )
            ->with( 'tags' )
            ->with( 'reviews' )
            ->withAvg( 'reviews', 'rating' )
            ->Active()
            ->ActiveCategory()
            ->HasQty()
            ->whereSlug( $slug )
            ->first();

        $related_products = Product::with( 'firstMedia' )
            ->whereHas( 'category', function ($query) use ($product) {
                return $query->whereId( $product->product_category_id )
                    ->Active();
            } )
            ->Active()
            ->ActiveCategory()
            ->HasQty()
            ->inRandomOrder()
            ->take( 4 )
            ->get();

        return view( 'front-end.product', compact( [ 'product', 'related_products' ] ) );
    }



}
