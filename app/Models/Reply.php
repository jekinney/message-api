<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reply extends Model
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

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id', 'id')
            ->select('id', 'display_name');
    }

    /**
     * Relationship to the Comment Model
     */
    public function comment(): BelongsTo
    {
        return $this->belongsTo(Comment::class);
    }
}
