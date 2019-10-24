<?php

namespace App\Domains\Collection\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Http\FormRequest;

class CreateCollectionEntryRequest extends FormRequest
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
            'name' => 'required|min:3|max:100',
            'slug' => ['required', 'max:250', $this->unique('slug')],
            'entry_data' => 'required|array',
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
        return Rule::unique('collection_entries')->where(function (Builder $query) use ($attribute) {
            $query
                ->where($attribute, request($attribute))
                ->where('collection_id', $this->route('collection')->local_id);
        });
    }
}
