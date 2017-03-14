<?php

namespace App\Http\Controllers\Api;

use App\Events\MessageEvent;
use App\Http\Requests;
use App\Models\Chat;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    /**
     * Get chats
     *
     * @param Request $request
     * @return \App\Http\Responses\ApiResponse
     */
    public function chats(Request $request)
    {
        /** @var User $me */
        $me = auth()->user();

        $chats = $me->chats()->take(30)->skip($request->get('offset', 0))->get();

        return api_response(['chats' => $chats->map(function (Chat $chat) {
            return $chat->getListData();
        })]);
    }

    /**
     * Get chat
     *
     * @param Request $request
     * @return \App\Http\Responses\ApiResponse
     */
    public function chat(Request $request)
    {
        $this->validate($request, [
            'chat_id' => 'required_without:user_id|integer|exists:chats,id',
            'user_id' => 'required_without:chat_id|integer|exists:users,id',
        ]);

        /** @var User $me */
        $me = auth()->user();

        if ($request->get('user_id')) {
            $chat = Chat::getChat(User::find($request->get('user_id')));
        } else {
            $chat = Chat::find($request->get('chat_id'));
        }
        /** @var Chat $chat */

        if (! $chat || ($chat->user_one_id !== $me->id && $chat->user_two_id !== $me->id)) {
            throw new ModelNotFoundException;
        }

        $chat->see();

        return api_response(['chat' => $chat ? $chat->getFullData($request->get('offset', 0)) : null]);
    }

    /**
     * Send message
     *
     * @param Request $request
     * @return \App\Http\Responses\ApiResponse
     */
    public function send(Request $request)
    {
        $this->validate($request, [
            'user_id' => 'required|exists:users,id',
            'message' => 'required|max:511',
        ]);

        /** @var User $me */
        $me = auth()->user();
        
        $user = User::find($request->get('user_id'));

        $chat = Chat::getChat($user);
        if (! $chat) {
            $chat = Chat::create([
                'user_one_id' => $me->id,
                'user_two_id' => $user->id,
            ]);
        }

        $message = $chat->messages()->create([
            'user_id' => $me->id,
            'message' => strip_tags($request->get('message')),
        ]);

        event(new MessageEvent($message, $user));

        return api_response();
    }
}
