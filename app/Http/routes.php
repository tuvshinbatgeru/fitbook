<?php

use App\User;
use Illuminate\Http\Request;

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

//test
Route::get('/resizeImage', 'FileManagerController@resizeImage');
Route::post('/resizeImagePost',['as'=>'resizeImagePost','uses'=>'FileManagerController@resizeImagePost']);

Route::get('/', function () 
{
    return view('index');
});

Route::get('/dashboard', function() 
{
    return view('dashboard');
});

/* api cals */
/* type - club */

Route::get('/api/search', 'SearchController@search');

Route::get('/api/club/club-info/{clubid}', 'ClubController@info');
Route::get('/api/club/follow/{club}', 'UserController@toggleFollow');
Route::get('/api/club/request/{club}', 'UserController@toggleRequest');
Route::get('/api/club/teacher/{club}', 'ClubController@getTeachers');

Route::get('/api/club/edit/{club}/index', 'ClubEditController@index');
Route::get('/api/club/edit/{club}/member', 'ClubEditController@member');
Route::get('/api/club/edit/{club}/request', 'ClubEditController@request');
Route::put('/api/club/edit/{club}/request/{user}', 'ClubEditController@requestResponse');


/*Route::get('/test/{userId}', function($userId)
{
	return $userId;
})->middleware('throttle:3');*/



Route::get('/create-club', function(Request $request) 
{
    return view('create-club');
});

Route::get('/search', function(Request $request) 
{
    return view('search');
});

Route::get('/{club}', 'ClubController@index');
Route::get('/{club}/edit', 'ClubEditController@edit');

Route::post('auth/login', 'Auth\AuthController@login');
Route::get('auth/logout', 'Auth\AuthController@logout');

Route::get('auth/login', function(){
	return view('auth.login');
});

Route::get('auth/verify-account', function() 
{
    return view('auth.verify-account');
});

/*Route::get('auth/activate', function(){
	return view('/dashboard');
});*/

Route::post('auth/activate', function(Request $request) 
{
	/*dd($user);*/
	/*$user = $request->user;
	$user->save();
	Auth::login($user);*/
	if(User::checkUserAvailable($request->username))
		return redirect('/');

	$user = new User();
    $user->fill($request->all());
	$user->is_active = 'Y';
	$user->save();
	Auth::login($user);
    return redirect('/');
});

Route::get('/api/check-user/{username}', function($username) 
{
	if(User::checkUserAvailable($username))
		return Response::json(['result' => 'no']);
    return Response::json(['result' => 'ok']);
});

//Social Login
Route::get('/login/{provider?}',[
    'uses' => 'Auth\AuthController@getSocialAuth',
    'as'   => 'auth.getSocialAuth'
]);

Route::get('/login/callback/{provider?}',[
    'uses' => 'Auth\AuthController@getSocialAuthCallback',
    'as'   => 'auth.getSocialAuthCallback'
]);