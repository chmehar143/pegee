<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SliderRequest extends FormRequest
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
        switch ($this->method()) {
            case 'POST':
                {
                    $rules = [
                        'slider_image' => 'required|image|mimes:jpeg,jpg|max:2048',
                    ];
                    if($this->get('layer_1')){
                        $rules['layer_1'] = 'url';
                    }
                    return $rules;
                }
            case 'PUT':
            case 'PATCH':
                {
                    $rules = array();
                    if ($this->file('slider_image')) {
                        $rules['slider_image'] = 'required|image|mimes:jpeg,jpg|max:2048';
                    }
                }
                if($this->get('layer_1')){
                    $rules['layer_1'] = 'url';
                }

                return $rules;
            default:
                break;
        }
        return [];
    }

    public function messages()
    {
        return ['layer_1.url' => 'Please provide a link'];
    }

}
