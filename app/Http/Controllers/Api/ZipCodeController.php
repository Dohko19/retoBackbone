<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use GuzzleHttp\Psr7\Request;
use App\Http\Services\ZipCodeApi;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;

class ZipCodeController extends Controller
{
    public $zipCodeApi;

    public function __construct()
    {
        $this->zipCodeApi = new ZipCodeApi;
    }

    public function index($zipcode)
    {
        $res = $this->zipCodeApi->getZipCodeData($zipcode);

        // $response = Http::get('https://jobs.backbonesystems.io/api/zip-codes/15530');
        // return $response->json();
        return response()->json($res);
    }
}
