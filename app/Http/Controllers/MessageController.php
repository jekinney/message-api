<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMessageRequest;
use App\Http\Requests\UpdateMessageRequest;
use App\Http\Resources\MessageResource;
use App\Models\Message;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Message $message): AnonymousResourceCollection
    {
        return MessageResource::collection($message->publicList());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMessageRequest $request, Message $message): MessageResource
    {
        return new MessageResource($message->store($request));
    }

    /**
     * Data for displaying the message and all comments/replies.
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
     *
     * @return MessageResource
     */
    public function update(UpdateMessageRequest $request, Message $message)
    {
        return new MessageResource($message->renew($request));
    }

    /**
     * Toggle the Message's soft deletes.
     *
     * @return MessageResource
     */
    public function destroy(Message $message)
    {
        return new MessageResource($message->toggleDelete());
    }
}
