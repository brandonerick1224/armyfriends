@extends('_layouts.home')

@section('content')

   <div class="window-header">
      <a class="window-close" href="#"><i class="fa fa-times"></i></a>
   </div>
   <div class="main-row">
      <div class="left-section col-md-4 pad-big">

         <h2 class="section-title">@lang('groups.search-groups')</h2>
         <div class="search-friends">
            <form action="{{ url('groups/search') }}" method="post">
               {{ csrf_field() }}
               <div class="form-group has-feedback">
                  <input type="search" placeholder="Enter Name" class="form-control" name="query" value="{{ request('query') }}" />
                  <span class="fa fa-search form-control-feedback" aria-hidden="true"></span>
               </div>
               <div class="form-group text-right">
                  <button type="submit" class="btn btn-default">@lang('common.search')</button>
               </div>
            </form>
         </div>

         <h2 class="section-title">@lang('groups.invites')</h2>

         @foreach($user->groups_invites as $group)
            <div class="person">
               <div>
                  <a href="{{ url('groups/view/' . $group->id) }}">
                     <img class="avatar" src="{{ $group->getFirstMediaUrl('cover', 'thumb') }}" width="50" height="50">
                  </a>
               </div>
               <div>
                  <div class="title"><a href="{{ url('groups/view/' . $group->id) }}">{{ $group->title }}</a></div>
                  <a href="{{ url('group_user/accept/' . $group->pivot->id) }}" class="btn btn-xs btn-success">@lang('groups.accept')</a>
                  <a href="{{ url('group_user/refuse/' . $group->pivot->id) }}" class="btn btn-xs btn-danger">@lang('groups.refuse')</a>
               </div>
            </div>
         @endforeach

         <h2 class="section-title">@lang('groups.requests')</h2>

         @foreach($user->groups_requests as $group)
            <div class="person">
               <div>
                  <a href="{{ url('groups/view/' . $group->id) }}">
                     <img class="avatar" src="{{ $group->getFirstMediaUrl('cover', 'thumb') }}" width="50" height="50">
                  </a>
               </div>
               <div>
                  <div class="title"><a href="{{ url('groups/view/' . $group->id) }}">{{ $group->title }}</a></div>
               </div>
            </div>
         @endforeach

         <br>
         <a href="{{ url('groups/create') }}" class="btn btn-primary">@lang('groups.create-new-group')</a>

      </div><!-- end left-section of main content -->

      <div class="right-section col-md-8 pad-big">
         <h2 class="section-title">@lang('groups.my-groups')</h2>
         <div class="friends-boxes grid" id="allfriendslist">

            @forelse($groups as $group)
               <div class="col-xs-6 col-sm-4 col-md-3">
                  <div class="friend-box">
                     <div class="photo-wrap">
                        <a href="{{ url('groups/view/' . $group->id) }}">
                           <img src="{{ $group->getFirstMediaUrl('cover', 'thumb') }}" class="avatar" width="100%">
                        </a>
                     </div>
                     <div class="fb-footer">
                        @if($group->isAdmin())
                           <div class="pull-right">
                              <a href="{{ url('groups/edit/' . $group->id) }}"><i class="fa fa-pencil"></i></a>
                           </div>
                        @endif
                        <p class="desc text-center">
                           <a href="{{ url('groups/view/' . $group->id) }}">{{ $group->title }}</a>
                        </p>
                     </div>
                  </div>
               </div><!-- end of col-->
            @empty
               <div class="col-xs-12">
                  <p>@lang('groups.no-groups')</p>
               </div>
            @endforelse

         </div><!-- end friends-boxes -->
      </div><!-- end right-section-->
   </div><!-- end row of main-content -->

@endsection
