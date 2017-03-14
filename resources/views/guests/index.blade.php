@extends('_layouts.home')

@section('content')

   <div class="window-header">
      <a class="window-close" href="#"><i class="fa fa-times"></i></a>
   </div>
   <div class="main-row">
      <div class="left-section col-md-4 pad-big">

      </div><!-- end left-section of main content -->

      <div class="right-section col-md-8 pad-big">
         <h2 class="section-title">@lang('common.guests')</h2>
         <div class="friends-boxes grid" id="allfriendslist">

            @forelse($guests as $guest)
               <div class="col-xs-6 col-sm-4 col-md-3">
                  <div class="friend-box">
                     <div class="photo-wrap">
                        <a href="{{ url('profile/' . $guest->user->id) }}">
                           <img src="{{ $guest->user->pictureUrl('thumb') }}" class="avatar" width="100%">
                        </a>
                     </div>
                     <div class="fb-footer">
                        <p class="desc text-center">
                           <a href="{{ url('profile/' . $guest->user->id) }}">{{ $guest->user->profile->fullName() }}</a>
                        </p>
                        <p class="fb-date text-center">
                           {{ $guest->updated_at->format('H:i d/m/Y') }}
                        </p>
                     </div>
                  </div>
               </div><!-- end of col-->
            @empty
               <p>@lang('guests.no-guests')</p>
            @endforelse

         </div><!-- end friends-boxes -->
      </div><!-- end right-section-->
   </div><!-- end row of main-content -->

@endsection
