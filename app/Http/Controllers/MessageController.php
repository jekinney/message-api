<?php

namespace App\Http\Controllers;

use App\Http\Requests\MessageCreateRequest;
use App\Models\Message;
use Illuminate\Http\Request;
use App\Http\Resources\MessageResource;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Message $message)
    {
        return MessageResource::collection($message->publicList());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MessageCreateRequest $request, Message $message)
    {
        return new MessageResource($message->store($request));
    }

    /**
     * Display the specified resource.
     */
    public function show(Message $message)
    {
        return new MessageResource($message->show());
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Message $message)
    {
        return new MessageResource($message->edit());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Message $message)
    {
        return new MessageResource($message->renew($request));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Message $message)
    {
        return new MessageResource($message->toggleDelete());
    }
}
