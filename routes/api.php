<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => ['auth:api']], function () {

	Route::get('/check-user/{username}', function($username) {
		if(User::checkUserAvailable($username))
			return Response::json(['result' => 'no']);
	    return Response::json(['result' => 'ok']);
	});

    Route::get('/users', 'UserController@search');
	Route::get('/service', 'ServiceController@listService');	
	Route::get('/search', 'SearchController@search');
	Route::resource('/genre', 'GenreController');
	Route::get('/user/files', 'FileManagerController@files');
	Route::post('/user/avatar/{photo}', 'UserController@storeAvatar');
	Route::resource('/user/comments', 'CommentController');
	Route::post('/user/comments/{comment}/reaction', 'CommentController@reaction');

	Route::group(['prefix' => '/user/{user}/'], function () {

		Route::get('menus', 'UserController@menus');
		Route::get('notifications', 'UserController@notifications');
		Route::get('mentions', 'UserController@mentions');
		Route::get('activity', 'UserController@userActivity');
		Route::get('followed', 'UserController@followedClubs');
		Route::get('subscriptions', 'UserController@subscriptions');
		Route::post('inuser', 'UserController@inUser');
		Route::post('outuser', 'UserController@outUser');

	});

	//Club edit APIs
	Route::group(['prefix' => '/club/edit/{club}/'], function () {

		Route::get('index', 'ClubEditController@index');
		Route::get('members', 'ClubEditController@members');
		Route::get('request', 'ClubEditController@request');
		Route::put('request/{user}', 'ClubEditController@requestResponse');	

	});

	//Club info APIs
	Route::group(['prefix' => '/club/{club}/'], function () {

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

		Route::get('/training', 'TrainingController@clubTrainings');
		Route::get('plan/simple', 'PlanController@simpleSearch');
		Route::get('plan/widget', 'PlanController@forWidgets');
		Route::resource('plan', 'PlanController');
		Route::resource('widgets', 'TemplateController');
		Route::resource('service', 'ServiceController');
		Route::post('/service/edit', 'ServiceController@modifyClubServices');

	});
		

});


