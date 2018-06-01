<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

use App\Http\Helpers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use App\Jobs\SendVerificationEmail;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'ipaddress' => Helpers::getRealIpAddr(),
            'email_token' => base64_encode($data['email'])
        ]);
    }

    /**
    * Handle a registration request for the application.
    *
    * @param \Illuminate\Http\Request $request
    * @return \Illuminate\Http\Response
    */
    public function register(Request $request)
    {

        //recaptcha stuff
        $data = $request->all();

	   if( !$request->session()->has('registered') ||
	   ($request->session()->get('registered') != $data["email"]) ){

	        //for when there is recaptcha
	        if( !empty($data["g-recaptcha-response"]) && strlen($data["g-recaptcha-response"]) > 1 ){
	            
	            $curl_result_obj = \RecaptchaLib::validate($data["g-recaptcha-response"]);

	            //return a failed response for bad recaptcha whatever
	            if( $curl_result_obj["success"] !== true ){
	                return \RecaptchaLib::sendFailedRecaptchaResponse($request, $curl_result_obj["error-codes"] );
	            }else{
                    $request->session()->put('registered', $data["email"] );
	            }
	        }

	        $this->validator($data)->validate();
	        event(new Registered($user = $this->create($data)));
	        dispatch(new SendVerificationEmail($user));
	        return view('email.verification');
        }
    }

    /**
    * Handle a registration request for the application, but after they hit the link in the email.
    *
    * @param $token
    * @return \Illuminate\Http\Response
    */
    public function verify($token)
    {
        $user = User::where('email_token',$token)->first();
        $user->verified = 1;
        if($user->save()){
            return view('email.emailconfirm',['user'=>$user]);
        }
    }
}
