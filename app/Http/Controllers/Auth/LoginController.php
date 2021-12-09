<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers {
        logout as protected originalLogout;
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware( 'guest' )->except( 'logout' );
    }

    public function username()
    {
        return 'username';
    }

    public function redirectPath()
    {
        return auth()->user()->roles()->first()->allowed_route ?? '/';
    }

    protected function logOut(Request $request)
    {
        $cart = collect( $request->session()->get( 'cart' ) );
        /* Call original Log Out  method*/
        $response = $this->originalLogout( $request );

        /* Repopulate Session with cart */
        if (!config( 'cart.destroy_on_logout' )) {
            $cart->each( function ($rows, $identifier) use ($request) {
                $request->session()->put( "cart.{$identifier}", $rows );
            } );
        }

        /* Return original response*/

        return $response;
    }

    protected function loggedOut(Request $request)
    {
        Cache::forget( 'admin_side_menu' );
    }

}
