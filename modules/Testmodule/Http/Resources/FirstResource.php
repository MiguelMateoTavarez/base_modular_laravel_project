<?php

namespace Modules\Testmodule\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FirstResource extends JsonResource
{
    public function toArray($request): array
    {
        return parent::toArray($request);
    }
}
