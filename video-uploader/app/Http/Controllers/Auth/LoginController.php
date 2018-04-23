<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

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
        login as traitLogin;
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    public function login(Request $request){

        $data = $request->all();

        //for when there is recaptcha
        if( !empty($data["g-recaptcha-response"]) && strlen($data["g-recaptcha-response"]) > 1 ){
            
            $curl_result_obj = \RecaptchaLib::validate($data["g-recaptcha-response"]);

            //return a failed response for bad recaptcha whatever
            if( $curl_result_obj["success"] !== true ){
                return \RecaptchaLib::sendFailedRecaptchaResponse($request, $curl_result_obj["error-codes"] );
            }
        }

        return $this->traitLogin($request);
    }
}
