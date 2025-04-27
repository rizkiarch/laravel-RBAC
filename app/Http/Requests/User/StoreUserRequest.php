<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Spatie\Permission\Models\Role;

class StoreUserRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->user()->hasPermissionTo('manage-users');
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role' => 'sometimes|string|exists:roles,name',
        ];
    }
}
