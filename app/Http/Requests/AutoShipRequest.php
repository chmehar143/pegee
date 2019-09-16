<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AutoShipRequest extends FormRequest {

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
            'autoship_percentage' => 'required',
            'product' => 'required|not_in:0|unique:auto_ships,product_id,' . $this->segment(3),
        ];
    }

}
