<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreArticleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = auth('sanctum')->user();

        return $user->hasPerms(['admin-create-articles', 'create-articles']);

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'slug' => 'required|string|unique:articles,slug',
            'title' => 'required|string|unique:articles,title',
            'content' => 'required|string',
            'published_at' => 'nullable|date',
            'allow_comments' => 'nullable|boolean',
        ];
    }
}
