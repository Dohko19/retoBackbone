<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory, Filterable;

    protected $guarded = [];

    protected $primaryKey = 'zipcode';

    /**
    * The attributes that should be cast to native types.
    *
    * @var array
    */
    protected $casts = [
        'zipcode' => 'string',
    ];
}
