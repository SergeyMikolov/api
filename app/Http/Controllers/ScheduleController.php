<?php

namespace App\Http\Controllers;

use Cache;
use Illuminate\Http\Request;
use App\Library\Services\InstagramFeed;

/**
 * Class ScheduleController
 * @package App\Http\Controllers
 */
class ScheduleController extends Controller
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
	 * @param Request $request
	 * @return bool
	 */
	private static function keyCheck(Request $request)
	{
		return $request->key === env('CRON_KEY');
	}

	/**
	 * @param Request $request
	 * @return string
	 */
	public function instagramFeedUpdate(Request $request)
	{
		if (self::keyCheck($request))
			try {

				$instagramFeed = $this->instagramFeed->get();

				Cache::put('i_feed', $instagramFeed, $this->instagramFeed::CACHETIME);

				return 'success';

			} catch (\Exception $exception) {

				\Log::error($exception->getMessage(), [
					'file'  => $exception->getFile(),
					'line'  => $exception->getLine()
				]);

				return $exception->getMessage();
			}

		return 'cron key is not valid : ' . $request->key;

	}
}
