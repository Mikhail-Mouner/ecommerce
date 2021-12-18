<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function dashboard()
    {
        return view('front-end.customer.index');
    }
    public function profile()
    {
        return view('front-end.customer.index');
    }
}
