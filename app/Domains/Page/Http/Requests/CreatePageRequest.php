<?php

namespace App\Domains\Page\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Http\FormRequest;

class CreatePageRequest extends FormRequest
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
            'domain_id' => 'required',
            'name' => ['required', 'min:3', 'max:250', $this->unique('name')],
            'slug' => ['required', 'max:250', $this->unique('slug')],
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
        return Rule::unique('pages')->where(function (Builder $query) use ($attribute) {
            $query
                ->where($attribute, request($attribute))
                ->where('project_id', request()->user()->current_project_id);
        });
    }
}
