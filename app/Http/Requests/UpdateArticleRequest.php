<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateArticleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = auth('sanctum')->user();

        if ($user->hasPerm('admin-update-articles')) {
            return true;
        }

        return $user->hasPerm('update-articles') && $user->isAuthor($this->article);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'slug' => 'required|string|unique:articles,slug,id,'.$this->article->id,
            'title' => 'required|string|unique:articles,title,id,'.$this->article->id,
            'content' => 'required|string',
            'published_at' => 'nullable|date',
            'allow_comments' => 'nullable|boolean',
        ];
    }
}
