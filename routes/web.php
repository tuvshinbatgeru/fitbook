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

Route::group(['middleware' => ['web']], function () {

	Route::get('/', function () {
    	return view('index');
	});

	Route::get('/api/search', 'SearchController@search');
	Route::get('/search', function(Request $request) {
		    return view('search');
	});

	Route::get('users/{username}', 'UserController@index');
	Route::get('users/{username}/edit', 'UserController@edit')->middleware('auth');
	Route::post('auth/login', 'Auth\LoginController@login');

	Route::get('login', function() {
			return view('auth.login');
	});

	Route::get('/dashboard', function() {
	    return view('dashboard');
	});

	/* api cals */
	/* type - club */
	Route::post('/api/test','FileManagerController@test');
	Route::post('/upload', 'FileManagerController@upload');
	Route::post('/api/user/avatar/{photo}', 'UserController@storeAvatar');

	//Club info APIs
	Route::group(['prefix' => '/api/club/{club}/'], function () {

		Route::get('club-info', 'ClubController@info');
		Route::get('follow', 'UserController@toggleFollow');
		Route::get('request', 'UserController@toggleRequest');
		Route::get('teacher', 'ClubController@getTeachers');

		Route::resource('training', 'TrainingController');
		Route::resource('loyalty', 'LoyaltyController');
		Route::resource('widgets', 'TemplateController');
	});

	//Club edit APIs
	Route::group(['prefix' => '/api/club/edit/{club}/'], function () {

		Route::get('index', 'ClubEditController@index');
		Route::get('member', 'ClubEditController@member');
		Route::get('request', 'ClubEditController@request');
		Route::put('request/{user}', 'ClubEditController@requestResponse');	

	});

	/* type - club */
	Route::get('/api/user/files', 'FileManagerController@files');

	Route::get('/create-club', function(Request $request) {
	    return view('create-club');
	});

	Route::get('/{club}', 'ClubController@index');
	Route::get('/{club}/edit', 'ClubEditController@edit');
	Route::get('auth/logout', 'Auth\LoginController@logout');
	Route::get('auth/verify-account', function() {
	    return view('auth.verify-account');
	});

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

	Route::get('/api/check-user/{username}', function($username) {
		if(User::checkUserAvailable($username))
			return Response::json(['result' => 'no']);
	    return Response::json(['result' => 'ok']);
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
});
Auth::routes();

Route::get('/home', 'HomeController@index');
