<?php

namespace App\Http\Requests\GroupType;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class SaveOrderAdDisplayRequest
 * @package App\Http\Requests\groups
 * @property array $group_types
 */
class SaveOrderAdDisplayRequest extends FormRequest
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
			'group_types'                 => 'required|array',
			'group_types.*.slug'          => 'required|string|min:3|distinct|exists:group_types',
			'group_types.*.display'       => 'required|boolean',
			'group_types.*.display_order' => 'required|min:1|distinct',
		];
	}
}
