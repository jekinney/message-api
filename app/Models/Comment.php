<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class Comment extends Model
{
    use HasFactory;

    /**
     * Always eager load relationships
     *
     * @var array
     */
    protected $with = ['author'];

    /**
     * Guarded columns from mass assignment
     *
     * @var array<string>
     */
    protected $guarded = ['id'];

    /**
     * Relationship to User Model
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id', 'id');
    }

    /**
     * Relationship to Reply Model
     */
    public function replies(): HasMany
    {
        return $this->hasMany(Comment::class, 'parent_comment_id', 'id');
    }

    /**
     * Allow comments to any model as needed
     */
    public function commentable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Gather a user's comments and return paginated list
     */
    public function userList(Request $request): LengthAwarePaginator
    {
        return $request->user()
            ->comments()
            ->with('commentable')
            ->paginated($request->amount ?? 20);
    }

    /**
     * Gather a user's comments and return paginated list
     */
    public function adminList(Request $request): LengthAwarePaginator
    {
        return $this->with('commentable')->paginated($request->amount ?? 20);
    }
}
