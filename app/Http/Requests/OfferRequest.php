<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OfferRequest extends FormRequest {

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
        return [
            'offer' => 'required|integer',
            'quantity' => 'required|integer',
            'product_id' => 'required|not_in:0',
        ];
    }

    public function messages() {
        $messages = [];
        $messages = [
            'product_id.required' => 'Please select product.',
            'product_id.not_in' => 'Please select product.',
        ];
        return $messages;
    }

}
