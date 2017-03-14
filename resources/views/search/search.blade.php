@extends('_layouts.home')

@section('content')

   <div class="window-header">
      <a class="window-close" href="#"><i class="fa fa-times"></i></a>
   </div>
   <div class="main-row">
      <div class="left-section col-md-4 pad-big">

      </div><!-- end left-section of main content -->

      <div class="right-section col-md-8 pad-big">
         <h2 class="section-title">@lang('search.search')</h2>

         <div class="friends-boxes grid" id="allfriendslist">

            @forelse($profiles as $profile)
               <div class="col-xs-6 col-sm-4 col-md-3">
                  <div class="friend-box">
                     <div class="photo-wrap">
                        <a href="{{ url('profile/' . $profile->user->id) }}">
                           <img src="{{ $profile->user->pictureUrl('thumb') }}" class="avatar" width="100%">
                        </a>
                     </div>
                     <p class="desc text-center">
                        <a href="{{ url('profile/' . $profile->user->id) }}">{{ $profile->fullName() }}</a>
                     </p>
                  </div>
               </div><!-- end of col-->
            @empty
               <div class="col-xs-12">
                  <p>@lang('search.nothing-found')</p>
               </div>
            @endforelse

         </div><!-- end friends-boxes -->
      </div><!-- end right-section-->
   </div><!-- end row of main-content -->

@endsection
