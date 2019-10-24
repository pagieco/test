<?php

namespace App\Domains\User\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCurrentUserRequest extends FormRequest
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
     * password:
     *  - English uppercase characters (A – Z)
     *  - English lowercase characters (a – z)
     *  - Base 10 digits (0 – 9)
     *  - Non-alphanumeric (For example: !, $, #, or %)
     *  - Unicode characters
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'filled|min:3|max:250',
            'email' => 'filled|email:rfc,dns|unique:users',
            'password' => [
                'min:6',
                'regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\X])(?=.*[!$#%]).*$/',
                'confirmed',
            ],
        ];
    }
}
