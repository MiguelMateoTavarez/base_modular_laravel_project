<?php

namespace Modules\Accesscontrol\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRoleRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:100|unique:roles',
            'description' => 'string',
        ];
    }
}
