<?php

Route::group(['middleware' => 'api'], function() {

	Route::group(['prefix' => 'auth'], function() {

		Route::post('signup', 'AuthController@register');
		Route::post('login', 'AuthController@login');
		/** @noinspection PhpUndefinedMethodInspection */
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

			Route::group(['prefix' => 'trainer'], function() {
				Route::get('users', 'TrainerController@getTrainers');
				Route::get('', 'TrainerController@getTrainersInfo');
				Route::post('{user}', 'TrainerController@create');
				Route::put('saveOrderAndDisplay', 'TrainerController@saveOrderAndDisplay');
				Route::put('{user}', 'TrainerController@update');
				Route::delete('{user}', 'TrainerController@delete');
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
	Route::group(['prefix' => 'schedule'], function() {
		Route::get('/instagram-feed', 'ScheduleController@instagramFeedUpdate');
	});
});