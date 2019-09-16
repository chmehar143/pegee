<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminBlogPostRequest extends FormRequest
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

        $rules = [];
        $rules['name'] = 'required|string|max:255';
        $rules['blog_category_id'] = 'required|integer';
        $rules['post_content'] = 'required|string';
        $rules['publish_date'] = 'required|date';
        $rules['author_name'] = 'required|string|max:255';
        return $rules;
    }

    /**
     * @return array
     */

    public function messages()
    {
        return [
            'blog_category_id.required' => 'Blog Category is required',
            'blog_category_id.integer' => 'Blog Category is invalid'
        ];
    }
}
