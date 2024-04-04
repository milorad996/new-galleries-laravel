<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GalleryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|min:2|max:255',
            'description' => 'max:1000',
            'images' => 'min:1',
            'images.*.url' => ['regex:/^(http)?s?:?(\/\/[^\']*\.(?:png|jpg|jpeg))/']
        ];
    }
    public function messages(): array
    {
        return [
            'title.required' => 'The :attribute field is required.',
            'title.min' => 'The :attribute must be at least :min characters.',
            'title.max' => 'The :attribute may not be greater than :max characters.',
            'description.max' => 'The :attribute may not be greater than :max characters.',
            'images.min' => 'The :attribute must have at least :min image.',
            'images.*.url.regex' => 'The :attribute format is invalid.',
        ];
    }
}
