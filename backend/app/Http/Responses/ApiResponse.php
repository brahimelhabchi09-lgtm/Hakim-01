<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;

class ApiResponse
{
    public static function success($data = null, string $message = '', int $status = 200): JsonResponse
    {
        return response()->json(['success' => true, 'message' => $message, 'data' => $data], $status);
    }

    public static function error(string $message, int $status = 400): JsonResponse
    {
        return response()->json(['success' => false, 'message' => $message], $status);
    }

    public static function validationError($errors, string $message = 'Validation failed'): JsonResponse
    {
        return response()->json(['success' => false, 'message' => $message, 'errors' => $errors], 422);
    }
}
