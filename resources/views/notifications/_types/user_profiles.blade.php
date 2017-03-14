<div class="notification full-block bg-white">
   <div class="col-xs-12">
      <a href="{{ url('profile/' . $item->user->id) }}">
         <img class="avatar" src="{{ $item->user->pictureUrl('thumb') }}" width="70px" />
      </a>
      <p>
         <a href="{{ url('profile/' . $item->user->id) }}">{{ $item->full_name }}</a>
         @if(array_get($notification->data, 'type') === 'birthday')
            @lang('notifications.will-have-birthday-in', ['days' => 3]) ({{ $item->birth_date->format('m/d') }})
         @endif
         <span class="notify-date">{{ $notification->date }}</span>
      </p>
   </div>
</div>