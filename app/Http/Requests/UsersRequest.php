<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class UsersRequest extends FormRequest {

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
        switch ($this->method()) {
            case 'POST': {
                    return [
                        'first_name' => 'required|string|max:255',
                        'last_name' => 'required|string|max:255',
                        'email' => 'required|string|email|max:255|unique:users,email',
                        'password' => 'required|string|min:6|confirmed',
                        'profile_picture' => 'image|mimes:jpeg,png,jpg|max:2048',
                        'phone_no' => 'max:14',
                        'gender' => 'required',
                    ];
                }
            case 'PUT':
            case 'PATCH': {
                    $rules = [
                        'first_name' => 'required|string|max:255',
                        'last_name' => 'required|string|max:255',
                        'email' => 'required|string|email|max:255|unique:users,email,' . Auth::user()->id,
                        'password' => 'required|string|min:6|confirmed',
                        'phone_no' => 'max:14',
                        'gender' => 'required',
                    ];
                    if ($this->file('profile_picture')) {
                        $rules = [
                            'profile_picture' => 'image|mimes:jpeg,png,jpg|max:2048',
                        ];
                    }
                    return $rules;
                }
            default:break;
        }
        return [];
    }

}
