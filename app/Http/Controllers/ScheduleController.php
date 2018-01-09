<?php

namespace App\Http\Controllers;

use Cache;
use Illuminate\Http\Request;
use App\Library\Services\InstagramFeed;

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

	private function keyCheck(Request $request)
	{
		return $request->key === env('CRON_KEY');
	}

    public function instagramFeedUpdate(Request $request)
	{
		if ($this->keyCheck($request))
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
