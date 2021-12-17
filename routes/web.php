<?php

use Illuminate\Support\Facades\Route;

Route::namespace( 'Frontend' )
    ->name( 'frontend.' )
    ->group( function () {
        Route::get( '/', "FrontendController@index" )->name( 'index' );
        Route::get( '/product/{slug}', "FrontendController@product" )->name( 'product' );
        Route::get( '/cart', "FrontendController@cart" )->name( 'cart' );
        Route::get( '/wishlist', "FrontendController@wishlist" )->name( 'wishlist' );
        Route::get( '/shop/{slug?}', "FrontendController@shop" )->name( 'shop' );

        Route::middleware( 'auth' )
            ->group( function () {
                Route::get( '/checkout', "FrontendController@checkout" )->name( 'checkout' );
                Route::post( '/checkout/payment', "PaymentController@checkoutPayment" )->name( 'checkout.payment' );
                Route::get( '/checkout/{order_id}/cancel', "PaymentController@cancelPayment" )->name( 'checkout.cancel' );
                Route::get( '/checkout/{order_id}/completed', "PaymentController@completePayment" )->name( 'checkout.complete' );
                Route::get( '/checkout/weebhook/{order_id?}/{env?}', "PaymentController@weebhook" )->name( 'checkout.webhook.ipn' );
            } );
    } );

Auth::routes( [ 'verify' => TRUE ] );

Route::get( '/home', [ App\Http\Controllers\HomeController::class, 'index' ] )->name( 'home' );
Route::get( '/test', function () {
    return Cart::instance( 'wishlist' )->content();

    return 'test';
} );
