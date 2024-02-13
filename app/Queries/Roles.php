<?php

namespace App\Queries;

use App\Queries\Contracts\EloquentQueries;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class Roles extends EloquentQueries
{
    /**
     * Gather data to edit a role
     */
    public function edit(): Model
    {
        return $this->load('users', 'permissions');
    }

    /**
     * Gather data to display a role
     */
    public function show(): Model
    {
        return $this->load('users', 'permissions');
    }

    /**
     * Create a new role resource
     */
    public function store(Request $request): Model
    {
        $role = $this->create($this->validate($request));

        if ($request->permissions && ! empty($request->permissions)) {
            $role->permissions()->attach($request->permissions);
        }

        if ($request->users && ! empty($request->users)) {
            $role->users()->attach($request->users);
        }

        return $role->load('users', 'permissions');
    }

    /**
     * Update a role resource
     */
    public function renew(Request $request): Model
    {
        $this->update($this->validate($request));

        if ($request->permissions && ! empty($request->permissions)) {
            $this->permissions()->sync($request->permissions);
        }

        if ($request->users && ! empty($request->users)) {
            $this->users()->sync($request->users);
        }

        return $this->fresh()->load('users', 'permissions');
    }

    /**
     * A paginated list for admin users.
     * Includes all roles
     */
    public function adminList(Request $request): LengthAwarePaginator
    {
        return $this->withCount('users', 'permissions')
            ->latest()
            ->paginate($this->amount($request));
    }

    /**
     * Getter to set up validation
     * rules to store new resource
     */
    protected function getStoreRules(): array
    {
        return [
            'slug' => 'required|string|max:35|unique:roles,slug',
            'display_name' => 'required|string|max:35|unique:roles,display_name',
            'description' => 'nullable|string|max:550',
            'users' => 'nullable',
            'users.*' => 'integer|exists:users,id',
            'permissions' => 'nullable',
            'permissions.*' => 'integer|exists:permissions,id',
        ];
    }

    /**
     * Getter to set up validation
     * rules to renew a resource
     */
    protected function getRenewRules(): array
    {
        return [
            'slug' => 'required|string|max:35|unique:roles,id,id,'.$this->id,
            'display_name' => 'required|string|max:35|unique:roles,display_name,id,'.$this->id,
            'description' => 'nullable|string|max:550',
            'permissions' => 'nullable',
            'permissions.*' => 'integer|exists:permissions,id',
        ];
    }
}
