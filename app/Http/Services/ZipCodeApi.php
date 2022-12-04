<?php

namespace App\Http\Services;

use Exception;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class ZipCodeApi
{
/**
     * The guzzle http client instance.
     *
     * @var GuzzleHttp\Client
     */
    protected $httpClient;

    /**
     * The Api base Url
     *
     * @var string
     */
    protected $url;

    /**
     * The api url context
     *
     * @var string
     */
    protected $context = 'api/zip-codes';

    public function __construct()
    {
        $this->url = config('services.zipcode.url');
        $this->httpClient = new Client();
    }

    protected function commit($method, $url, $params = [], $headers = [], $options = '')
    {

        try{
            $rawResponse = $this->httpClient->request($method,$url);

            return $this->parseResponse($rawResponse);
        }catch(Exception $e){
            return $e->getCode();
        }

    }

    public function getZipCodeData($zipcode)
    {
        if(!$zipcode){
            return response()->json(['error' => 'zip code required'], 400);
        }


        return $this->commit('GET', $this->buildUrlFromString($zipcode));

    }

    protected function parseResponse($rawReponse)
    {
        $response = json_decode($rawReponse->getBody(), true);
        $response['http_code'] = $rawReponse->getStatusCode();
        $response['http_message'] = $rawReponse->getReasonPhrase();
        $response['status'] = 'ok';
        $response['raw'] = $rawReponse;
        $response['message'] = (empty($response['message'])) ? '' : $response['message'];
        $response['message'] = (empty($response['message'])) ? $response['http_message'] : $response['message'];
        return $response;
    }

    /**
     * Parse JSON response to array
     *
     * @param $rawResponse
     * @param $request
     * @return array
     *
     */
    protected function parseServerErrorResponse($rawResponse, $request): array
    {
        $response = json_decode($rawResponse->getBody(), true);

        if (is_null($response)){
            return $response['message'] = ['Null'];
        }
        $response['http_code'] = $rawResponse->getStatusCode();
        $response['http_message'] = $rawResponse->getReasonPhrase();
        $response['status'] = 'error';
        $response['raw'] = $rawResponse;
        $response['message'] = $response['error'] ?? $response['mensaje'];
        $this->logRequest($request, $response);
        return $response;
    }

    protected function buildUrlFromString($endpoint)
    {
        $url = $this->url.'/';
        if (!empty($this->context)){
            $url .= $this->context.'/';
        }
        return $url.=$endpoint;
    }

    /**
     * Log request and response to logfile
     *
     * @param string $request
     * @param string $response
     * @return bool
     */
    protected function logRequest($request, $response = null)
    {
        Log::channel('zip_codes_log')->info([
            'request' => json_decode($request),
            'response' => $response
        ]);
        return true;
    }
}
