<?php

namespace App\Http\Requests\TrainerInfo;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class SaveOrderAdDisplayRequest
 * @package App\Http\Requests\trainers
 * @property array $trainers_info
 */
class SaveOrderAdDisplayRequest extends FormRequest
{
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize () : bool
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules () : array
	{
		return [
			'trainers_info'                 => 'required|array',
			'trainers_info.*.name'          => 'required|string|min:3|distinct|exists:users,name',
			'trainers_info.*.display'       => 'required|boolean',
			'trainers_info.*.display_order' => 'required|min:1|distinct',
		];
	}
}
