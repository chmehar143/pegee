<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MetaTagRequest extends FormRequest
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
            'resource_id' => 'required|integer',
            'resource_type' => 'required|string',
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
        ];
    }

    public function messages()
    {
        return [
            'resource_id.required' => 'Please select page',
            'resource_type.required' => 'Please select page',

        ];
    }
}
