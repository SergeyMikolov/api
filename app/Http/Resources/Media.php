<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\Resource;
use InstagramAPI\Response\Model\Item;
use InstagramAPI\Response\TimelineFeedResponse;
use InstagramAPI\Response\UserFeedResponse;

/**
 * Class Media
 * @package App\Http\Resources
 */
class Media extends Resource
{
	/**
	 * @var string
	 */
	public static $type = 'media';

	/**
	 * Transform the resource into an array.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @return array
	 */
	public function toArray ($request)
	{
		$items = $this->getItems();
		dd($items[0], $items[4]);

		/** @var UserFeedResponse $this */
		$medias = collect($this->getItems())->map(function($media) {
			dd($media);
			/** @var  Item $media */
			return [
				'id'                            => $media->id,
				'short_code'                    => $media->getShortCode(),
				'created_time'                  => Carbon::createFromTimestampUTC($media->getCreatedTime())
														 ->format('m.d.y'),
				'type'                          => $media->getType(),
				'link'                          => $media->getLink(),
				'image_low_resolution_url'      => $media->getImageLowResolutionUrl(),
				'image_thumbnail_url'           => $media->getImageThumbnailUrl(),
				'image_standard_resolution_url' => $media->getImageStandardResolutionUrl(),
				'image_high_resolution_url'     => $media->getImageHighResolutionUrl(),
				'carousel_media'                => $media->getCarouselMedia(),
				'caption'                       => $media->getCaption(),
				'videoL_low_resolution_url'     => $media->getVideoLowResolutionUrl(),
				'video_standard_resolution_url' => $media->getVideoStandardResolutionUrl(),
				'video_low_bandwidth_url'       => $media->getVideoLowResolutionUrl(),
				'video_views'                   => $media->getVideoViews(),
				'owner_id'                      => $media->getOwnerId(),
				'likes_count'                   => $media->getLikesCount(),
				'location_id'                   => $media->getLocationId(),
				'location_name'                 => $media->getLocationName(),
				'comments_count'                => $media->getCommentsCount(),
			];
		});

		return [
			'data' => [
				[
					'type'          => 'media',
					'items'         => $medias,
					'max_id'        => $this['maxId'],
					'has_next_page' => $this['hasNextPage'],
				],
			],
		];
	}
}
