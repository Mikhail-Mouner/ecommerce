<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BackendController extends Controller
{
    public function index()
    {
        return view( 'back-end.index' );
    }

    public function login()
    {
        return view( 'back-end.auth.login' );
    }

    public function forget()
    {
        return view( 'back-end.auth.forget' );
    }

}
