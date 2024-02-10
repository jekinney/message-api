<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoleStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * This is done in guard class only
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
            'slug' => 'required|string|max:35|unique:roles,slug',
            'display_name' => 'required|string|max:35|unique:roles,display_name',
            'description' => 'nullable|string|max:550',
            'permissions' => 'nullable',
            'permissions.*' => 'integer|exists:permissions,id'
        ];
    }
}
