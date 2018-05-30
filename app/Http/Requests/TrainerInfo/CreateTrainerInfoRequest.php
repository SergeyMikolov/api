<?php

namespace App\Http\Requests\GroupType;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class CreateGroupTypeRequest
 * @package App\Http\Requests\groups
 * @property string $description
 * @property string $image
 * @property string $user_name
 */
class CreateTrainerInfoRequest extends FormRequest
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
			'image'       => 'required|string',
			'description' => 'required|string|min:3',
			'description' => 'required|string|min:3',
		];
	}
}
