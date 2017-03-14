@extends('_layouts.home')

@section('content')

   <div class="window-header">
      <a class="window-close" href="#"><i class="fa fa-times"></i></a>
   </div>
   <div class="main-row">
      <div class="left-section col-md-4 pad-big">

         <h2 class="section-title">@lang('albums.albums')</h2>

         @include('_blocks.albums-list', ['albums' => $albums])

         @if($user->isMe())
            <a href="{{ url('albums/create') }}" class="btn btn-primary">@lang('albums.add-new-album')</a>
         @endif

      </div><!-- end left-section of main content -->

      <div class="right-section col-md-8 pad-big">
         <h2 class="section-title">@lang('albums.images')</h2>

         <div class="friends-boxes grid" id="allfriendslist">

            <p>@lang('albums.select-album')</p>

         </div><!-- end friends-boxes -->
      </div><!-- end right-section-->
   </div><!-- end row of main-content -->

@endsection
