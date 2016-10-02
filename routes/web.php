<?php

use App\Events\UserOutTraining;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

	Auth::loginUsingId(1);
	//Auth::loginUsingId(1);

	Route::get('/userout', function() {
		event(new UserOutTraining(User::find(1)));
		return "running";
	});

	Route::get('/test', function () {
		return view('test');
	});

	Route::get('/', function () {
    	return view('index');
	});

	Route::get('/search', function(Request $request) {
		return view('search');
	});

	Route::get('/login', function() {
		return view('auth.login');
	});

	Route::get('/dashboard', function() {

		if(Auth::check()) {
			$club = Auth::user()->clubAsReception()->first();
			return view('auth.reception.dashboard')->with('club', $club);
		}

	    return view('auth.reception.dashboard');
	});

	Route::get('/create-club', function(Request $request) {
	    return view('create-club');
	});

	Route::get('auth/verify-account', function() {
	    return view('auth.verify-account');
	});

	//Social Login
	Route::get('/login/{provider?}',[
	    'uses' => 'Auth\LoginController@getSocialAuth',
	    'as'   => 'auth.getSocialAuth'
	]);

	Route::get('/login/callback/{provider?}',[
	    'uses' => 'Auth\LoginController@getSocialAuthCallback',
	    'as'   => 'auth.getSocialAuthCallback'
	]);

	Route::post('auth/activate', function(Request $request) {
		if(User::checkUserAvailable($request->username))
			return redirect('/');

		$user = new User();
	    $user->fill($request->all());
		$user->is_active = 'Y';
		$user->save();
		Auth::login($user);
	    return redirect('/');
	});

	Route::resource('/subscriptions', 'SubscriptionController');
	Route::get('users/{username}', 'UserController@index');
	Route::get('users/{username}/edit', 'UserController@edit')->middleware('auth');
	
	Route::post('auth/login', 'Auth\LoginController@login');
	Route::post('/upload', 'FileManagerController@upload');
	Route::resource('/training', 'TrainingController');
	Route::put('/training', 'TrainingController@updateTraining');
	Route::get('/plan/{plan}', 'PlanController@show');
	Route::get('/plan/{plan}/comments', 'PlanController@comments');
	Route::post('/plan/{plan}/reaction', 'PlanController@toggleReaction');
	Route::get('/{club}', 'ClubController@index');
	Route::get('/{club}/edit', 'ClubEditController@edit');
	Route::get('/auth/logout', 'Auth\LoginController@logout');
	
	

	
