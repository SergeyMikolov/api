<?php

namespace App\Http\Requests\TrainerInfo;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class UpdateTrainerInfoRequest
 * @package App\Http\Requests\groups
 * @property string $description
 * @property string $image
 * @property string $name
 */
class UpdateTrainerInfoRequest extends FormRequest
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
			'image'       => 'string',
			'description' => 'required|string|min:3',
		];
	}
}
