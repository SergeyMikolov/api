<?php
declare( strict_types = 1 );

namespace App\Clients\Library\Clients;

use App\Drivers\Storage\Redis;
use App\Models\Instagram\BotAccount;
use InstagramAPI\Instagram;

/**
 * Class InstaClient
 * @package App\Clients\InstaClient
 */
class InstaClient
{
	/**
	 * Get random instagram bot's login data
	 *
	 * @return BotAccount
	 */
	protected static function getBot () : BotAccount
	{
		/** @noinspection PhpDynamicAsStaticMethodCallInspection */
		$user = BotAccount::inRandomOrder()->firstOrFail();

		return $user;
	}

	/**
	 * @return array
	 */
	public static function getDefaultStorage () : array
	{
		return [
			'storage' => 'custom',
			'class'   => new Redis(),
		];
	}

	/**
	 * Get logged instagram model
	 *
	 * @param BotAccount|null $botAccount
	 * @param array|null      $storageConfig
	 * @return Instagram
	 */
	public static function make (BotAccount $botAccount = null, array $storageConfig = null) : Instagram
	{
		if (is_null($botAccount))
			$botAccount = self::getBot();

		if (is_null($storageConfig))
			$storageConfig = self::getDefaultStorage();

		# stupid package security
		Instagram::$allowDangerousWebUsageAtMyOwnRisk = true;

		$instagram = new Instagram(false, false, $storageConfig);

		$instagram->login($botAccount->name, $botAccount->password);

		return $instagram;
	}
}