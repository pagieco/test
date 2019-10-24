<?php

namespace App\Domains\Collection\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use App\Domains\Collection\Enums\CollectionFieldType;
use App\Domains\Collection\Rules\CollectionValidationRule;

class UpdateCollectionRequest extends FormRequest
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
     * @throws \ReflectionException
     */
    public function rules()
    {
        return [
            'name' => 'filled|min:3|max:100',
            'slug' => 'filled|min:3|max:100|alpha_dash',
            'description' => 'max:250',
            'fields' => 'filled|array',
            'fields.*.slug' => 'min:3|max:100|alpha_dash',
            'fields.*.display_name' => 'min:3|max:100',
            'fields.*.validations' => [
                'filled', 'array', new CollectionValidationRule,
            ],
            'fields.*.type'=> [
                'filled', Rule::in(CollectionFieldType::getValues()),
            ],
        ];
    }
}
