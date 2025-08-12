<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;
use App\Helper\AppHelper;

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

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::DASHBOARD;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    // public function username()
    // {
    //     return 'name';
    // }

    public function login(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('name', 'password');
        
        if(Auth::attempt($credentials)) {
            $ipAddress = $request->ip();
            $userIpAddress = Auth::user()->ip_address;

            if ( ($ipAddress == $userIpAddress) || AppHelper::checkIP($request)) {
                return redirect($this->redirectTo);
            } else {
                Auth::logout();
                return redirect('login')->withStatus('You should login from the allowed IP address. Please contact the administrator.');
            }
        }

        return redirect('login')->withStatus('These credentials do not match our records');
    }
}
