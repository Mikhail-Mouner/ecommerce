<?php

use \Illuminate\Support\Facades\Cache;

function getParentShowOf()
{
    $current_page = \Route::currentRouteName();
    $route = str_replace( 'backend.', '', $current_page );
    $permission = Cache::get( 'admin_side_menu' )->where( 'as', $route )->first();

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

