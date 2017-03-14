<div class="sidebar right-sidebar">
   <div class="albums-widget widget full-block">
      <div class="widget-header bottom-space">
         <h2 class="section-title ">@lang('albums.albums')</h2>
      </div><!-- end albums widget Header -->
      <div class="widget-body full-block">
         @if(count($albums))
            <ul class="album remove-default">
               @foreach($albums as $album)
                  <li class="col-xs-6">
                     <a href="{{ url('albums/view/' . $album->id) }}"><img src="{{ $album->coverUrl() }}" width="180" height="180" /></a>
                  </li>
               @endforeach
            </ul>
         @else
            <p class="no-albums">@lang('albums.no-albums')</p>
         @endif
      </div><!-- end albums widget body -->
      <div class="widget-footer bg-primary text-center pad-none">
         <a href="{{ url('albums/' . auth()->id()) }}" class="btn btn-flat btn-primary widget-submit">@lang('albums.all-albums')</a>
      </div><!-- end search widget footer -->
   </div><!-- end albums widget  -->
   <div class="onlined-friends widget full-block">
      <div class="widget-header bottom-space">
         <h2 class="section-title ">@lang('friends.online-friends')</h2>
      </div><!-- end onlined-friends widget Header -->
      <div class="widget-body">
         <ul class="user-list remove-default">

            @forelse($friends as $friend)
               <li class="person">
                  <div>
                     <a href="{{ url('profile/' . $friend->id) }}">
                        <img class="avatar" src="{{ $friend->pictureUrl('thumb') }}" width="50" height="50" />
                     </a>
                  </div>
                  <div>
                     <div class="title"><a href="{{ url('profile/' . $friend->id) }}">{{ $friend->profile->fullName() }}</a></div>
                     <span class="desc">{{ $friend->last_online->format('m/d/Y H:i') }}</span>
                  </div>
                  <div class="text-right valign-top">
                     <i class="circle-status online"></i>
                  </div>
               </li>
            @empty
               <p>@lang('friends.no-online-friends')</p>
            @endforelse

         </ul><!-- end user-list -->
      </div><!-- end onlined-friends widget-body -->
   </div><!-- end onlined-friends Widget -->
</div>