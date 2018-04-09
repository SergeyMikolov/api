<?php

namespace App\Library\Services;

use App\Library\Services\Contracts\InstagramFeedInterface;
use App\Models\BotAccount;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use InstagramAPI\Instagram;
use InstagramAPI\Response\Model\Item;

/**
 * Class InstagramFeed
 */
class InstagramFeed implements InstagramFeedInterface
{
	/**
	 * studio name
	 */
	const STUDIO = 'rock_n_pole';

	/**
	 * sleep time
	 */
	const SLEEP = 1;

	/**
	 * Cache time in minutes
	 */
	const CACHETIME = 60;

	/**
	 * Api url to get embeded instagram media
	 */
	const EMBED_ENDPOINT = 'https://api.instagram.com/oembed/?url=';

	/**
	 * Get random instagram bot's login data
	 *
	 * @return \Illuminate\Database\Eloquent\Model|null|static
	 */
	protected function getUserData ()
	{
		$user = BotAccount::inRandomOrder()->first();

		if (is_null($user))
			throw new ModelNotFoundException("No bot's accounts");

		return $user;
	}

	/**
	 * Get logged instagram model
	 *
	 * @return Instagram
	 * @throws \Exception
	 */
	protected function login ()
	{
		/** @var BotAccount $user */
		$user = $this->getUserData();

		$instagram = new Instagram();
		try {
			$instagram->login($user->name, $user->password);
		} catch (\Exception $exception) {
			throw $exception;
		}

		return $instagram;
	}

	/**
	 * Get account feed
	 *
	 * @param $instagram Instagram
	 * @param $accountName string
	 * @return \Illuminate\Support\Collection|static
	 * @throws \Exception
	 */
	protected function getUserFeed ($instagram, $accountName)
	{
		// Starting at "null" means starting at the first page.
		$maxId = null;
		$items = collect();
		try {
			// Get the UserPK ID from name.
			$userId = $instagram->people->getUserIdForName($accountName);
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
		} catch (\Exception $exception) {
			throw $exception;
		}

		return $items;
	}

	/**
	 * Prepare feed collection
	 *
	 * @param $items \Illuminate\Support\Collection|static
	 * @return mixed
	 */
	protected function makeFeedCollection ($items)
	{
		$httpClient = HttpClient::getHttpClient();

		return $items->map(function(Item $item)use($httpClient) {
			$embedUrl = self::EMBED_ENDPOINT . $item->getItemUrl();

			$response = $httpClient->request('GET', $embedUrl)
								   ->getBody()
								   ->getContents();
//			dd(preg_replace('/<script [\w\d\s=\"\/\.]+><\/script>/', '', json_decode($response)->html));
			return [
				'id'         => $item->getId(),
				'media_type' => $item->getMediaType(),
				'embed'      => preg_replace('/<script [\w\d\s=\"\/\.]+><\/script>/', '', json_decode($response)->html),
				'preview'    => $this->getMediaCollection($item),
			];
		});
	}

	/**
	 * Chose prepared method to get media from feed item
	 *
	 * @param Item $item
	 * @return array|\InstagramAPI\Response\Model\VideoVersions[]
	 * @throws \Exception
	 */
	protected function getMediaCollection (Item $item)
	{
		switch ($item->getMediaType()) {
			case Item::PHOTO:
				$medias = $this->preparePhoto($item);
				break;
			case Item::ALBUM:
				$medias = $this->prepareAlbum($item);
				break;
			case Item::VIDEO:
				$medias = $this->prepareVideo($item);
				break;
			default:
				throw new \Exception('Undefined media type');
		}

		return $medias;
	}

	/**
	 * @param Item $item
	 * @return string
	 */
	protected function preparePhoto (Item $item)
	{
//		return [$item->image_versions2->candidates];
		return end($item->image_versions2->candidates)->url;
	}

	/**
	 * @param Item $item
	 * @return string
	 */
	protected function prepareAlbum (Item $item)
	{
		$medias = array_shift($item->carousel_media)->image_versions2->candidates;
		return end($medias)->url;
//		$medias = [];
//
//		foreach ($item->carousel_media as $media) {
//			$medias[] = $media->image_versions2->candidates;
//		}
//
//		return $medias;
	}

	/**
	 * @param Item $item
	 * @return \InstagramAPI\Response\Model\VideoVersions[]
	 */
	protected function prepareVideo (Item $item)
	{
		return end($item->image_versions2->candidates)->url;
//		return $item->video_versions;
	}

	/**
	 * Get studio feed
	 *
	 * @return mixed
	 * @throws \Exception
	 */
	public function get ()
	{
		try {
			$items = $this->getUserFeed($this->login(), self::STUDIO);
		} catch (\Exception $exception) {
			throw $exception;
		}

		$feed = $this->makeFeedCollection($items);

		if ($feed->isEmpty())
			throw new \Exception('Feed is empty');

		return $feed;
	}
}