<?php

namespace App\Domains\Domain\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateDomainRequest extends FormRequest
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
            'domain_name' => 'required|unique:domains,domain_name',
            'gtm' => 'filled',
            'google_site_verification_id' => 'filled',
            'facebook_pixel_id' => 'filled',
            'timezone' => 'required|timezone',
        ];
    }
}
