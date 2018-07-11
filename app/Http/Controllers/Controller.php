<?php

namespace App\Http\Controllers;

use App\Traits\ResponseUp;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, ResponseUp;
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
