<?php

namespace Modules\Testmodule\Http\Resources\Second;

use Illuminate\Http\Resources\Json\JsonResource;

class SecondResource extends JsonResource
{
    public function toArray($request): array
    {
        return parent::toArray($request);
    }
}
