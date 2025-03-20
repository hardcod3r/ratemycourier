<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Api\ApiController;
use App\Actions\AuthenticateUser;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;


class LoginController extends ApiController
{
    public function __construct(private readonly AuthenticateUser $authenticateUser) {}

    public function login(Request $request): JsonResponse
    {
        $result = $this->authenticateUser->execute($request);

        if ($result['success']) {
            unset($result['success']);
            return $this->successResponse($result['message'], $result['user'], $result['status']);
        }
        return $this->errorResponse($result['message'], [], $result['status']);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Logged out successfully'], 200);
    }
}
