<div class="notification full-block bg-white">
   <div class="col-xs-12">
      <a href="{{ url('album_items/view/' . $item->media->model_id) }}">
         <img class="avatar" src="{{ $item->media->getUrl('thumb') }}" width="70px" />
      </a>
      <p>
         @lang('notifications.you-tagged-on') <a href="{{ url('album_items/view/' . $item->media->model_id) }}">@lang('notifications.image')</a>
         <span class="notify-date">{{ $notification->date }}</span>
      </p>
   </div>
</div>