<?php

namespace App\Http\Controllers;

use App\Http\Requests\InstagramFeedRequest;
use App\Services\Library\Instagram\InstaService;
use Flugg\Responder\Http\Responses\ResponseBuilder;
use Illuminate\Support\Facades\Cache;

/**
 * Class InstagramController
 * @package App\Http\Controllers
 */
class InstagramController extends Controller
{
	/**
	 * @var InstaService
	 */
	protected $instagram;

	/**
	 * InstagramController constructor.
	 * @param InstaService $instaService
	 */
	public function __construct (InstaService $instaService)
	{
		$this->instagram = $instaService;
	}

	/**
	 * Get instagram feed(paginated)
	 *
	 * @param InstagramFeedRequest $request
	 * @return ResponseBuilder
	 */
	public function get (InstagramFeedRequest $request) : ResponseBuilder
	{
		try {
			$feed = Cache::remember('i_feed', $this->instagram::CACHETIME, function () {
				return $this->instagram->getUserFeed();
			})
			             ->forPage($request->page, $request->on_page)
			             ->values();
		} catch (\Exception $exception) {

			\Log::error($exception->getMessage(), [
				'file' => $exception->getFile(),
				'line' => $exception->getLine(),
			]);

			return $this->error(503, 'Service Unavailable');
		}

		return $this->success($feed);
	}

}
