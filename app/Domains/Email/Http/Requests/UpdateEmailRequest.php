<?php

namespace App\Domains\Email\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Http\FormRequest;

class UpdateEmailRequest extends FormRequest
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
            'name' => ['filled', 'min:3', 'max:250', $this->unique('name')],
        ];
    }

    /**
     * Get a unique constraint builder instance.
     *
     * @param  string $attribute
     * @return \Illuminate\Validation\Rules\Unique
     */
    protected function unique(string $attribute)
    {
        return Rule::unique('emails')
            ->where(function (Builder $query) use ($attribute) {
                $query
                    ->where($attribute, request($attribute))
                    ->where('project_id', request()->user()->current_project_id);
            })
            ->ignore($this->route('email')->id);
    }
}
