<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use App\Rules\FormValidationRule;
use App\Models\Enums\FormFieldType;
use Illuminate\Foundation\Http\FormRequest;

class CreateFormRequest extends FormRequest
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
            'name' => 'required|min:3|max:100',
            'description' => 'max:250',
            'fields' => 'required|array',
            'fields.*.slug' => 'required|min:3|max:100|alpha_dash',
            'fields.*.display_name' => 'required|min:3|max:100',
            'fields.*.validations' => [
                'array', new FormValidationRule(),
            ],
            'fields.*.type' => [
                'required', Rule::in(FormFieldType::getValues()),
            ],
        ];
    }

    /**
     * Get a profile identifier field if available.
     *
     * @return false|array
     */
    public function getProfileIdentifier()
    {
        return current(array_filter($this->fields, function ($element) {
            return isset($element['is_profile_identifier'])
                && $element['is_profile_identifier'] === true
                && $element['type'] === FormFieldType::Email;
        }));
    }
}
