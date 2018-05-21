<?php

namespace App\Http\Controllers;

/**
 * Class BaseController
 * @package App\Http\Controllers
 */
class BaseController extends Controller
{
	/**
	 * @param $data
	 * @param string|null $message
	 * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
	 */
	protected function sendResponse ($data = null, string $message = null)
	{
		return response([
			'success' => true,
			'message' => $message ?? 'Action success',
			'data'    => makeArray($data),
		]);
	}

	/**
	 * @param $data
	 * @param string|null $message
	 * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
	 */
	protected function sendBadResponse ($data, string $message = null)
	{
		return response([
			'success' => false,
			'message' => $message ?? 'Action failed',
			'data'    => makeArray($data),
		]);
	}
}
