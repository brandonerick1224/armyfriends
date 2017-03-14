<div class="sidebar left-sidebar">
   <div class="search-widget widget">
      <form id="search_form" name="search_form" method="get" action="{{ url('search') }}">
         <div class="widget-header bottom-space">
            <h2 class="section-title ">@lang('search.search')</h2>
         </div><!-- search widget Header -->
         <div class="widget-body">
            <div class="form-group">
               <input type="text" class="form-control" id="search_name" name="name" value="{{ request('name') }}" placeholder="@lang('search.user-name')">
            </div>
            <div class="form-group">
               <input type="text" class="form-control" name="first_name" value="{{ request('first_name') }}" placeholder="@lang('profile.first-name')">
            </div>
            <div class="form-group">
               <input type="text" class="form-control" name="last_name" value="{{ request('last_name') }}" placeholder="@lang('profile.last-name')">
            </div>
            <h2 class="section-title">@lang('search.date-of-service')</h2>
            <div class="form-group">
               <input type="text" class="form-control datepicker" id="search_start_date" name="start_date" value="{{ request('start_date') }}" placeholder="@lang('search.start-date') (mm/dd/yyyy)">
            </div>
            <div class="form-group">
               <input type="text" class="form-control datepicker" id="search_end_date"  name="end_date" value="{{ request('end_date') }}" placeholder="@lang('search.end-date') (mm/dd/yyyy)">
            </div>
            <div class="form-group">
               <input type="city" class="form-control" id="search_city" name="city" value="{{ request('city') }}"  placeholder="@lang('common.city')">
            </div>
            <div class="form-group">
               {!! Form::select('country', $countries, request('country'), ['class' => 'form-control', 'placeholder' => trans('common.country')], true) !!}
            </div>
         </div><!-- end search widget-body -->
         <div class="widget-footer bg-primary text-center pad-none">
            <button type="submit" id="btn-search" class="btn btn-flat btn-primary widget-submit">@lang('search.submit-search')</button>
         </div><!-- end search widget footer -->
      </form>
   </div><!-- end search widget -->

   <div class="suggested-users widget">
      <div class="widget-header bottom-space">
         <h2 class="section-title ">@lang('common.do-you-know-them')</h2>
      </div><!-- suggested-users widget Header -->
      <div class="widget-body">
         <ul class="user-list remove-default">

            @forelse($users as $user)
               <li class="person">
                  <div>
                     <a href="{{ url('profile/' . $user->id) }}">
                        <img class="avatar" src="{{ $user->pictureUrl('thumb') }}" width="50" height="50" />
                     </a>
                  </div>
                  <div>
                     <div class="title"><a href="{{ url('profile/' . $user->id) }}">{{ $user->profile->fullName() }}</a></div>
                     {{--<span class="desc">Lorem ipsum dolor sit amet.</span>--}}
                  </div>
                  <div class="text-right">
                     <?php $friend = auth()->user()->friend($user); ?>

                     @if($friend)
                        @if($friend->pivot->status === 'request')
                           <a href="{{ url('friends/accept/' . $user->id) }}" class="btn btn-success">@lang('friends.accept-friend')</a>
                        @elseif($friend->pivot->status === 'requested')
                           <a href="#" disabled class="btn btn-primary">@lang('friends.request-sent')</a>
                        @elseif($friend->pivot->status === 'refused')
                           <a href="#" disabled="" class="btn btn-danger">@lang('friends.refused')</a>
                        @elseif($friend->pivot->status === 'refuse')
                           <a href="#" disabled="" class="btn btn-danger">@lang('friends.you-refused')</a>
                        @elseif($friend->pivot->status === 'accept')
                           <a href="{{ url('friends/remove/' . $user->id) }}" class="btn btn-danger">@lang('friends.unfriend')</a>
                        @endif
                     @else
                        <a href="{{ url('friends/request/' . $user->id) }}" class="btn btn-primary">@lang('friends.add-friend')</a>
                     @endif

                  </div>
               </li>
            @empty
               <p>@lang('common.no-people-found')</p>
            @endforelse

         </ul><!-- end user-list -->
      </div><!-- end suggested-users widget-body -->
   </div><!-- end suggested-users Widget -->
</div>