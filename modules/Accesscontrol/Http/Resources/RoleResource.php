<?php

namespace Modules\Accesscontrol\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class RoleResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => Str::title($this->description),
            'permissions' => PermissionResource::collection($this->whenLoaded('permissions')),
        ];
    }
}
