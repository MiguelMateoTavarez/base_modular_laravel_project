<?php

namespace Modules\Accesscontrol\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\API\Responses\ApiResponseService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Accesscontrol\Eloquents\Contracts\RoleInterface;
use Modules\Accesscontrol\Http\Requests\StoreRoleRequest;
use Modules\Accesscontrol\Http\Requests\UpdateRoleRequest;
use Modules\Accesscontrol\Http\Resources\RoleResource;

class RoleController extends Controller
{
    public function __construct(
        private readonly RoleInterface $roleInterfaceService
    ) {
        parent::__construct();
    }

    public function index()
    {
        return ApiResponseService::success(
            RoleResource::collection($this->roleInterfaceService->index()),
            'Roles retrieved successfully'
        );
    }

    public function store(StoreRoleRequest $request)
    {
        return ApiResponseService::success(
            new RoleResource($this->roleInterfaceService->store($request->validated())),
            'Role created successfully',
        );
    }

    public function show($id)
    {
        return ApiResponseService::success(
            new RoleResource($this->roleInterfaceService->show($id)),
            'Role retrieved successfully'
        );
    }

    public function update(UpdateRoleRequest $request, string $id)
    {
        return ApiResponseService::success(
            new RoleResource($this->roleInterfaceService->update($request->validated(), $id)),
            'Role updated successfully',
        );
    }

    public function destroy($id)
    {
        return ApiResponseService::success(
            new RoleResource($this->roleInterfaceService->destroy($id)),
            'Role deleted successfully',
        );
    }

    public function attachPermissions(string $id, Request $request): JsonResponse
    {
        $request->validate([
            'permissions' => 'required|array',
            'permissions.*' => 'integer',
        ]);

        return ApiResponseService::success(
            new RoleResource($this->roleInterfaceService->attachPermissions($id, current($request->all()))),
            'Permissions added successfully',
        );
    }

    public function detachPermissions(string $id, Request $request): JsonResponse
    {
        $request->validate([
            'permissions' => 'required|array',
            'permissions.*' => 'integer',
        ]);

        return ApiResponseService::success(
            new RoleResource($this->roleInterfaceService->detachPermissions($id, current($request->all()))),
            'Permissions removed successfully',
        );
    }
}
