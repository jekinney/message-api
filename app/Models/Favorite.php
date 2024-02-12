<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Favorite extends Model
{
    use HasFactory;

    /**
     * Guarded columns from mass assignment
     *
     * @var array<string>
     */
    protected $guarded = ['id'];

    /**
     * Relationship tot he User Model
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship to Article Model
     */
    public function favoriteable(): MorphTo
    {
        return $this->morphTo();
    }
}
