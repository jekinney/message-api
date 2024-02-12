<?php

namespace App\Models;

use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class Role extends Model
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

    /**
     * Get data to edit a role resource
     */
    public function edit(): Model
    {
        return $this->load('users', 'permissions');
    }

    /**
     * Get data to show a role resource
     */
    public function show(): Model
    {
        return $this->load('users', 'permissions');
    }

    /**
     * Create a new role. Data already validated
     */
    public function store(StoreRoleRequest $request): Model
    {
        $role = $this->create([
            'slug' => $request->slug,
            'description' => $request->description,
            'display_name' => $request->display_name,
        ]);

        if ($request->permissions && ! empty($request->permissions)) {
            $role->permissions()->attach($request->permissions);
        }

        if ($request->users && ! empty($request->users)) {
            $role->users()->attach($request->users);
        }

        return $role->load('users', 'permissions');
    }

    /**
     * Update a role. Data already validated
     */
    public function renew(UpdateRoleRequest $request): Model
    {
        $this->update([
            'slug' => $request->slug,
            'description' => $request->description,
            'display_name' => $request->display_name,
        ]);

        if ($request->permissions && ! empty($request->permissions)) {
            $this->permissions()->sync($request->permissions);
        }

        if ($request->users && ! empty($request->users)) {
            $this->users()->sync($request->users);
        }

        return $this->fresh()->load('users', 'permissions');
    }

    /**
     * Admin list of all roles and permissions
     */
    public function adminList(): LengthAwarePaginator
    {
        return $this->withCount('permissions')->paginate(10);
    }
}
