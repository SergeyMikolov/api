<?php

namespace App\Http\Requests\GroupType;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;

/**
 * Class CreateGroupTypeRequest
 * @package App\Http\Requests\GroupType
 * @property string $display
 * @property string $description
 * @property UploadedFile $img
 */
class CreateGroupTypeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
			'display'     => 'required|string|min:3',
			'img'         => 'required|image',
			'description' => 'required|string|min:3',
        ];
    }
}
