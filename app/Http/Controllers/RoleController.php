<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Resources\RoleResource;
use App\Http\Requests\RoleStoreRequest;
use App\Http\Requests\RoleUpdateRequest;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index(Role $role): AnonymousResourceCollection
    {
        return RoleResource::collection($role->adminList());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  RoleStoreRequest $request
     * @param  Role $role
     * @return AnonymousResourceCollection
     */
    public function store(RoleStoreRequest $request, Role $role)
    {
        return new RoleResource($role->store($request));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        return new RoleResource($role->edit());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RoleUpdateRequest $request, Role $role)
    {
        return new RoleResource($role->renew($request));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        return new RoleResource($role->toggleDelete());
    }
}
