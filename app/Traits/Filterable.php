<?php

namespace App\Traits;

use App\Filters\QueryFilters;
use Illuminate\Database\Eloquent\Builder;

trait Filterable
{
    /**
     * Filter a result set.
     *
     * @param Builder      $query
     * @param QueryFilters $filters
     * @param array        $defaults
     *
     * @return Builder
     */
    public function scopeFilter($query, QueryFilters $filters, $defaults = [])
    {
        return $filters->apply($query, $defaults);
    }
}
