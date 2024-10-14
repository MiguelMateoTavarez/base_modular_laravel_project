<?php

namespace Modules\Accesscontrol\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\API\Responses\ApiResponseService;
use Modules\Accesscontrol\Http\Resources\PermissionResource;
use Modules\Accesscontrol\Models\Permission;

class PermissionController extends Controller
{
    public function __invoke()
    {
        return ApiResponseService::success([
            PermissionResource::collection(Permission::all()),
            'Permissions retrieved successfully',
        ]);
    }
}
