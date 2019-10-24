<?php

namespace App\Domains\Profile\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'filled|email:rfc,dns',
            'first_name' => 'filled|min:3|max:100',
            'last_name' => 'filled|min:3|max:100',
            'address_1' => 'filled|min:3|max:100',
            'address_2' => 'filled|min:3|max:100',
            'city' => 'filled|min:3|max:100',
            'state' => 'filled|min:3|max:100',
            'zip' => 'filled|min:3|max:100',
            'country' => 'filled|min:3|max:100',
            'phone' => 'filled|min:3|max:100',
            'timezone' => 'filled|timezone|min:3|max:100',
            'tags' => 'array',
            'custom_fields' => 'array',
        ];
    }
}
