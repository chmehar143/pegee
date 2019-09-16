<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest {

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
                    $rules = [
                        'name' => 'required|string|max:255',
                        'price' => 'required',
                        'product_quantity' => 'required|integer',
                        'product_description' => 'required|string',
                        'short_description' => 'required|string',
                        'product_height' => 'required|integer',
                        'product_width' => 'required|integer',
                        'product_packaging' => 'required|string',
                        'product_code' => 'required|string|unique:products,product_code,' . $this->segment(3),
                        'category_id' => 'required|not_in:0',
                    ];

                    $count = $this->get('total_images');

                    for ($i = 0; $i < $count; $i++) {
                        $rules['product_picture.' . $i] = 'required|image|mimes:jpeg,png,jpg|max:10240';
                    }

                    return $rules;
                }
            case 'PUT':
            case 'PATCH': {
                    $rules = [
                        'name' => 'required|string|max:255',
                        'price' => 'required',
                        'product_quantity' => 'required|integer',
                        'product_description' => 'required|string',
                        'short_description' => 'required|string',
                        'product_height' => 'required|integer',
                        'product_width' => 'required|integer',
                        'product_packaging' => 'required|string',
                        'product_code' => 'required|string|unique:products,product_code,' . $this->segment(3),
                        'category_id' => 'required|not_in:0',
                    ];
                    if ($this->file('product_picture')) {
                        
                        $count = $this->get('total_images');

                        for ($i = 0; $i < $count; $i++) {
                            $rules['product_picture.' . $i] = 'required|image|mimes:jpeg,png,jpg|max:10240';
                        }
                    }
                    return $rules;
                }
            default:break;
        }
        return [];
    }

    public function messages() {
        $messages = [];
        $messages = [
            'name.required' => 'Please enter product name.',
            'name.regex' => 'Please enter valid product name use only letters.',
            'category_id.required' => 'Please select category.',
            'category_id.not_in' => 'Please select category.',
        ];
        $count = $this->get('total_images');

        for ($i = 0; $i < $count; $i++) {
            $messages['product_picture.' . $i . '.required'] = 'Product Picture field is required';
            $messages['product_picture.' . $i . '.image'] = 'Product Picture must be an image';
            $messages['product_picture.' . $i . '.max'] = 'Product Picture size must be less than 10mb';
        }

        return $messages;
    }

}
