<?php

namespace devhereco\SimpleEloquentSearch;
use Exception;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

/**
 * Trait Searchable
 *
 * @package devhereco\SimpleEloquentSearch
 */

trait Searchable
{
    public function setSearchable(array $searchable)
    {
        $this->searchable = $searchable;
    }

    public function scopeSearch(Builder $builder, string $term = '')
    {
        if (empty($this->searchable)) {
            // Handle empty $searchable array gracefully (no search is performed).
            return $builder;
        }

        return $builder->where(function ($query) use ($term) {
            foreach ($this->searchable as $searchable) {
                if (str_contains($searchable, '.')) {
                    [$relation, $column] = explode('.', $searchable);
                    $query->orWhereHas($relation, function ($subQuery) use ($column, $term) {
                        $subQuery->whereRaw('LOWER(' . $column . ') LIKE ?', ['%' . strtolower($term) . '%']);
                    });
                } else {
                    $query->orWhereRaw('LOWER(' . $searchable . ') LIKE ?', ['%' . strtolower($term) . '%']);
                }
            }
        });
    }
}
