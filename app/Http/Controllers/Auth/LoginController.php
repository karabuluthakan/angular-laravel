<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        login as protected tlogin;
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/admin';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            $this->username() => 'required|string|exists:users,' . $this->username() . ',status,1',
            'password' => 'required|string',
        ], [
            $this->username() . '.exists' => __('message.user_login_account_must_be_enabled')
        ]);
    }

    public function login(Request $request)
    {
        $return = $this->tlogin($request);

//        $companies = array_keys(\Auth::user()->getCompanies());
//        if (!empty($companies))
//            $request->session()->put('company', $companies[0]);

        return $return;
    }

    public function apiLogin(Request $request)
    {
        $this->validateLogin($request);

        if ($this->attemptLogin($request)) {
            $user = $this->guard()->user();
            $user->generateToken();

            return response()->json([
                'status' => 1,
                'code' => 'logined',
                'data' => $user->api_token,
            ]);
        }

        return $this->sendFailedLoginResponse($request);
    }

    public function apiLogout(Request $request)
    {
        $user = Auth::guard('api')->user();

        if ($user) {
            $user->api_token = null;
            $user->save();
        }

        return response()->json([
            'status' => 1,
            'code' => 'logouted',
            'message' => __('message.api_logout')
        ], 200);
    }
}
