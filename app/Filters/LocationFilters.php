<?php

namespace App\Filters;

use Carbon\Carbon;

class LocationFilters extends QueryFilters
{
    public function q($zipcode)
    {

        return $this->builder->where('zipcode', $zipcode);
    }
}
