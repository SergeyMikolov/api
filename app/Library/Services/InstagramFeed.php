<?php

namespace App\Library\Services;

use App\Library\Services\Contracts\InstagramFeedInterface;
use App\Models\BotAccount;
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
	const STUDIO = 'anastasiyaeroshkina_poledance';

	/**
	 * sleep time
	 */
	const SLEEP = 1;

	protected function getUserData ()
	{
		dd( BotAccount::inRandomOrder()->first());
	}

	/**
	 * @return Instagram
	 */
	protected function login ()
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
	protected function getUserFeed ($instagram)
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
	protected function makeFeedCollection ($items)
	{
		return $items->map(function(Item $item) {
			return [
				'id' => $item->getId(),
				'media_type' => $item->getMediaType(),
				'medias' => $this->getMediaCollection($item),
			];
		});
	}

	/**
	 * @param Item $item
	 * @return array|\InstagramAPI\Response\Model\VideoVersions[]|string
	 */
	protected function getMediaCollection(Item $item)
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
				return 'Undefined media type';
		}

		return $medias;
	}

	/**
	 * @param Item $item
	 * @return array
	 */
	protected function preparePhoto(Item $item)
	{
		return [$item->image_versions2->candidates];
	}

	/**
	 * @param Item $item
	 * @return array
	 */
	protected function prepareAlbum(Item $item)
	{
		$medias = [];

		foreach ($item->carousel_media as $media) {
			$medias[] = $media->image_versions2->candidates;
		}

		return $medias;
	}

	/**
	 * @param Item $item
	 * @return \InstagramAPI\Response\Model\VideoVersions[]
	 */
	protected function prepareVideo(Item $item)
	{
		return $item->video_versions;
	}

	/**
	 * @return mixed
	 */
	public function get()
	{
		$items = $this->getUserFeed($this->login());

		return $this->makeFeedCollection($items);
	}
}