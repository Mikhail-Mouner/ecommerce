<?php

namespace App\Http\Livewire\Frontend;

use App\Http\Livewire\Frontend\traits\InstanceCart;
use App\Models\Product;
use App\Models\ProductCategory;
use Gloudemans\Shoppingcart\Facades\Cart;
use Livewire\Component;
use Livewire\WithPagination;

class ListProductsComponent extends Component
{
    use WithPagination, InstanceCart;

    protected $paginationTheme = 'bootstrap';
    public $paginationLimit = 12;
    public $slug = NULL;
    public $sortingBy = 'default';

    public function mount($slug)
    {
        $this->slug = $slug;
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

    public function sortingBy()
    {
        switch ($this->sortingBy) {
            case 'low-high':
                $sort = [ 'price', 'asc' ];
                break;
            case 'high-low':
                $sort = [ 'price', 'desc' ];
                break;
            case 'popularity':
            default:
                $sort = [ 'id', 'asc' ];
                break;
        }

        return $sort;
    }

    public function render()
    {
        list( $sort_field, $sort_type ) = $this->sortingBy();
        $slug = $this->slug;
        $products = Product::with( 'firstMedia' );
        if ($slug == NULL) {
            $products = $products->ActiveCategory();
        } else {
            $product_category = ProductCategory::whereSlug( $slug )->Active()->first();
            if (is_null( $product_category->parent_id )) {
                $categories_id = ProductCategory::whereParent( $product_category->parent_id )->Active()->pluck( 'id' )->toArray();
                $products = $products->whereHas( 'category', function ($query) use ($categories_id) {
                    return $query->whereIn( 'id', $categories_id );
                } );
            } else {
                $products = $products->with( 'category' )->whereHas( 'category', function ($query) use ($slug) {
                    return $query->Active()->whereSlug( $slug );
                } );
            }
        }

        $products = $products->Active()
            ->HasQty()
            ->orderBy( $sort_field, $sort_type )
            ->paginate( $this->paginationLimit );

        return view( 'livewire.frontend.list-products-component', compact( 'products' ) );
    }

}
