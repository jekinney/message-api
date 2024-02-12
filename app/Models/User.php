<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Pagination\LengthAwarePaginator;
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
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class)
            ->withTimestamps();
    }

    /**
     * Relationship to the Message Model
     */
    public function messages(): HasMany
    {
        return $this->hasMany(Message::class, 'author_id', 'id');
    }

    // News/blog relationships
    /**
     * Relationship to Like Model
     */
    public function likes(): HasMany
    {
        return $this->hasMAny(Like::class);
    }

    /**
     * Relationship to the Comment Model
     * Get a user's comments that are
     * replies to other comments
     */
    public function replies(): HasMany
    {
        return $this->hasMany(Comment::class, 'author_id', 'id')
            ->whereNotNull('parent_comment_id');
    }

    /**
     * Relationship to the Comment Model
     * Get a user's comments NOT
     * replies to other comments
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class, 'author_id', 'id')
            ->whereNull('parent_comment_id');
    }

    /**
     * Relationship tot the Article Class
     */
    public function articles(): HasMany
    {
        return $this->hasMany(Article::class, 'author_id', 'id');
    }

    /**
     * Relationship to the Favorite Class
     */
    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class);
    }

    /**
     * Check a user's permissions for a specific slug
     */
    public function hasPerm(string $slug): bool
    {
        return $this->permissionsList()->contains('slug', $slug);
    }

    /**
     * Check a user's permissions for an array of slugs
     * if all is true, we need all perms to return true
     *
     * @param  array  $slug
     * @param  bool  $all
     */
    public function hasPerms(array $slugs, $all = false): bool
    {
        // Get the user's permissions before the loop. Reduce load.
        $perms = $this->permissionsList();
        // Loop over slugs
        foreach ($slugs as $slug) {
            // If we only need one to pass, return early if true
            if (! $all && $perms->contains('slug', $slug)) {
                return true;
            } elseif ($all && ! $perms->contains('slug', $slug)) {
                return false;
            }
        }

        // If we got this far, the user has all required permissions
        return true;
    }

    /**
     * Check if a user is the author of
     * some type of data like a
     * Comment, Message, Article
     */
    public function isAuthor(object $class): bool
    {
        return $this->id === $class->author_id;
    }

    /**
     * Get a paginated list of a user's messages
     * Including soft deleted messages too
     */
    public function getMessages(Request $request): LengthAwarePaginator
    {
        return $this->messages()
            ->withTrashed()
            ->latest()
            ->paginate($request->amount ?? 10);
    }

    /**
     * Get a collection of a user's unique assigned permissions
     */
    public function permissionsList(): Collection
    {
        $perms = $this->roles->map(function ($role) {
            return $role->permissions;
        })->flatten()
            ->unique();

        return $perms;
    }
}
