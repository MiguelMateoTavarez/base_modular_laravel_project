<?php

namespace Modules\Testmodule\Http\Requests\Second\Third;

use Illuminate\Foundation\Http\FormRequest;

class ThirdRequest extends FormRequest
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
