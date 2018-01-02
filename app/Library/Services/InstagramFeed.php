<?php

use InstagramAPI\Instagram;

/**
 * Class InstagramFeed
 */
class InstagramFeed implements InstagramFeedInterface
{
	/**
	 * studio name
	 */
	const STUDIO = 'anastasiyaeroshkina_poledance';
	/**
	 *
	 */
	const SLEEP = 1;

	/**
	 * @return \Illuminate\Support\Collection
	 */
	public function getUserData ()
	{
		//todo заменить на модельки в базе

		return collect([
			'name' => 'studioapi',
			'password' => '7411328',
		]);
	}

	/**
	 * @return Instagram
	 */
	public function login ()
	{
		$user = $this->getUserData();

		$instagram = new Instagram();
		try {
			$instagram->login($user->name, $user->password);
		} catch (\Exception $e) {
			echo 'Something went wrong: '.$e->getMessage()."\n";
			exit(0);
		}

		return $instagram;
	}

	/**
	 * @param $instagram Instagram
	 * @return \Illuminate\Support\Collection|static
	 */
	public function getUserFeed ($instagram)
	{
		// Starting at "null" means starting at the first page.
		$maxId = null;
		$items = collect();
		try {
			// Get the UserPK ID for "anastasiyaeroshkina_poledance".
			$userId = $instagram->people->getUserIdForName(self::STUDIO);
			do {
				// Request the page corresponding to maxId.
				$response = $instagram->timeline->getUserFeed($userId, $maxId);
				// In this example we're simply printing the IDs of this page's items.
				$items = $items->merge($response->getItems());
				// Now we must update the maxId variable to the "next page".
				// This will be a null value again when we've reached the last page!
				// And we will stop looping through pages as soon as maxId becomes null.
				$maxId = $response->getNextMaxId();
				// Sleep for 1 seconds before requesting the next page. This is just an
				// example of an okay sleep time. It is very important that your scripts
				// always pause between requests that may run very rapidly, otherwise
				// Instagram will throttle you temporarily for abusing their API!
				sleep(self::SLEEP);
			} while ($maxId !== null); // Must use "!==" for comparison instead of "!=".
		} catch (\Exception $e) {
			echo 'Something went wrong: '.$e->getMessage()."\n";
		}

		return $items;
	}

	/**
	 * @param $items \Illuminate\Support\Collection|static
	 * @return mixed
	 */
	public function makeFeedCollection ($items)
	{
		return $items->map(function(\InstagramAPI\Response\Model\Item $item) {

		});
	}

}