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

		//event(new App\Events\PlanAddedEvent(App\Plan::find(10)));

    	return view('index');
	});

	Route::get('/search', function(Request $request) {
		return view('search');
	});

	Route::resource('/subscriptions', 'SubscriptionController');
	Route::get('users/{username}', 'UserController@index');
	Route::get('users/{username}/edit', 'UserController@edit')->middleware('auth');
	Route::post('auth/login', 'Auth\LoginController@login');

	Route::get('login', function() {
		return view('auth.login');
	});

	Route::get('/dashboard', function() {

		if(Auth::check()) {
			$club = Auth::user()->clubAsReception()->first();
			return view('auth.reception.dashboard')->with('club', $club);
		}

	    return view('auth.reception.dashboard');
	});

	//application api
	Route::group(['prefix' => '/api'], function () {

		Route::get('/users', 'UserController@search');
		Route::get('/service', 'ServiceController@listService');	
		Route::post('/test','FileManagerController@test');
		Route::get('/search', 'SearchController@search');
		Route::resource('/genre', 'GenreController');
		Route::get('/user/files', 'FileManagerController@files');
		Route::post('/user/avatar/{photo}', 'UserController@storeAvatar');

	});

	Route::post('/upload', 'FileManagerController@upload');

	//Club info APIs
	Route::group(['prefix' => '/api/club/{club}/'], function () {

		Route::get('club-info', 'ClubController@info');
		Route::get('online', 'ClubController@onlineUsers');
		Route::post('follow', 'UserController@toggleFollow');
		Route::post('request', 'UserController@toggleRequest');
		Route::get('teacher', 'ClubController@getTeachers');
		Route::get('members/{type}', 'ClubController@members');
		Route::post('teacher/{first}/{second}', 'ClubController@toggleTeacherViewOrder');

		Route::post('teacher/{first}/{second}', function($clubId, User $first, User $second, Request $request) {
		    $first->toggleViewOrder($request->type == 'down' ? 'upper' : 'down', $clubId);
        	$second->toggleViewOrder($request->type == 'down' ? 'down' : 'upper', $clubId);
		});

		Route::resource('training', 'TrainingController');
		Route::get('plan/simple', 'PlanController@simpleSearch');
		Route::get('plan/widget', 'PlanController@forWidgets');
		Route::resource('plan', 'PlanController');
		Route::resource('widgets', 'TemplateController');
		Route::resource('service', 'ServiceController');
		Route::post('/service/edit', 'ServiceController@modifyClubServices');

	});

	//Club edit APIs
	Route::group(['prefix' => '/api/club/edit/{club}/'], function () {

		Route::get('index', 'ClubEditController@index');
		Route::get('members', 'ClubEditController@members');
		Route::get('request', 'ClubEditController@request');
		Route::put('request/{user}', 'ClubEditController@requestResponse');	

	});

	Route::group(['prefix' => '/api/user/'], function () {

		Route::resource('comments', 'CommentController');
		Route::post('comments/{comment}/reaction', 'CommentController@reaction');
		
	});

	/* type - User */
	Route::group(['prefix' => '/api/user/{user}/'], function () {

		Route::get('menus', 'UserController@menus');
		Route::get('notifications', 'UserController@notifications');
		Route::get('mentions', 'UserController@mentions');
		Route::get('activity', 'UserController@userActivity');
		Route::get('followed', 'UserController@followedClubs');
		Route::get('subscriptions', 'UserController@subscriptions');
		Route::post('inuser', 'UserController@inUser');
		Route::post('outuser', 'UserController@outUser');

	});

	Route::get('/create-club', function(Request $request) {
	    return view('create-club');
	});

	Route::get('/plan/{plan}', 'PlanController@show');
	Route::get('/plan/{plan}/comments', 'PlanController@comments');
	Route::post('/plan/{plan}/reaction', 'PlanController@toggleReaction');
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
