<?php

namespace App\Models;

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
     * Get a public list of messages
     *
     * @return LengthAwarePaginator
     */
    public function publicList(): LengthAwarePaginator
    {
        return $this->paginate(10);
    }
}
