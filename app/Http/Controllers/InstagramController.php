<?php

namespace App\Http\Controllers;

use App\Http\Requests\InstagramFeedRequest;
use App\Library\Services\InstagramFeed;
use Illuminate\Support\Facades\Cache;
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
			return Cache::remember('i_feed', InstagramFeed::CACHETIME, function() {
				return $this->instagramFeed->get();
			})
						->forPage($request->page, $request->on_page)
						->values();
		} catch (\Exception $exception) {

			\Log::error($exception->getMessage(), [
				'file'  => $exception->getFile(),
				'line'  => $exception->getLine()
			]);

			return Response::make([
				'message'     => 'Service Unavailable',
				'status_code' => 503,
			], 503);
		}
	}

}
