<?php

namespace App\Models;

use App\Http\Requests\RoleStoreRequest;
use App\Http\Requests\RoleUpdateRequest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
     *
     * @return BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)
                ->withTimestamps();
    }

    /**
     * Relationship to the Permission Model
     *
     * @return BelongsToMany
     */
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class)
                ->withTimestamps();
    }

    /**
     * Get data to edit a role resource
     *
     * @return Model
     */
    public function edit(): Model
    {
        return $this->load('users', 'permissions');
    }

    public function store(RoleStoreRequest $request): Model
    {
        $role = $this->create([
            'slug' => $request->slug,
            'description' => $request->description,
            'display_name' => $request->display_name
        ]);

        if ( $request->permissions && !empty($request->permissions) ) {
            $role->permissions()->attach($request->permissions);
        }

        if ( $request->users && !empty($request->users) ) {
            $role->users()->attach($request->users);
        }

        return $role->load('users', 'permissions');
    }

    public function renew(RoleUpdateRequest $request): Model
    {
        $this->update([
            'slug' => $request->slug,
            'description' => $request->description,
            'display_name' => $request->display_name
        ]);

        if ( $request->permissions && !empty($request->permissions) ) {
            $this->permissions()->sync($request->permissions);
        }

        if ( $request->users && !empty($request->users) ) {
            $this->users()->sync($request->users);
        }

        return $this->fresh()->load('users', 'permissions');
    }

    /**
     * Admin list of all roles and permissions
     *
     * @return LengthAwarePaginator
     */
    public function adminList(): LengthAwarePaginator
    {
        return $this->withCount('permissions')->paginate(10);
    }
}
