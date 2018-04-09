<?php
namespace App\Library\Services;

use GuzzleHttp\Client;

/**
 * Class HttpClient
 * @package App\Library\Services
 */
class HttpClient
{
	/**
	 * @return Client
	 */
	public static function getHttpClient() : Client
	{
		return new Client([
			'timeout'         => 10.0,
			'allow_redirects' => false,
			'headers'         => [
				'Accept-Encoding' => 'gzip, deflate, br',
				'User-Agent'      => 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/51.0.2704.103 Safari/537.36',
				'Content-Type'    => 'application/x-www-form-urlencoded',
				'Accept'          => '*/*',
				'Accept-Language' => 'en-US,en;q=0.8,hi;q=0.6,und;q=0.4',
			],
		]);
	}
}