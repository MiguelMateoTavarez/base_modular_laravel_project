<?php

namespace Modules\Testmodule\Http\Requests\Second;

use Illuminate\Foundation\Http\FormRequest;

class SecondRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            //
        ];
    }
}
