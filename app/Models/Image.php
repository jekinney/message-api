<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Image extends Model
{
    use HasFactory;

    /**
     * Guarded columns from mass assignment
     *
     * @var array<string>
     */
    protected $guarded = ['id'];

    /**
     * Relationship to any model as needed
     */
    public function imageable(): MorphTo
    {
        return $this->morphTo();
    }
}
