<?php

namespace App\Queries;

use App\Queries\Contracts\EloquentQueries;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class Messages extends EloquentQueries
{
    /**
     * Gather data to display a role
     */
    public function show(): Model
    {
        return $this->load('comments', 'comments.replies');
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
     * Admin to force delete or toggle delete
     */
    public function remove(Request $request): bool|Model
    {
        if ($request->destroy) {
            return $this->forceDelete();
        }

        return $this->toggleDelete();
    }

    /**
     * Allow users to toggle soft deletes
     */
    public function toggleDelete(): Model
    {
        if ($this->trashed()) {
            $this->restore();
        } else {
            $this->delete();
        }

        return $this;
    }

    /**
     * Getter to set up validation
     * rules to store new resource
     */
    protected function getStoreRules(): array
    {
        return [
            'content' => 'required|string',
        ];
    }

    /**
     * Getter to set up validation
     * rules to renew a resource
     */
    protected function getRenewRules(): array
    {
        return [
            'content' => 'required|string',
        ];
    }
}
