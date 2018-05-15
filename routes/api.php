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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});



Route::group([ 'middleware'=>'api'], function () {

	Route::group([ 'prefix'=>'auth'], function () {

		Route::post('signup', 'AuthController@register');
		Route::post('login', 'AuthController@login');
		Route::middleware('jwt.refresh')->get('/token/refresh', 'AuthController@refresh');

		Route::group(['middleware' => 'jwt.auth'], function(){
			Route::get('user', 'AuthController@user');
			Route::post('logout', 'AuthController@logout');
		});
	});

	Route::get('media', 'InstagramController@getMedia');
    Route::get('/', 'InstagramController@get');
});

Route::group([ 'middleware'=>'auth:api', 'prefix' => 'admin'], function () {
	Route::get('/', function(){
		dd('HELLO ADMIN!');
	});
});

Route::group(['prefix' => 'schedule'], function() {
	Route::get('/instagram-feed', 'ScheduleController@instagramFeedUpdate');
});

Route::get('/instagram', 'InstagramController@get');

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