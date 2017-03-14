<div class="notification full-block bg-white">
   <div class="col-xs-12">
      <a href="{{ url('profile/' . $item->user->id) }}">
         <img class="avatar" src="{{ $item->user->pictureUrl('thumb') }}" width="70px" />
      </a>
      <p>
         <a href="{{ url('profile/' . $item->user->id) }}">{{ $item->user->profile->fullName() }}</a>
         @lang('notifications.commented-on')
         @if($item->commentable_type === 'album_items')
            <a href="{{ $item->commentable->getUrl() }}">@lang('notifications.image')</a>
         @elseif($item->commentable_type === 'posts')
            <a href="{{ $item->commentable->getUrl() }}">@lang('notifications.post')</a>
         @endif
         <span class="notify-date">{{ $notification->date }}</span>
      </p>
   </div>
</div>