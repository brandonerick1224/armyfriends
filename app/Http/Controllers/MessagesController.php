<?php

namespace App\Http\Controllers;

use App\Events\MessageEvent;
use App\Http\Requests;
use App\Models\Chat;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;

class MessagesController extends Controller
{
    /**
     * Index page
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $me = \Auth::user();

        return view('messages.index', [
            'chats' => $me->chats,
            'user'  => $me,
        ]);
    }

    /**
     * Send message
     *
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function message(User $user)
    {
        $me = \Auth::user();

        return view('messages.message', [
            'chats' => $me->chats,
            'user'  => $user,
        ]);
    }

    /**
     * Send message
     *
     * @param Request $request
     * @param User    $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function send(Request $request, User $user)
    {
        $this->validate($request, [
            'message' => 'required|max:511',
        ]);

        $me = auth()->user();
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

        return redirect('/messages/chat/' . $user->id)->with('success', trans('chats.message-sent'));
    }

    /**
     * Show chat
     *
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function chat(User $user)
    {
        /** @var User $me */
        $me = auth()->user();
        $chat = Chat::getChat($user);

        if (! $chat) {
            abort(404);
        }

        $chat->see();

        return view('messages.index', [
            'user'     => $user,
            'chat'     => $chat,
            'chats'    => $me->chats()->orderBy('updated_at', 'desc')->get(),
            'messages' => $chat->messages()->orderBy('created_at', 'desc')->take(20)->get()->reverse(),
        ]);
    }

    /**
     * Poll request for new messages
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function poll(Request $request)
    {
        $this->validate($request, [
            'chat_id' => 'required|numeric|exists:chats,id',
            'last_id' => 'required|numeric',
        ]);

        Chat::find($request->get('chat_id'))->see();

        $new_messages = Message::where($request->only(['chat_id']))
            ->where('id', '>', $request->get('last_id'))
            ->orderBy('created_at', 'desc')
            ->take(20)->get()->reverse();

        $data = [];
        foreach ($new_messages as $item) {
            $data[] = [
                'id'         => $item->id,
                'user_name'  => $item->user->full_name,
                'user_image' => $item->user->pictureUrl('thumb'),
                'user_link'  => url('profile/' . $item->user->id),
                'direction'  => $item->mine() ? 'sent' : 'received',
                'message'    => $item->message,
            ];
        }

        return response()->json($data);
    }
}
