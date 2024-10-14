<?php

namespace Modules\Testmodule\Http\Resources\Second\Third;

use Illuminate\Http\Resources\Json\JsonResource;

class ThirdResource extends JsonResource
{
    public function toArray($request): array
    {
        return parent::toArray($request);
    }
}
