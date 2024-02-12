<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class Article extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Always eager load relationships
     *
     * @var array
     */
    protected $with = ['author'];

    /**
     * Guarded columns from mass assignment
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * Relationship to the Like Model
     */
    public function likes(): HasMany
    {
        return $this->hasMany(Like::class);
    }

    /**
     * Relationship to User Model
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id', 'id')
            ->select('id', 'display_name');
    }

    /**
     * Relationship to Image Model
     */
    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    /**
     * Relationship to the Comment Model
     */
    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    /**
     * Relationship to Favorite Model
     */
    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class);
    }

    /**
     * Get data to show an article
     */
    public function show(): Model
    {
        return $this->load('comments');
    }

    /**
     * Get data to edit an article
     */
    public function edit(): Model
    {
        return $this->loadCount('comments');
    }

    /**
     * Get a list of all articles even
     * deleted and un-published
     */
    public function adminList(Request $request): LengthAwarePaginator
    {
        return $this->withTrashed()->paginate($request->amount ?? 10);
    }

    /**
     * Get a list of published articles for
     * all users and guests to read
     */
    public function publicList(Request $request): LengthAwarePaginator
    {
        return $this->withCount('comments')
            ->where('published_at', '<', Carbon::now())
            ->paginate($request->amount ?? 10);
    }
}
