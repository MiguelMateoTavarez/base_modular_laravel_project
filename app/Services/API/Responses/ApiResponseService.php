<?php

namespace App\Services\API\Responses;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ApiResponseService
{
    public static function success($data, $message = 'Success', $code = Response::HTTP_OK): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    public static function error($message = 'Error', $code = Response::HTTP_BAD_REQUEST): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
        ], $code);
    }

    public static function unauthorized($message = 'Unauthorized'): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
        ], Response::HTTP_UNAUTHORIZED);
    }

    public static function notFound($message = 'Not Found'): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
        ], Response::HTTP_NOT_FOUND);
    }

    public static function throttled(int $maxAttempts = 60, int $retryAfter = 60): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'message' => 'Too many attempts, please slow down the request.',
            'retry_after' => $retryAfter,
            'max_attempts' => $maxAttempts,
        ], Response::HTTP_TOO_MANY_REQUESTS);
    }

    public static function successTokenResponse($token): JsonResponse
    {
        return self::success([
            'token' => $token,
            'token_type' => 'bearer',
        ]);
    }
}
