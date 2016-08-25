<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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
     * Where to redirect users after login / registration.
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
}
