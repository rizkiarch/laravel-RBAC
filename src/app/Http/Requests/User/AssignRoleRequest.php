<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Spatie\Permission\Models\Role;

class AssignRoleRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->user()->hasPermissionTo('manage-users');
    }

    public function rules()
    {
        return [
            'role' => 'required|string|exists:roles,name',
        ];
    }
}
