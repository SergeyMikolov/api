<?php

namespace App\Http\Controllers;

use App\Http\Requests\InstagramFeedRequest;
use App\Library\Services\InstagramFeed;
use Illuminate\Support\Facades\Cache;
use InstagramAPI\Instagram;

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
	 * @return mixed
	 */
	public function get (InstagramFeedRequest $request)
	{
		return Cache::remember('test', '10', function() {
			return $this->instagramFeed->get();
		})->forPage($request->page, $request->on_page)->values();
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

	//ssh-rsa AAAAB3NzaC1yc2EAAAADAQABAAACAQC8IA9AljSZMP6aVc8HNqXs81fkqmL1NGDJW7gz0s7VZftFo7zmV3gDy8ruuZQD58Jex2VHdlw2y9jRPb4oW6/5axYBrha9rTiw+g4ALw/bjoFiH2pDiNLArJrWsv7pnz96MzHR1eohBM01r6rxcuVrjVDOeTF1RVkPGYen+20jMPUMdUk+C65Ly05OZu+eSgtE84BV8P5E4vE4E1ISf4Vg/Gj1PeHBxeZsXy3h9h7Br7UkhBmGkdVlOheVsiM4vrSJV1Qi+OsMBTElKRjA5r+S9pUx/MkQ8Xq+ePe68vWd25DMtXROaAvFLkBVbnPBqQxqtsqyZ4r4Rdkj8PnmB10OkZ2p2PWmuVEpFeBoJ7ySwBpUWiIQdflXPz4h5RO2z1p5Sr5EWy7mJYY55tMuXntzztRjlBoCZ36B7phXVaz0vH6tZ24xdojA5AawcOEYqQWOjx2/rD8aWUHfCz2EiLOU1FSO6GBopQmbJ2OAg2cQc+QygZfuMPKNZFr96JNFYbZFgEZYSnL6cUJZu5vjdHxRUHqB/7gcRHwAspuEphfYGrVu+yP2arh2wCbvtZzmgj9ptYE19BY4kpQ6OO7HwFVWuhl9vZX+UoMVTc5Gff91Ixs+jUE7HNNN8iWf55UwJN4zJ6rbk9eMsSkIx+daWHL8Rc5XM/bFp/cFgKAELkST5Q== sergeymikolob@gmail.com
}
