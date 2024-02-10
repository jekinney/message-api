<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Relationship to the Role Model
     *
     * @return BelongsToMany
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class)
                ->withTimestamps();
    }

    /**
     * Relationship to the Message Model
     *
     * @return HasMany
     */
    public function messages(): HasMany
    {
        return $this->hasMany(Message::class, 'author_id', 'id');
    }

    /**
     * Check a user's permissions for a specific slug
     *
     * @param string $slug
     * @return boolean
     */
    public function hasPerm(string $slug): bool
    {
        return $this->permissionsList()->contains('slug', $slug);
    }

    /**
     * Check if a user is the author of a message
     *
     * @param  Message $message
     * @return boolean
     */
    public function isAuthor(Message $message): bool
    {
        return $this->id === $message->author_id;
    }

    /**
     * Get a collection of a user's unique assigned permissions
     *
     * @return Collection
     */
    public function permissionsList(): Collection
    {
        $perms = $this->roles->map( function($role) {
            return $role->permissions;
        })->flatten()
        ->unique();

        return $perms;
    }
}
