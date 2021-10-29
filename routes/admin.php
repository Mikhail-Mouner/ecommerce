<?php

use Illuminate\Support\Facades\Route;

Route::namespace( 'Backend' )
    ->name( 'backend.' )
    ->group( function () {
        Route::get( '/', "BackendController@index" )->name( 'index' );
        Route::get( '/login', "BackendController@login" )->name( 'login' );
        Route::get( '/forget', "BackendController@forget" )->name( 'password.request' );
    } );
