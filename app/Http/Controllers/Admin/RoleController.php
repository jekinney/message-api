<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Http\Resources\RoleResource;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class RoleController extends Controller
{
    /**
     * Undocumented function
     */
    public function index(Request $request, Role $role): AnonymousResourceCollection
    {
        return RoleResource::collection($role->adminList($request));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoleRequest $request, Role $role): RoleResource
    {
        return new RoleResource($role->store($request));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function show(Role $role): RoleResource
    {
        return new RoleResource($role->show());
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role): RoleResource
    {
        return new RoleResource($role->edit());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoleRequest $request, Role $role): RoleResource
    {
        return new RoleResource($role->renew($request));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role): RoleResource
    {
        return new RoleResource($role->toggleDelete());
    }
}
