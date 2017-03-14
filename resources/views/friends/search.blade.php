@extends('_layouts.home')

@section('content')

   <div class="window-header">
      <a class="window-close" href="#"><i class="fa fa-times"></i></a>
   </div>
   <div class="main-row">
      <div class="left-section col-md-4 pad-big">

         <h2 class="section-title">@lang('friends.search-friends')</h2>
         <div class="search-friends">

            <form action="{{ url('friends/search') }}" method="post" accept-charset="UTF-8">
               {!! csrf_field() !!}
               <div class="form-group has-feedback">
                  <input type="search" placeholder="Enter Keyword" class="form-control" name="keyword" value="{{ request('keyword') }}"/>
                  <span class="fa fa-search form-control-feedback" aria-hidden="true"></span>
               </div>
               <div class="form-group text-right">
                  <button class="btn btn-default">@lang('search.search')</button>
               </div>
            </form>
         </div>

      </div><!-- end left-section of main content -->

      <div class="right-section col-md-8 pad-big">
         <h2 class="section-title">@lang('friends.friends')</h2>

         <div class="friends-boxes grid" id="allfriendslist">

            @forelse($friends as $friend)
               <div class="col-xs-6 col-sm-4 col-md-3">
                  <div class="friend-box">
                     <div class="photo-wrap">
                        <a href="{{ url('profile/' . $friend->id) }}">
                           <img src="{{ $friend->pictureUrl('thumb') }}" class="avatar" width="100%">
                        </a>
                     </div>
                     <div class="fb-footer">
                        <p class="desc text-center">
                           <a href="{{ url('profile/' . $friend->id) }}">{{ $friend->profile->fullName() }}</a>
                        </p>
                     </div>
                  </div>
               </div><!-- end of col-->
            @empty
               <div class="col-xs-12">
                  <p>@lang('friends.no-friends')</p>
               </div>
            @endforelse

         </div><!-- end friends-boxes -->
      </div><!-- end right-section-->
   </div><!-- end row of main-content -->

@endsection
