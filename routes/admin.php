<?php

use Illuminate\Support\Facades\Route;

Route::namespace( 'Backend' )
    ->name( 'backend.' )
    ->group( function () {
        /**
         * Group Of Routes that has middleware guest
         */
        Route::middleware( 'guest' )
            ->group( function () {
                Route::get( '/login', "BackendController@login" )->name( 'login' );
                Route::get( '/forget', "BackendController@forget" )->name( 'password.request' );
            } );

        /**
         * Group Of Routes that must visit by admin OR supervisor
         */
        Route::middleware( [ 'role:admin|supervisor', 'auth' ] )
            ->group( function () {
                Route::get( '/', "BackendController@index" )->name( 'index' );
                Route::resources( [
                    '/product_categories' => "ProductCategoriesController",
                    '/product_coupons' => "ProductCouponsController",
                    '/product_reviews' => "ProductReviewController",
                    '/product' => "ProductController",
                    '/tag' => "TagController",
                ] );
                Route::post( '/product_categories/{id}/delete',
                    "ProductCategoriesController@removeImage" )->name( 'product_category.remove_image' );
                Route::post( '/product/{id}/delete',
                    "ProductController@removeImage" )->name( 'product.remove_image' );
            } );

    } );
