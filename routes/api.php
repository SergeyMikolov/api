<?php

Route::group(['middleware' => 'api'], function() {

	Route::group(['prefix' => 'auth'], function() {

		Route::post('signup', 'AuthController@register');
		Route::post('login', 'AuthController@login');
		Route::middleware('jwt.refresh')->get('/token/refresh', 'AuthController@refresh');

		Route::group(['middleware' => 'jwt.auth'], function() {
			Route::get('user', 'AuthController@user');
			Route::post('logout', 'AuthController@logout');
		});
	});


	Route::group(['prefix' => 'admin', 'middleware' => ['jwt.auth', 'role:admin']], function() {

		Route::group(['prefix' => 'crud'], function() {

			Route::group(['prefix' => 'training'], function() {
				Route::get('', 'GroupTypeController@get');
				Route::post('', 'GroupTypeController@create');
				Route::post('{groupType}', 'GroupTypeController@update');
				Route::put('saveOrderAndDisplay', 'GroupTypeController@saveOrderAndDisplay');
				Route::delete('{groupType}', 'GroupTypeController@delete');
			});

		});

	});

	Route::group(['prefix' => 'site'], function() {

		Route::get('trainings', 'SiteController@getTrainings');

		Route::group(['prefix' => 'instagram'], function() {
			Route::get('', 'InstagramController@get');
			//	Route::get('media', 'InstagramController@getMedia');
			//    Route::get('/', 'InstagramController@get');
		});

	});


});

Route::group([
	'middleware' => 'auth:api',
	'prefix'     => 'admin',
], function() {
	Route::get('/', function() {
		dd('HELLO ADMIN!');
	});
});

Route::group(['prefix' => 'schedule'], function() {
	Route::get('/instagram-feed', 'ScheduleController@instagramFeedUpdate');
});


Route::get('/test', function() {

	$user = \App\Models\User::whereHas('roles', function($query) {
		$query->whereName('Trainer');
	})
							->first();
	$groupType = \App\Models\GroupType::firstOrFail();
//	$user->groupTypes()->attach($groupType->id);
//	$user->groupTypes()->attach($groupType->id);
	dd($user->groupTypes->toArray());

});