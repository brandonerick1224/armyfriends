@extends('_layouts.home')

@section('content')

   <div class="window-header">
      <a class="window-close" href="#"><i class="fa fa-times"></i></a>
   </div>
   <div class="main-row">
      <div class="left-section col-md-4 pad-big">

      </div><!-- end left-section of main content -->

      <div class="right-section col-md-8 pad-big">
         <h2 class="section-title">
            @lang('common.liked-users')
            <a href="{{ $model->getUrl() }}">
               @if($model->getTable() === 'posts')
                  @lang('notifications.post')
               @elseif($model->getTable() === 'user_profiles')
                  @lang('notifications.profile')
               @elseif($model->getTable() === 'album_items')
                  @lang('notifications.image')
               @endif
            </a>
         </h2>
         <div class="friends-boxes grid" id="allfriendslist">

            @forelse($model->likes as $like)
               <div class="col-xs-6 col-sm-4 col-md-3">
                  <div class="friend-box">
                     <div class="photo-wrap">
                        <a href="{{ url('profile/' . $like->user->id) }}">
                           <img src="{{ $like->user->pictureUrl('thumb') }}" class="avatar" width="100%">
                        </a>
                     </div>
                     <div class="fb-footer">
                        <p class="desc text-center">
                           <a href="{{ url('profile/' . $like->user->id) }}">{{ $like->user->profile->fullName() }}</a>
                        </p>
                        <p class="fb-date text-center">
                           {{ $like->created_at->format('H:i d/m/Y') }}
                        </p>
                     </div>
                  </div>
               </div><!-- end of col-->
            @empty
               <div class="col-xs-12">
                  <p>@lang('common.no-likes')</p>
               </div>
            @endforelse

         </div><!-- end friends-boxes -->
      </div><!-- end right-section-->
   </div><!-- end row of main-content -->

@endsection
