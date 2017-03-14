<div class="notification full-block bg-white">
   <div class="col-xs-12">
      <a href="{{ url('profile/' . $item->user->id) }}">
         <img class="avatar" src="{{ $item->user->pictureUrl('thumb') }}" width="70px" />
      </a>
      <p>
         <a href="{{ url('profile/' . $item->user->id) }}">{{ $item->user->profile->fullName() }}</a>
         @lang('notifications.liked-your')
         @if($item->likeable_type === 'album_items')
            <a href="{{ url('album_items/view/' . $item->likeable_id) }}">@lang('notifications.image')</a>
         @elseif($item->likeable_type === 'user_profiles')
            @lang('notifications.profile')
         @elseif($item->likeable_type === 'posts')
            <a href="{{ url('posts/view/' . $item->likeable_id) }}">@lang('notifications.post')</a>
         @endif
         <span class="notify-date">{{ $notification->date }}</span>
      </p>
   </div>
</div>