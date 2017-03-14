<?php

namespace App\Http\Controllers;

use App\Events\NotificationEvent;
use App\Http\Requests;
use App\Models\AlbumItem;
use App\Models\Media;
use App\Models\User;
use App\Models\UserTag;
use Illuminate\Http\Request;

class UserTagController extends Controller
{
    /**
     * Tag user on picture
     *
     * @param Request   $request
     * @param AlbumItem $albumItem
     * @return \Illuminate\Http\JsonResponse
     */
    public function tag(Request $request, AlbumItem $albumItem)
    {
        /** @var User $me */
        $me = auth()->user();

        $this->validate($request, [
            'user_id' => 'required|exists:users,id',
            'x'       => 'numeric|between:0,1',
            'y'       => 'numeric|between:0,1',
        ]);

        $this->authorize($albumItem);
        $userId = $request->get('user_id');

        /** @var User $user */
        $user = $me->friends()->where('users.id', $userId)->first();
        if (! $user) {
            if ($me->id == $userId) {
                $user = $me;
            } else {
                return response()->json([
                    'result'  => 'error',
                    'message' => 'You can tag only your friends or yourself!',
                ]);
            }
        }

        /** @var Media $itemMedia */
        $itemMedia = $albumItem->getFirstMedia();
        if (! $itemMedia) {
            abort(500, 'No media for item.');
        }
        /** @var UserTag $userTag */
        $userTag = $itemMedia->user_tags()->create($request->only('user_id', 'x', 'y'));

        // Send notification to user, if it's not me
        if (! $user->isMe()) {
            event(new NotificationEvent($userTag, $user));
        }

        return response()->json([
            'result'   => 'ok',
            'message'  => 'You successfully tagged user',
            'tag'      => $userTag->getData(),
        ]);
    }

    /**
     * Untag user from picture
     *
     * @param UserTag $userTag
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function untag(UserTag $userTag)
    {
        $this->authorize($userTag);

        $userTag->delete();

        return response()->json(['result' => 'ok', 'message' => 'You successfully untagged user']);
    }

    /**
     * Get users for tagging
     */
    public function users()
    {
        /** @var User $me */
        $me = auth()->user();

        $data = [];
        foreach ($me->friends->merge([$me]) as $friend) {
            $data[] = [
                'id' => $friend->id,
                'text' => $friend->full_name,
            ];
        }

        return response()->json($data);
    }
}
