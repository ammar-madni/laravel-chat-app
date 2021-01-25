<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use App\Events\NewChatMessage;

class ConversationController extends Controller
{
    public function topics( Request $request ) {
        return Conversation::all();
    }

    public function messages( Request $request, $topicId ) {
        return Message::where('topic_id', $topicId)
            ->with('user')
            ->orderByDesc('created_at')
            ->get();
    }

    public function newMessage ( Request $request, $topicId ) {
        $newMessage = new Message;
        $newMessage->user_id = Auth::id();
        $newMessage->topic_id = $topicId;
        $newMessage->message = $request->message;
        $newMessage->save();

        broadcast(new NewChatMessage( $newMessage ))->toOthers();

        return $newMessage;

    }
}
