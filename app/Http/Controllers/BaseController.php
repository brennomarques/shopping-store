<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

class BaseController extends Controller
{
    /**
     * success response method.
     *
     * @param mixed   $message
     * @param integer $code
     * @return JsonResponse
     */
    public function sendResponse(mixed $message, int $code): JsonResponse
    {
        $response = [
            'success' => true,
            'message' => $message,
        ];

        return response()->json($response, $code);
    }

    /**
     * return error response.
     *
     * @param mixed   $error
     * @param integer $code
     * @return JsonResponse
     */
    public function sendError(mixed $error, int $code = 404): JsonResponse
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];

        return response()->json($response, $code);
    }
}
