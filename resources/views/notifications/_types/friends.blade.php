<div class="notification full-block bg-white">
   <div class="col-xs-12 col-sm-8">
      <a href="{{ url('profile/' . $item->friend_id) }}">
         <img class="avatar" src="{{ $item->friend->pictureUrl('thumb') }}" width="70px" />
      </a>
      <p><a href="{{ url('profile/' . $item->friend_id) }}">{{ $item->friend->profile->fullName() }}</a>
         @if($item->status === 'request')
            @lang('notifications.sent-you-friend-request')
         @elseif($item->status === 'accept')
            @lang('notifications.accepted-friend-request')
         @elseif($item->status === 'refuse'))
         @lang('notifications.refused-friend-request')
         @endif
         <span class="notify-date">{{ $notification->date }}</span>
      </p>
   </div>
   <div class="col-xs-12 col-sm-4 text-right">
      @if($item->status === 'request')
         <a href="{{ url('friends/accept/' . $item->friend_id) }}" class="btn btn-sm btn-success">@lang('friends.accept')</a>
         <a href="{{ url('friends/refuse/' . $item->friend_id) }}" class="btn btn-sm btn-danger">@lang('friends.refuse')</a>
      @elseif($item && $item->status === 'accept')
         <a href="#" disabled="" class="btn btn-sm btn-success">@lang('friends.accepted')</a>
      @elseif($item && $item->status === 'refuse')
         <a href="#" disabled="" class="btn btn-sm btn-danger">@lang('friends.you-refused')</a>
      @elseif($item && $item->status === 'refused')
         <a href="#" disabled="" class="btn btn-sm btn-danger">@lang('friends.refused')</a>
      @endif
   </div>
</div>