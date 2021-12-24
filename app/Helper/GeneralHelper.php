<?php

use \Illuminate\Support\Facades\Cache;

function getParentShowOf()
{
    $current_page = \Route::currentRouteName();
    $route = str_replace( 'backend.', '', $current_page );
    $permission = 
        collect(
            Cache::get( 'admin_side_menu' )->pluck('children')
        )->where( 'as', $route )->first();

    return $permission ? $permission->id : $route;
}

function getParentOf()
{
    $current_page = \Route::currentRouteName();
    $route = str_replace( 'backend.', '', $current_page );
    $permission = Cache::get( 'admin_side_menu' )->where( 'as', $route )->first();

    return $permission ? $permission->parent : $route;
}

function getParentIdOf()
{
    $current_page = \Route::currentRouteName();
    $route = str_replace( 'backend.', '', $current_page );
    $permission = Cache::get( 'admin_side_menu' )->where( 'as', $route )->first();

    return $permission ? $permission->id : NULL;
}

function getNumbers()
{
    $subtotal = \Gloudemans\Shoppingcart\Facades\Cart::instance( 'default' )->subtotal();
    $discount = session()->has( 'coupon' ) ? session()->get( 'coupon' )['discount'] : 0;

    $subtotal_after_discount = $subtotal - $discount;

    $tax = config( 'cart.tax' ) / 100;
    $tax_text = config( 'cart.tax' ) . " %";
    $product_taxes = round( $subtotal_after_discount * $tax, 2 );

    $new_subtotal = $subtotal_after_discount + $product_taxes;

    $shipping = session()->has( 'shipping' ) ? session()->get( 'shipping' )['cost'] : 0;

    $total = $new_subtotal + $shipping > 0 ? round( $new_subtotal + $shipping, 2 ) : 0;

    return collect( [
        'subtotal' => $subtotal,
        'tax' => $tax,
        'tax_text' => $tax_text,
        'product_taxes' => (float) $product_taxes,
        'new_subtotal' => (float) $new_subtotal,
        'discount' => (float) $discount,
        'shipping' => (float) $shipping,
        'total' => (float) $total,
    ] );
}