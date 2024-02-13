<?php

namespace App\Models;

use App\Queries\Messages;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Messages
{
    use HasFactory, SoftDeletes;

    protected $with = ['author'];

    /**
     * Ensure proper casting of column data type
     *
     * @var array
     */
    protected $casts = [
        'is_private' => 'boolean',
        'allow_comments' => 'boolean',
    ];

    /**
     * Guarded columns from mass assignment
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * Eager load relations count(s)
     *
     * @var array
     */
    protected $withCount = ['likes', 'favorites'];

    /**
     * Relationship to the Like Model
     */
    public function likes(): MorphMany
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    /**
     * Relationship to the User Model
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id', 'id')
            ->select('id', 'display_name');
    }
}
