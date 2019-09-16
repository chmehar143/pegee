<?php

namespace App\Http\Requests;

use Auth;
use Illuminate\Foundation\Http\FormRequest;

class SampleRequest extends FormRequest
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
        $rules = [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone_no' => 'required|max:14',
            'gender' => 'required',
            'company' => 'max:255',
            'street' => 'required|string|max:255',
            'street_2' => 'max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|not_in:0',
            'country' => 'required|not_in:0',
            'postal_code' => 'required|regex:/\b\d{5}\b/',
            'currently_using' => 'max:255',
            'product1' => 'required',
//            'product2' => 'required',
        ];

        if (!Auth::check()) {
            $rules['email'] = 'required|string|email|max:255|unique:users,email';
            $rules['password'] = 'required|string|min:6|confirmed';
        }

        return $rules;
    }

    public function messages()
    {
        $message = [
//            'email.unique' => 'You already submit sample request',
            'product1.required' => 'Product is required',
            'product2.required' => 'Product is required',
        ];
        return $message;
    }

}
