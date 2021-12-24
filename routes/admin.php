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
                //Dashboard Page
                Route::get( '/', "BackendController@index" )->name( 'index' );
                //Profile Page
                Route::get( '/profile', "BackendController@accountSettings" )->name( 'account_settings' );
                Route::put( '/profile', "BackendController@updateProfile" )->name( 'update_profile' );
                Route::post( '/profile/remove-image', "BackendController@removeImage" )->name( 'profile.removeImage' );

                //Resources Pages
                Route::resources( [
                    '/product_categories' => "ProductCategoriesController",
                    '/product_coupons' => "ProductCouponsController",
                    '/product_reviews' => "ProductReviewController",
                    '/product' => "ProductController",
                    '/tag' => "TagController",
                    '/customer' => "CustomerController",
                    '/customer_address' => "CustomerAddressController",
                    '/supervisor' => "SupervisorController",
                    '/country' => "CountryController",
                    '/state' => "StateController",
                    '/city' => "CityController",
                    '/shipping_company' => "ShippingCompanyController",
                    '/payment_method' => "PaymentMethodController",
                    '/order' => "OrderController",
                ] );

                //To Remove Photo of Category & User {customer, supervisor} (Given id)
                Route::post( '/product_categories/{id}/delete',
                    "ProductCategoriesController@removeImage" )->name( 'product_category.remove_image' );
                Route::post( '/customer-image/{id}/delete',
                    "CustomerController@removeImage" )->name( 'customer.remove_image' );
                Route::post( '/supervisor-image/{id}/delete',
                    "SupervisorController@removeImage" )->name( 'supervisor.remove_image' );

                //To Remove Photo of product (Given image id)
                Route::post( '/product/{id}/delete',
                    "ProductController@removeImage" )->name( 'product.remove_image' );

                //To Search Customer
                Route::get( '/customer-search',
                    "CustomerController@getCustomer" )->name( 'customer.get_customer' );

                //To Get All States Belong To Country
                Route::get( '/states/get_states',
                    "StateController@getStates" )->name( 'states.get_states' );
                //To Get All Cities Belong To States
                Route::get( '/cities/get_cities',
                    "CityController@getCities" )->name( 'cities.get_cities' );
            } );

    } );
