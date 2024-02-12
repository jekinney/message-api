<?php

namespace App\Http\Controllers;

use App\Http\Resources\MessageResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function messages(Request $request)
    {
        return MessageResource::collection($request->user()->getMessages($request));
    }

    /**
     * Store a new user (register).
     */
    public function store(Request $request, User $user)
    {
        $user->store($request);

        return response()->json('201',
            "{$user->display_name} was created and will need to confirm email before being able to login."
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return new UserResource($user->show());
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return new UserResource($user->edit());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        return new UserResource($user->renew($request));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user = $user->remove();

        return response()->json('201',
            "{$user->display_name} has been set for deletion along with any messages they have after email confirmation."
        );
    }
}
