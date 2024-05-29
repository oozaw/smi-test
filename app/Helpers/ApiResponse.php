<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;

class ApiResponse {

    public static function successCollection(int $code, string $status, $data = null): JsonResponse {
        $response = [
            'code' => $code,
            'status' => $status,
        ];

        $dataArray = $data->toArray();

        if ($dataArray['links']) {
            $response['data'] = $dataArray['data'];
            $response['meta'] = [
                'current_page' => $dataArray['current_page'],
                'first_page_url' => $dataArray['first_page_url'],
                'from' => $dataArray['from'],
                'last_page' => $dataArray['last_page'],
                'last_page_url' => $dataArray['last_page_url'],
                'links' => $dataArray['links'],
                'next_page_url' => $dataArray['next_page_url'],
                'path' => $dataArray['path'],
                'per_page' => $dataArray['per_page'],
                'prev_page_url' => $dataArray['prev_page_url'],
                'to' => $dataArray['to'],
                'total' => $dataArray['total'],
            ];
        } else {
            $response['data'] = $data;
        }

        return response()->json($response, $code);
    }

    public static function success(int $code, string $status, $data = null): JsonResponse {
        return response()->json([
            'code' => $code,
            'status' => $status,
            'data' => $data,
        ], $code);
    }

    public static function error(int $code, string $status, $error = null): JsonResponse {
        return response()->json([
            'code' => $code,
            'status' => $status,
            'errors' => $error,
        ], $code);
    }
}
