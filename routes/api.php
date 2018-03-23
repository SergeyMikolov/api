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
    Route::get('media', 'InstagramController@getMedia');
    Route::get('/', 'InstagramController@get');
});

Route::group(['prefix' => 'schedule'], function() {
	Route::get('/instagram-feed', 'ScheduleController@instagramFeedUpdate');
});

Route::get('/instagram', 'InstagramController@get');

Route::get('/test', function() {

	$user = \App\Models\User::whereHas('roles', function($query) {
		$query->whereName('Trainer');
	})->first();
	$groupType = \App\Models\GroupType::firstOrFail();
//	$user->groupTypes()->attach($groupType->id);
//	$user->groupTypes()->attach($groupType->id);
	dd($user->groupTypes->toArray());

});