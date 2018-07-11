<?php

namespace App\Traits;

use Flugg\Responder\Contracts\Responder;
use Flugg\Responder\Http\Responses\ErrorResponseBuilder;
use Flugg\Responder\Http\Responses\SuccessResponseBuilder;

/**
 * Trait ResponseUp
 * @package App\Traits
 */
trait ResponseUp
{
	/**
	 * Build a successful response.
	 *
	 * @param  mixed                                                          $data
	 * @param  callable|string|\Flugg\Responder\Transformers\Transformer|null $transformer
	 * @param  string|null                                                    $resourceKey
	 * @return \Flugg\Responder\Http\Responses\SuccessResponseBuilder
	 */
	public function success($data = null, $transformer = null, string $resourceKey = null): SuccessResponseBuilder
	{
		$data = makeArray($data);

		return app(Responder::class)->success($data, $transformer, $resourceKey );
	}

	/**
	 * Build an error response.
	 *
	 * @param  mixed|null  $errorCode
	 * @param  string|null $message
	 * @return \Flugg\Responder\Http\Responses\ErrorResponseBuilder
	 */
	public function error($errorCode = null, string $message = null): ErrorResponseBuilder
	{
		return app(Responder::class)->error(...func_get_args());
	}
}