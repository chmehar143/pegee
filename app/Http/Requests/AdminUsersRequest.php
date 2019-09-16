<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminUsersRequest extends FormRequest {

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
            'name' => 'required|max:255',
            'email' => 'required|email|unique:admin_users,email,'.$this->get('admin_id'),
            'password' => 'required|min:6|max:20',
            'confirm_password' => 'required|same:password'
        ];
    }

}
