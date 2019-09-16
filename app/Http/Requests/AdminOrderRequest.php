<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\OrderTransactionDetail;

class AdminOrderRequest extends FormRequest
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
            'status' => 'required|not_in:0',
//            'tracking_id' => 'required',
//            'tracking_type' => 'required_with:tracking_id|in:' . OrderTransactionDetail::TRACKING_TYPE_FEDEX . ',' . OrderTransactionDetail::TRACKING_TYPE_UPS
        ];
    }

}
