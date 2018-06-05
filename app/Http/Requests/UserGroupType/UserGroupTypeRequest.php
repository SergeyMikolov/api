<?php

namespace App\Http\Requests\UserGroupType;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class UserGroupTypeRequest
 * @package App\Http\Requests\UserGroupType
 * @property array $user_group_types
 *
 */
class UserGroupTypeRequest extends FormRequest
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
			'user_group_types'   => 'array',
			'user_group_types.*' => 'required|string|exists:group_types,slug',
		];
	}
}
