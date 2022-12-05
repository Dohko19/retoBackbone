<?php

namespace App\Traits;

use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

trait RespondsJson
{
    /**
     * Return a json response with the given data.
     *
     * @param \Illuminate\Contracts\Support\Arrayable|mixed $data
     */
    protected function jsonResponse($data = null, int $httpCode = Response::HTTP_OK)
    {
        if (is_object($data) && $data instanceof Arrayable) {
            $data = $data->toArray();
        }

        if ($data instanceof JsonResource) {
            return $data->additional([
                'success'   => true,
                'message'   => $data,
            ]);
        }

        return response()->json([
            "zip_code" => $data->zipcode,
            "locality" => Str::upper($data->municipality),
            "federal_entity" => [
                "key" => (int)$data->state_code,
                "name" => Str::upper($data->state),
                "code" => null
            ],
            "settlements" => [[
                "key" => (int)$data->settlement_id,
                "name" => Str::upper($data->settlement),
                "zone_type" => Str::upper($data->zone),
                "settlement_type" => [
                    "name" => $data->settlement_type
                ]]
            ],
            "municipality" => [
                "key" => (int)$data->municipality_code,
                "name" => Str::upper($data->municipality)
            ]
        ]);
    }

    /**
     * Return a json response with paginator meta.
     *
     * @param \Illuminate\Contracts\Support\Arrayable|mixed $data
     */
    protected function jsonPaginatedResponse(string $message, Paginator $paginator, int $httpCode = Response::HTTP_OK)
    {

        $meta = [
            'current_page'  => (int) $paginator->currentPage(),
            'last_page'     => (int) $paginator->lastPage(),
            'per_page'      => (int) $paginator->perPage(),
            'from'          => (int) $paginator->firstItem(),
            'to'            => (int) $paginator->lastItem(),
            'total'         => (int) $paginator->total(),
            'next_page_url' => $paginator->nextPageUrl(),
            'prev_page_url' => $paginator->previousPageUrl(),
        ];

        $data = $paginator->getCollection()->values();

        return response()->json([
            'success'   => true,
            'message'   => $message,
            'meta'      => $meta,
            'data'      => $data,
        ], $httpCode);
    }

    /**
     * Create a fully customized json error response.
     *
     * @param array|mixed $data
     */
    protected function jsonErrorResponse(
        string $message = null,
        $data = null,
        int $httpCode = Response::HTTP_BAD_REQUEST
    ): JsonResponse {
        $response = [
            'success' => false,
            'message' => $message,
            'data'    => $data,
        ];

        return response()->json($response, $httpCode);
    }
}
