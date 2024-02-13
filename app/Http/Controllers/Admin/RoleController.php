<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\RoleResource;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class RoleController extends Controller
{
    /**
     * Admin list of Roles
     *
     * @param Request $request
     * @param Role $role
     * @return AnonymousResourceCollection
     */
    public function index(Request $request, Role $role): AnonymousResourceCollection
    {
        return RoleResource::collection($role->adminList($request));
    }

    /**
     * Create a new role
     *
     * @param  Request $request
     * @param  Role $role
     * @return RoleResource
     */
    public function store(Request $request, Role $role): RoleResource
    {
        return new RoleResource($role->store($request));
    }

    /**
     * Role data to display
     *
     * @param  Role $role
     * @return RoleResource
     */
    public function show(Role $role): RoleResource
    {
        return new RoleResource($role->show());
    }

    /**
     * Role data to edit a role
     *
     * @param  Role $role
     * @return RoleResource
     */
    public function edit(Role $role): RoleResource
    {
        return new RoleResource($role->edit());
    }

    /**
     * Update a role
     *
     * @param  Request $request
     * @param  Role $role
     * @return RoleResource
     */
    public function update(Request $request, Role $role): RoleResource
    {
        return new RoleResource($role->renew($request));
    }

    /**
     * Attempt to remove a role
     *
     * @param Role $role
     * @return RoleResource
     */
    public function destroy(Role $role): RoleResource
    {
        return new RoleResource($role->toggleDelete());
    }
}
