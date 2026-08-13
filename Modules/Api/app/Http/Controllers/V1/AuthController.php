<?php

namespace Modules\Api\Http\Controllers\V1;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Api\Actions\Auth\LoginAction;
use Modules\Api\Actions\Auth\LogoutAction;
use Modules\Api\Actions\Auth\RegisterAction;
use Modules\Api\Http\Controllers\BaseApiController;
use Modules\Api\Http\Requests\LoginRequest;
use Modules\Api\Http\Requests\RegisterRequest;
use Modules\Api\Http\Resources\UserResource;

class AuthController extends BaseApiController
{
    /**
     * Register a new user.
     */
    public function register(RegisterRequest $request, RegisterAction $action): JsonResponse
    {
        $result = $action->execute($request->validated());

        return $this->createdResponse([
            'user' => new UserResource($result['user']),
            'token' => $result['token'],
        ], 'Registration successful.');
    }

    /**
     * Login a user and issue a token.
     */
    public function login(LoginRequest $request, LoginAction $action): JsonResponse
    {
        $result = $action->execute($request->validated());

        if (!$result) {
            return $this->unauthorizedResponse('Invalid credentials.');
        }

        return $this->successResponse([
            'user' => new UserResource($result['user']),
            'token' => $result['token'],
        ], 'Login successful.');
    }

    /**
     * Logout the authenticated user.
     */
    public function logout(Request $request, LogoutAction $action): JsonResponse
    {
        $action->execute($request->user());

        return $this->successResponse(message: 'Logged out successfully.');
    }

    /**
     * Get the authenticated user's profile.
     */
    public function me(Request $request): JsonResponse
    {
        return $this->successResponse(
            new UserResource($request->user()),
            'User profile retrieved.'
        );
    }
}
