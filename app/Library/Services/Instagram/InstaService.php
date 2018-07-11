<?php
declare( strict_types = 1 );

namespace App\Services\Library\Instagram;

use App\Clients\Library\Clients\InstaClient;
use App\Library\Services\HttpClient;
use Illuminate\Support\Collection;
use InstagramAPI\Instagram;
use InstagramAPI\Response\Model\Item;

/**
 * Class InstaFeed
 * @package App\Services\Instagram
 */
class InstaService
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
	 * @var Instagram
	 */
	private $instagramClient;

	/**
	 * InstaService constructor.
	 */
	public function __construct ()
	{
		$this->instagramClient = InstaClient::make();
	}

	/**
	 * Get account feed
	 *
	 * @param string|null $accountName
	 * @return \Illuminate\Support\Collection
	 */
	public function getUserFeed (string $accountName = self::STUDIO) : Collection
	{
		# Starting at "null" means starting at the first page.
		$maxId = null;
		$items = collect();

		# Get the UserPK ID from name.
		$userId = $this->instagramClient->people->getUserIdForName($accountName);
		do {
			# Request the page corresponding to maxId.
			$response = $this->instagramClient->timeline->getUserFeed($userId, $maxId);
			# In this example we're simply printing the IDs of this page's items.
			$items = $items->merge($response->getItems());
			# Now we must update the maxId variable to the "next page".
			# This will be a null value again when we've reached the last page!
			# And we will stop looping through pages as soon as maxId becomes null.
			$maxId = $response->getNextMaxId();
			# Sleep for 1 seconds before requesting the next page.
			# It is very important that your scripts
			# always pause between requests that may run very rapidly, otherwise
			# Instagram will throttle you temporarily for abusing their API!
			sleep(self::SLEEP);
		} while ($maxId !== null); # Must use "!==" for comparison instead of "!=".

		return $this->makeFeedCollection($items);
	}

	/**
	 * Prepare feed collection
	 *
	 * @param $items \Illuminate\Support\Collection|static
	 * @return mixed
	 */
	protected function makeFeedCollection ($items)
	{
		$httpClient = HttpClient::make();

		return $items->map(function (Item $item) use ($httpClient) {
			$embedUrl = self::EMBED_ENDPOINT . $item->getItemUrl();

			$response = $httpClient->request('GET', $embedUrl)
			                       ->getBody()
			                       ->getContents();
//			dd(preg_replace('/<script [\w\d\s=\"\/\.]+><\/script>/', '', json_decode($response)->html));
			return [
				'id'         => $item->getId(),
				'media_type' => $item->getMediaType(),
				'embed'      => preg_replace('/<script [\w\d\s=\"\/\.]+><\/script>/', '', json_decode($response)->html),
//				'preview'    => $this->getMediaCollection($item),
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
	private function getMediaCollection (Item $item)
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
	private function preparePhoto (Item $item)
	{
		return end($item->image_versions2->candidates)->url;
	}

	/**
	 * @param Item $item
	 * @return string
	 */
	private function prepareAlbum (Item $item)
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
	private function prepareVideo (Item $item)
	{
		return end($item->image_versions2->candidates)->url;
	}
}