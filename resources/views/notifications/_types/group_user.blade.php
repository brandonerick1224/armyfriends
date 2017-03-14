<div class="notification full-block bg-white">
   <div class="col-xs-12 col-sm-8">
      <a href="{{ url('profile/' . $item->user->id) }}">
         <img class="avatar" src="{{ $item->user->pictureUrl('thumb') }}" width="70px" />
      </a>
      <p>
         @if($item->user_id === $user->id)
            @if($item->status === 'accept')
               @lang('notifications.you-accepted-to-join')
            @else
               @lang('notifications.you-invited-to-join')
            @endif
            @lang('notifications.the-group') <a href="{{ url('groups/view/' . $item->group_id) }}">{{ $item->group->title }}</a>
         @else
            <a href="{{ url('profile/' . $item->user->id) }}">{{ $item->user->profile->fullName() }}</a>
            @if($item->status === 'accept')
               @lang('notifications.joined')
            @elseif($item->status === 'request')
               @lang('groups.requested-to-join')
            @endif
            <a href="{{ url('groups/view/' . $item->group_id) }}">{{ $item->group->title }}</a>
         @endif
         <span class="notify-date">{{ $notification->date }}</span>
      </p>
   </div>
   <div class="col-xs-12 col-sm-4 text-right">
      @if($item->status === 'request')
         @can('add-users', $item->group)
         <a href="{{ url('group_user/approve/' . $item->id) }}" class="btn btn-sm btn-success">@lang('groups.approve')</a>
         <a href="{{ url('group_user/decline/' . $item->id) }}" class="btn btn-sm btn-danger">@lang('groups.decline')</a>
         @endcan
      @elseif($item->status === 'invite')
         <a href="{{ url('group_user/accept/' . $item->id) }}" class="btn btn-sm btn-success">@lang('groups.accept')</a>
         <a href="{{ url('group_user/refuse/' . $item->id) }}" class="btn btn-sm btn-danger">@lang('groups.refuse')</a>
      @endif
   </div>
</div>