<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Spatie\Permission\Models\Role;

class UpdateUserRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->user()->hasPermissionTo('manage-users');
    }

    public function rules()
    {
        return [
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|string|email' . $this->route('id'),
            'role' => 'sometimes|string|exists:roles,name',
        ];
    }
}
