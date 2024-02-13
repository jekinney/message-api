<?php

namespace App\Http\Controllers;

use App\Http\Resources\MessageResource;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class MessageController extends Controller
{
    /**
     * List of public messages
     */
    public function index(Request $request, Message $message): AnonymousResourceCollection
    {
        return MessageResource::collection($message->publicList($request));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Message $message): MessageResource
    {
        return new MessageResource($message->store($request));
    }

    /**
     * Data for displaying the message and all comments/replies
     */
    public function show(Message $message): MessageResource
    {
        return new MessageResource($message->show());
    }

    /**
     * Return data needed to update a message.
     */
    public function edit(Message $message): MessageResource
    {
        return new MessageResource($message->edit());
    }

    /**
     * Update the message (patch).
     */
    public function update(Request $request, Message $message): MessageResource
    {
        return new MessageResource($message->renew($request));
    }

    /**
     * Toggle the Message's soft deletes.
     */
    public function destroy(Message $message): MessageResource
    {
        return new MessageResource($message->toggleDelete());
    }
}
