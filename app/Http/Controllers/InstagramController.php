<?php

namespace App\Http\Controllers;

use marvinosswald\Instagram\Instagram;

class InstagramController extends Controller
{
	/**
	 * studio name
	 */
	const STUDIO = 'anastasiyaeroshkina_poledance';

	/**
	 * studio id
	 */
	const USERID = 5539307227;

	public function get ()
	{

		$params = [
			'accessToken'  => '6783637124.eb68f7e.36590b3c6d2442c8a122e8e91f4e7dd8',
			'clientId'     => 'eb68f7e9d0c246399e7e22f1bc6129e0',
			'clientSecret' => '5a60f3833cde468a939a8cafa7cb13ba ',
			'redirectUri'  => 'https://elfsight.com/service/generate-instagram-access-token/',
		];

		$config = [
			'allow_redirects' => false,
			'http_errors'     => false,
		];

		$instagram = new Instagram($params, $config);
		$user = $instagram->user()->selfMediaRecent('5');
		dd($user);
	}
}
