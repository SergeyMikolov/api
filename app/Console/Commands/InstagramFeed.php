<?php

namespace App\Console\Commands;

use Cache;
use Illuminate\Console\Command;
use App\Library\Services\InstagramFeed as InstagramService;

/**
 * Class InstagramFeed
 * @package App\Console\Commands
 */
class InstagramFeed extends Command
{
	/**
	 * @var InstagramFeed
	 */
	protected $instagramService;

	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'instagram:update';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Command description';


	/**
	 * InstagramFeed constructor.
	 * @param InstagramService $instagramService
	 */
	public function __construct (InstagramService $instagramService)
	{
		parent::__construct();

		$this->instagramService = $instagramService;
	}

	/**
	 * Execute the console command.
	 */
	public function handle ()
	{
		try {
			$instagramFeed = $this->instagramService->get();
			Cache::put('i_feed', $instagramFeed, $this->instagramService::CACHETIME);

		} catch (\Exception $exception) {

			\Log::error($exception->getMessage(), [
				'file' => $exception->getFile(),
				'line' => $exception->getLine(),
			]);
		}
	}
}
