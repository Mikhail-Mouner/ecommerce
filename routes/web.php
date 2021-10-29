<?php

use Illuminate\Support\Facades\Route;

Route::namespace( 'Frontend' )
    ->name( 'frontend.' )
    ->group( function () {
        Route::get( '/', "FrontendController@index" )->name( 'index' );
        Route::get( '/cart', "FrontendController@cart" )->name( 'cart' );
        Route::get( '/shop', "FrontendController@shop" )->name( 'shop' );
        Route::get( '/details', "FrontendController@details" )->name( 'details' );
        Route::get( '/checkout', "FrontendController@checkout" )->name( 'checkout' );
    } );

Auth::routes( [ 'verify' => TRUE ] );

Route::get( '/home', [ App\Http\Controllers\HomeController::class, 'index' ] )->name( 'home' );
