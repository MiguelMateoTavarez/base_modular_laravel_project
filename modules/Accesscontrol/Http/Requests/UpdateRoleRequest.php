<?php

namespace Modules\Accesscontrol\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRoleRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:100|unique:roles,name,'.$this->route('id'),
            'description' => 'string'
        ];
    }
}
