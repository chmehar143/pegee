<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmailTemplateRequest extends FormRequest
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
//        dd($this->all());
        $rules = [];
        $attr_keys = $this->get('attr_key');
        $rules['subject'] = 'required|string|max:255';
        $rules['attr_val'] = 'required|array';
        foreach($attr_keys as  $key => $attr_key){
            $rules['attr_val.'.$key] = 'required|string';
        }

        return $rules;
    }


    public function messages()
    {
        $messages = [];
        $attr_keys = $this->get('attr_key');
        foreach($attr_keys as  $key => $attr_key){
            $messages['attr_val.'.$key.'.required'] = ucfirst($attr_key) . ' is Required';
        }
        return $messages;
    }
}
