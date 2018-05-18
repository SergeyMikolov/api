<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class RegisterFormRequest
 * @package App\Http\Requests\Auth
 * @property string $name
 * @property string $email
 * @property string $password
 */
class RegisterFormRequest extends FormRequest
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
			'name'     => 'required|string|unique:users',
			'email'    => 'required|email|unique:users',
			'password' => 'required|string|min:6|max:10',
		];
	}
}
