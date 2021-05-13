<?php

namespace App\Http\Requests\Photo;

use Illuminate\Foundation\Http\FormRequest;

class PhotoRequest extends FormRequest
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
            'photos.*' => ['required', 'image'],
            'array_of_id' => ['sometimes', 'required' ,'array'],
            'array_of_id.*' => ['exists:photos,id']
        ];
    }
}
