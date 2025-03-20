<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;
abstract class ApiController extends BaseController
{
    /**
     * Standardized success response.
     */
    protected function successResponse(string $message, $data = [], int $statusCode = 200): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
            'timestamp' => now()->toISOString(),
        ], $statusCode);
    }

    /**
     * Standardized error response.
     */
    protected function errorResponse(string $message, array $errors = [], int $statusCode = 400): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'errors' => $errors,
            'timestamp' => now()->toISOString(),
        ], $statusCode);
    }

    /**
     * Standardized no content response (204).
     */
    protected function noContentResponse($status = 204): JsonResponse
    {
        return response()->json(null, $status);
    }

  /**
     * Standardized paginated response.
     */
    protected function paginatedResponse(array $paginatedData, string $message = "Data retrieved successfully."): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $paginatedData['data'], // Τα DTOs
            'pagination' => $paginatedData['pagination'], // Τα metadata
            'timestamp' => now()->toISOString(),
        ]);
    }

}
