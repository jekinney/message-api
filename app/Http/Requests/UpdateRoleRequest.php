<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRoleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'slug' => 'required|string|max:35|unique:roles,id',
            'display_name' => 'required|string|max:35|unique:roles',
            'description' => 'nullable|string|max:550',
            'permissions' => 'nullable',
            'permissions.*' => 'integer|exists:permissions,id',
        ];
    }
}
