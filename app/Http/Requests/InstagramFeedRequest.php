<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class InstagramFeedRequest
 * @package App\Http\Requests
 * @property integer $page
 * @property integer $on_page
 */
class InstagramFeedRequest extends FormRequest
{
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize ()
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules ()
	{
		return [
			'page'    => 'required|integer|min:1',
			'on_page' => 'required|integer|min:1',
		];
	}
}
