<?php

namespace App\Http\Controllers;

use App\Http\Requests\InstagramFeedRequest;
use App\Library\Services\InstagramFeed;
use Illuminate\Support\Facades\Cache;
use InstagramAPI\Instagram;
use Response;

/**
 * Class InstagramController
 * @package App\Http\Controllers
 */
class InstagramController extends Controller
{
	/**
	 * @var InstagramFeed
	 */
	protected $instagramFeed;

	/**
	 * InstagramController constructor.
	 * @param InstagramFeed $instagramFeed
	 */
	public function __construct (InstagramFeed $instagramFeed)
	{
		$this->instagramFeed = $instagramFeed;
	}

	/**
	 * Get instagram feed(paginated)
	 *
	 * @param InstagramFeedRequest $request
	 * @return \Illuminate\Http\Response
	 */
	public function get (InstagramFeedRequest $request)
	{
		try {
			return Cache::remember('test', $this->instagramFeed::CACHETIME, function() {
				return $this->instagramFeed->get();
			})
						->forPage($request->page, $request->on_page)
						->values();
		} catch (\Exception $exception) {

			\Log::error($exception->getMessage(), [
				'file' => $exception->getFile(),
				'line' => $exception->getLine(),
			]);

			return Response::make([
				'message'     => 'Service Unavailable',
				'status_code' => 503,
			], 503);
		}
	}

	/**
	 *
	 */
	public function test ()
	{
		/////// CONFIG ///////
		$username       = 'studioapi';
		$password       = '7411328';
		$debug          = false;
		$truncatedDebug = false;
//////////////////////
		$ig = new Instagram($debug, $truncatedDebug);
		try {
			$ig->login($username, $password);
		} catch (\Exception $e) {
			echo 'Something went wrong: ' . $e->getMessage() . "\n";
			exit(0);
		}
		try {
			// Get the UserPK ID for "anastasiyaeroshkina_poledance" (National Geographic).
			$userId = $ig->people->getUserIdForName('anastasiyaeroshkina_poledance');
			// Starting at "null" means starting at the first page.
			$maxId = null;
			do {
				// Request the page corresponding to maxId.
				$response = $ig->timeline->getUserFeed($userId, $maxId);
				// In this example we're simply printing the IDs of this page's items.
				$items = $response->getItems();
//				dd(($response));
				foreach ($items as $item) {
//					dd($item->getMediaType());
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
			echo 'Something went wrong: ' . $e->getMessage() . "\n";
		}

	}
}
