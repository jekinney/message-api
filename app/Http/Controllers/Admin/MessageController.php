<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\MessageResource;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class MessageController extends Controller
{
    /**
     * Admin list of messages
     *
     * @param  Request $request
     * @param  Message $message
     * @return AnonymousResourceCollection
     */
    public function index(Request $request, Message $message): AnonymousResourceCollection
    {
        return MessageResource::collection($message->adminList($request));
    }

    /**
     * Return message for displaying
     *
     * @param  Message $message
     * @return MessageResource
     */
    public function show(Message $message): MessageResource
    {
        return new MessageResource($message->show());
    }

    /**
     * Return message to edit
     *
     * @param  Message $message
     * @return MessageResource
     */
    public function edit(Message $message): MessageResource
    {
        return new MessageResource($message->edit());
    }

    /**
     * Admin update a message
     *
     * @param  Request $request
     * @param  Message $message
     * @return MessageResource
     */
    public function update(Request $request, Message $message): MessageResource
    {
        return new MessageResource($message->renew($request));
    }

    /**
     * Remove a message
     *
     * @param  Request $request
     * @param  Message $message
     * @return MessageResource
     */
    public function destroy(Request $request, Message $message): MessageResource
    {
        return new MessageResource($message->remove($request));
    }
}
