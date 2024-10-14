<?php

namespace Modules\Authentication\Eloquents\Services;

use App\Models\User;
use App\Services\API\Responses\ApiResponseService;
use Illuminate\Http\JsonResponse;
use Modules\Authentication\Eloquents\Contracts\AuthServiceInterface;

class AuthSanctumService implements AuthServiceInterface
{
    public function login(array $credentials): JsonResponse
    {
        if (! auth()->attempt([
            'email' => data_get($credentials, 'email'),
            'password' => data_get($credentials, 'password'),
        ])) {
            return ApiResponseService::unauthorized();
        }

        $token = auth()
            ->user()
            ->createToken(data_get($credentials, 'device_name'))
            ->plainTextToken;

        return ApiResponseService::successTokenResponse($token);
    }

    public function register(array $data): JsonResponse
    {
        $user = User::create($data);

        $token = $user
            ->createToken(data_get($data, 'device_name'))
            ->plainTextToken;

        return ApiResponseService::successTokenResponse($token);
    }

    public function logout(): JsonResponse
    {
        auth()->user()->tokens()->delete();

        return ApiResponseService::success(null, 'Successfully logged out');
    }
}
