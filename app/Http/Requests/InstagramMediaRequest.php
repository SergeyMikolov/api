<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InstagramMediaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * @property string $max_id
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
            'max_id' => 'nullable|string|size:110', # instagram database cursor
        ];
    }
}
