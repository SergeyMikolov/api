<?php

namespace App\Http\Controllers;

use App\Http\Requests\InstagramMediaRequest;
use App\Http\Resources\Media;
use Carbon\Carbon;
use InstagramScraper\Exception\InstagramException;
use InstagramScraper\Instagram;
use Response;

/**
 * Class InstagramController
 * @package App\Http\Controllers
 */
class InstagramController extends Controller
{
	/**
	 * studio name in instagram
	 */
	const STUDIO = 'anastasiyaeroshkina_poledance';

	/**
	 * Пагинация по постам в группе
	 *
	 * @param InstagramMediaRequest $request
	 * @return Media|\Illuminate\Http\Response
	 */
	public function getMedia (InstagramMediaRequest $request)
	{
		try {

//			$instagram = new Instagram();

			$instagram = \InstagramScraper\Instagram::withCredentials('studioapi', '7411328', storage_path('cache/sessions'));
			$instagram->login();
dd($instagram->getPaginateMedias($this::STUDIO, $request->max_id));
			return new Media($instagram->getPaginateMedias($this::STUDIO, $request->max_id));

		} catch (InstagramException $instagramException) {

			return Response::make([
				'message'     => $instagramException->getMessage(),
				'status_code' => 503,
			], 503);

		}
	}

	public function get(InstagramMediaRequest $request)
	{

/////// CONFIG ///////
		$username = 'studioapi';
		$password = '7411328';
//////////////////////
		$ig = new \InstagramAPI\Instagram();
		try {
			$ig->login($username, $password);
		} catch (\Exception $e) {
			return Response::make([
				'message'     => $e->getMessage(),
				'status_code' => 503,
			], 503);
		}
		try {

			$userId = $ig->people->getUserIdForName('anastasiyaeroshkina_poledance');

			$response = $ig->timeline->getUserFeed($userId, $request->max_d);

			return new Media($response);
//			$items = $response->getItems();
//
//			$maxId = $response->getNextMaxId();

		} catch (\Exception $e) {
			echo 'Something went wrong: '.$e->getMessage()."\n";
		}
	}
}
