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


    protected function sendFailedRecaptchaResponse(Request $request, $errors){
        $errors = ["recaptcha" => "recaptcha failed, because: " . implode(",", $errors) ];

        if ($request->expectsJson()) {
            return response()->json($errors, 422);
        }

        return redirect()->back()
            ->withInput($request->only($this->username(), 'remember'))
            ->withErrors($errors);
    }


    public function login(Request $request){

        $data = $request->all();


        //for when there is recaptcha
        if( !empty($data["g-recaptcha-response"]) && strlen($data["g-recaptcha-response"]) > 1 ){
            $privatekey = env('RECAPTCHA_PRIVATE_KEY');

            $url = 'https://www.google.com/recaptcha/api/siteverify';


            $fields = array(
                'secret' => $privatekey,
                'response' => $data["g-recaptcha-response"]
            );


            $fields_string = "";

            //url-ify the data for the POST
            foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
            rtrim($fields_string, '&');

            //open connection
            $ch = curl_init();

            //set the url, number of POST vars, POST data
            curl_setopt($ch,CURLOPT_URL, $url);
            curl_setopt($ch,CURLOPT_POST, count($fields));
            curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
            curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);


            //execute post
            $result = curl_exec($ch);

            //close connection
            curl_close($ch);

            //turn response into object
            $curl_result_obj = json_decode( $result, true );


            //return a failed response for bad recaptcha whatever
            if( $curl_result_obj["success"] !== true ){
                return $this->sendFailedRecaptchaResponse($request, $curl_result_obj["error-codes"] );
            }
        }

        return $this->traitLogin($request);
    }
}
