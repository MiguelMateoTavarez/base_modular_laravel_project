<?php

namespace Modules\Authentication\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Modules\Authentication\Eloquents\Contracts\AuthServiceInterface;
use Modules\Authentication\Http\Requests\RegisterRequest;

class RegisterController extends Controller
{
    public function __construct(private readonly AuthServiceInterface $authService)
    {
        parent::__construct();
    }

    public function __invoke(RegisterRequest $request): JsonResponse
    {
        return $this->authService->register($request->validated());
    }
}
