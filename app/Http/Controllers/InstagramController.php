<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;
use InstagramAPI\Instagram;

/**
 * Class InstagramController
 * @package App\Http\Controllers
 */
class InstagramController extends Controller
{
	protected $instagramFeed;

	/**
	 * studio name
	 */
	const STUDIO = 'anastasiyaeroshkina_poledance';

	/**
	 * studio id
	 */
	const USERID = 5539307227;
//
//	/**
//	 * InstagramController constructor.
//	 * @param \InstagramFeed $instagramFeed
//	 */
//	public function __construct (\InstagramFeed $instagramFeed)
//	{
//		$this->instagramFeed = $instagramFeed;
//	}

	public function get1 ()
	{
		//todo заменит на нормальные
		$params = [
			'accessToken'  => '5539307227.d377a25.8c4f8b3bcc9049c7860bcdee99def360',
			'clientId'     => 'd377a25c11364b2bba60676652053222',
			'clientSecret' => '037b4e8e5cc84b1f8921d065e1ac5d0b ',
			'redirectUri'  => 'https://elfsight.com/service/generate-instagram-access-token/',
		];

		$config = [
			'allow_redirects' => false,
			'http_errors'     => false,
		];

		$instagram = new Instagram();
		$user = $instagram->user();
		$next_max_id = '';
		$pagination = 19;
		while (true) {
			$media = $user->selfMediaRecent('5', '', $next_max_id);
			Cache::tags(['instMedia'])->put($pagination, $media->data, 10);

			if (!isset($media->pagination->next_max_id))
				break;
			var_dump($media->pagination->next_max_id);
			$next_max_id = $media->pagination->next_max_id;
			$pagination += 19;

		};

	}

	public function get()
	{
//		Cache::tags(['instMedia'])->flush();
//		dd(Cache::tags(['instMedia'])->get('38'));

		/////// CONFIG ///////
		$username = 'studioapi';
		$password = '7411328';
		$debug = false;
		$truncatedDebug = false;
//////////////////////
		$ig = new Instagram($debug, $truncatedDebug);
		try {
			$ig->login($username, $password);
		} catch (\Exception $e) {
			echo 'Something went wrong: '.$e->getMessage()."\n";
			exit(0);
		}
		try {
			// Get the UserPK ID for "anastasiyaeroshkina_poledance" (National Geographic).
			$userId = $ig->people->getUserIdForName('studioapi');
			// Starting at "null" means starting at the first page.
			$maxId = null;
			do {
				// Request the page corresponding to maxId.
				$response = $ig->timeline->getUserFeed($userId, $maxId);
				// In this example we're simply printing the IDs of this page's items.
				$items = $response->getItems();
//				dd(($response));
				foreach ($items as $item) {
					dump($item);
					printf("[%s] https://instagram.com/p/%s/\n", $item->getId(), $item->getCode());
				}
				// Now we must update the maxId variable to the "next page".
				// This will be a null value again when we've reached the last page!
				// And we will stop looping through pages as soon as maxId becomes null.
				$maxId = $response->getNextMaxId();
				// Sleep for 5 seconds before requesting the next page. This is just an
				// example of an okay sleep time. It is very important that your scripts
				// always pause between requests that may run very rapidly, otherwise
				// Instagram will throttle you temporarily for abusing their API!
				exit();
				echo "Sleeping for 5s...\n";
				sleep(1);
			} while ($maxId !== null); // Must use "!==" for comparison instead of "!=".
		} catch (\Exception $e) {
			echo 'Something went wrong: '.$e->getMessage()."\n";
		}

	}
}
