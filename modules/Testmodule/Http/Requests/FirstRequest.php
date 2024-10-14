<?php

namespace Modules\Testmodule\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FirstRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            //
        ];
    }
}
