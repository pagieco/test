<?php

namespace App\Domains\Asset\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAssetFolderRequest extends FormRequest
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
            'name' => 'filled|min:3|max:250',
            'description' => 'filled|min:3|max:250',
        ];
    }
}
