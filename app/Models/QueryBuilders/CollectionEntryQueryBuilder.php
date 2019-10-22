<?php

namespace App\Models\QueryBuilders;

use App\Models\Collection;
use Illuminate\Support\Arr;
use App\Models\Enums\CollectionFieldType;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class CollectionEntryQueryBuilder
{
    protected $queryColumn = 'entry_data';

    public function build(Collection $model)
    {
        $query = $model->entries();

        foreach ($this->getModelFields($model) as $field) {
            $query->whereRaw($this->getSqlFor($field->type), [
                $this->prepareColumnName($field->slug),
                $this->valueOf($field->slug),
            ]);
        }

        return $query;
    }

    protected function getModelFields(Collection $model): EloquentCollection
    {
        return $model->fields->filter(function ($field) {
            return in_array($field->slug, array_keys(request()->get('filter')));
        });
    }

    protected function getSqlFor(string $type): string
    {
        switch ($type) {
            case CollectionFieldType::PlainText:
                return 'JSON_EXTRACT(' . $this->queryColumn . ', ?) LIKE ?';

            case CollectionFieldType::Switch:
                return 'JSON_EXTRACT(' . $this->queryColumn . ', ?) = ?';
        }
    }

    protected function prepareColumnName(string $column): string
    {
        return '$.' . $column;
    }

    protected function valueOf(string $column): string
    {
        return Arr::get(request()->get('filter'), $column);
    }
}
