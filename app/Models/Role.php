<?php

namespace App\Models;

use App\Queries\Roles;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;

class Role extends Roles
{
    use HasFactory;

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_seeded' => 'boolean',
    ];

    /**
     * Guarded columns from mass assignment
     *
     * @var array<string, string>
     */
    protected $guarded = ['id'];

    /**
     * Relationship to the User Model
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)
            ->withTimestamps();
    }

    /**
     * Relationship to the User Model
     * and returns a collection of
     * user ids assigned to a
     * role
     */
    public function userIds(): Collection
    {
        return $this->belongsToMany(User::class)
            ->withTimestamps()
            ->pluck('users.id');
    }

    /**
     * Relationship to the Permission Model
     */
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class)
            ->withTimestamps();
    }

    /**
     * Relationship to the Permission Model
     * and returns a collection of
     * permission ids assigned to
     * a role
     */
    public function permissionIds(): Collection
    {
        return $this->belongsToMany(Permission::class)
            ->withTimestamps()
            ->pluck('permissions.id');
    }
}
