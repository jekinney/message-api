<?php

namespace App\Models;

use App\Http\Requests\StoreMessageRequest;
use App\Http\Requests\UpdateMessageRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Pagination\LengthAwarePaginator;

class Message extends Model
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

    public function show(): Model
    {
        return $this->load('comments', 'comments.replies');
    }

    /**
     * Return a message model for editing
     */
    public function edit(): Model
    {
        return $this;
    }

    /**
     * Create a new message
     */
    public function store(StoreMessageRequest $request): Model
    {
        return $this->create([
            'author_id' => $request->user()->id,
            'content' => $request->content,
        ]);
    }

    /**
     * Update a message
     */
    public function renew(UpdateMessageRequest $request): Model
    {
        $this->update(['content' => $request->content]);

        return $this->fresh();
    }

    /**
     * Get a public list of messages
     */
    public function publicList(): LengthAwarePaginator
    {
        return $this->paginate(10);
    }

    /**
     * Toggle soft delete and return
     */
    public function toggleDelete(): Model
    {
        if ($this->trashed()) {
            $this->restore();
        } else {
            $this->delete();
        }

        return $this;
    }
}
