<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;
use Laravel\Socialite\Facades\Socialite;
use Validator;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }

    public function login(Request $request)
    {   
        $email = $request->input('username');
        $password = $request->input('password');

        $user = User::where('socialite_type', '=', 1)
                ->where('email', '=', $email)
                ->orWhere('username','=',$email)
                ->first();
                
        if (!$user)
        {
            //Notification::success('Нэр болон нууц үгээ зөв оруулна уу!');
           // return redirect()->back();
            $request->session()->flash('alert-danger', 'Нэр болон нууц үгээ зөв оруулна уу!.', 200);
            return redirect()->back();
        }

        if (Hash::check($password, $user->password))
        {
            Auth::login($user);

            return redirect()->intended('/');
        }
        else
        {
            $request->session()->flash('alert-warning', 'Нэр болон нууц үгээ зөв оруулна уу!.', 200);
            return redirect()->back();
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        //unset($user->password);
        //return view('auth.login',[]);
        return redirect()->intended('/');
    }
    /**
     * Create Email and Password Account.
     */
    public function signup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'displayName' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->messages()], 400);
        }
        $user = new User;
        $user->displayName = $request->input('displayName');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->save();
        return response()->json(['token' => $this->createToken($user)]);
    }

    public function getSocialAuth($provider = null)
    { 
        if(!config("services.$provider")) abort('404'); //just to handle providers that doesn't exist
        return Socialite::driver($provider)->redirect();
    }


    public function getSocialAuthCallback($provider = null)
    {
       $providerUser = Socialite::driver($provider)->user();
       $user = self::isRegisteredUser($providerUser->socialite_type, $providerUser->id);

       if($user)
       {
          Auth::login($user);
          return redirect('/'); 
       }

       $user = new User;
       $user->fill(array(
          'username' => $providerUser->nickname,
          'socialite_id' => $providerUser->id, 
          'socialite_type' => $providerUser->socialite_type,
          'avatar_url' => $providerUser->avatar,
          'birthday' => $providerUser->birthday,
          'gender' => $providerUser->gender,
          'email' => $providerUser->email,
          'is_active' => 'Y',
       ));

       return View::make('auth.verify-account')->with('user', $user);
    }

    private function isRegisteredUser($socialite_type, $id)
    {
        return User::where('socialite_type','=', $socialite_type)
            ->where('socialite_id', '=', $id)
            ->first();
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
        ]);
    }
}
