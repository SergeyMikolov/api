<?php

namespace App\Http\Requests\GroupType;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class CreateGroupTypeRequest
 * @package App\Http\Requests\groups
 * @property string $display_name
 * @property string $description
 * @property string $image
 * @property string $requirements
 * @property string $duration
 */
class CreateGroupTypeRequest extends FormRequest
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
			'display_name'     => 'required|string|min:3|unique:group_types',
			'image'       => 'required|string',
			'description' => 'required|string|min:3',
			'requirements' => 'required|string|min:3',
			'duration' => 'required|string|min:1',
		];
	}
}
