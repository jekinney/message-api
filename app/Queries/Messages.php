<?php

namespace App\Queries;

use App\Queries\Contracts\EloquentQueries;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class Messages extends EloquentQueries
{
    /**
     * Data to display a message
     *
     * @return Model
     */
    public function show(): Model
    {
        return $this->load('comments', 'comments.replies');
    }

    /**
     * Store a new message
     *
     * @param  Request $request
     * @return Model
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

        return $role->load('comments', 'comments.replies');
    }

    /**
     * Update a message
     *
     * @param  Request $request
     * @return Model
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

        return $this->fresh()->load('comments', 'comments.replies');
    }

    /**
     * A paginated list for admin users.
     * Includes all roles
     *
     * @param  Request $request
     * @return LengthAwarePaginator
     */
    public function adminList(Request $request): LengthAwarePaginator
    {
        return $this->withCount('comments', 'comments.replies')
            ->latest()
            ->paginate($this->amount($request));
    }

    /**
     * Admin to force delete or toggle delete
     *
     * @param  Request $request
     * @return boolean|Model
     */
    public function remove(Request $request): bool|Model
    {
        if ($request->destroy) {
            return $this->forceDelete();
        }

        return $this->toggleDelete();
    }

    /**
     * Allow Author to toggle soft deletes
     *
     * @return Model
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
     *
     * @return array
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
     *
     * @return array
     */
    protected function getRenewRules(): array
    {
        return [
            'content' => 'required|string',
        ];
    }
}
