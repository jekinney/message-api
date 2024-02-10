<?php

namespace App\Models;

use App\Http\Requests\MessageCreateRequest;
use App\Http\Requests\MessageUpdateRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
        'body' => 'json'
    ];

    /**
     * Guarded columns from mass assignment
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * Relationship to the User Model
     *
     * @return BelongsTo
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id', 'id')->select('id', 'display_name');
    }

    /**
     * Create a new message
     *
     * @param  MessageCreateRequest $request
     * @return Model
     */
    public function store(MessageCreateRequest $request): Model
    {
        return $this->create([
            'author_id' => $request->user()->id,
            'body' => $request->body
        ]);
    }

    /**
     * Update a message
     *
     * @param  MessageUpdateRequest $request
     * @return Model
     */
    public function renew(MessageUpdateRequest $request): Model
    {
        $this->update(['body' => $request->body]);

        return $this->fresh();
    }

    /**
     * Get a public list of messages
     *
     * @return LengthAwarePaginator
     */
    public function publicList(): LengthAwarePaginator
    {
        return $this->paginate(10);
    }

    /**
     * Toggle soft delete and return
     *
     * @return Model
     */
    public function toggleDelete(): Model
    {
        if ( $this->trashed() ) {
            $this->restore();
        } else {
            $this->delete();
        }

        return $this;
    }
}
