<?php

namespace App\Http\Controllers\Api;

use App\Filters\LocationFilters;
use App\Http\Controllers\Controller;
use App\Models\Location;
use Illuminate\Support\Facades\Http;
use App\Traits\RespondsJson;

class ZipCodeController extends Controller
{
    use RespondsJson;

    public function index($zip_code)
    {

        $res = Location::where('zipcode', $zip_code)->get();

        return $this->jsonResponse($res);
    }
}
