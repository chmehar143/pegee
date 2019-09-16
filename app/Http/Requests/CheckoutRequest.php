<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        $rules = [
            'phone' => 'max:14',
            'company' => 'max:255',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'street' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|not_in:0',
            'country' => 'required|not_in:0',
            'postal_code' => 'required|regex:/\b\d{5}\b/',
            'cardHolderName' => 'required',
        ];
        if ($this->get('billingCheckBox') == 0) {
            $rules['b_street'] = 'required|string|max:255';
            $rules['b_city'] = 'required|string|max:255';
            $rules['b_state'] = 'required|not_in:0';
            $rules['b_postal_code'] = 'required|regex:/\b\d{5}\b/';
            $rules['b_phone_no'] = 'max:14';
        }
        if ($this->get('auto') == 1) {
            $rules['autoShip'] = 'required|not_in:0';
        }
        return $rules;
    }

    public function messages() {
        $messages = [];
        $messages = [
            'state.required' => 'The state field is required.',
            'state.not_in' => 'The state field is required.',
            'country.required' => 'The country field is required.',
            'country.not_in' => 'The country field is required.',
            'postal_code.regex' => 'Invalid postal code.',
            'cardHolderName.required' => 'The card holder name field is required.',
            'autoShip.required' => 'Please select the interval for autoship.',
            'b_state.required' => 'The state field is required.',
            'b_city.required' => 'The state field is required.',
            'b_state.not_in' => 'The state field is required.',
            'b_postal_code.regex' => 'Invalid postal code.',
            'b_postal_code.required' => 'The postal code field is required.',
            'b_phone_no.max' => 'The maximum 14 numbers for phone number.',
            'phone.max' => 'The maximum 14 numbers for phone number.',
            'b_street.required' => 'The Address field is required.',
        ];
        return $messages;
    }

}
