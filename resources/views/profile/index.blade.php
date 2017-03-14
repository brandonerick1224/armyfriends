@extends('_layouts.home')

@section('profile-image')
   <a href="{{ url('albums/view/' . data_get($user->profile_album, 'id')) }}">
      <div class="user-img" style="background-image:url('{{ $user->pictureUrl('thumb') }}')"></div>
   </a>
@endsection

@section('content')

   <div class="window-header">
      <a class="window-close" href="#"><i class="fa fa-times"></i></a>
   </div>
   <div class="main-row">
      <div class="left-section col-md-4 pad-big">
         <h2 class="section-title">{{ $user->profile->fullName() }}</h2>
         <div class="properties">

            @include('_blocks.user-info', ['user' => $user])

            <div class="separator"></div>

            @if($friend)
               @if($friend->pivot->status === 'request')
                  <a href="{{ url('friends/accept/' . $user->id) }}" class="btn btn-success">@lang('friends.accept-friend')</a>
               @elseif($friend->pivot->status === 'requested')
                  <a href="#" disabled class="btn btn-primary">@lang('friends.friends-request-sent')</a>
               @elseif($friend->pivot->status === 'refused')
                  <a href="#" disabled="" class="btn btn-danger">@lang('friends.friend-was-refused')</a>
               @elseif($friend->pivot->status === 'refuse')
                  <a href="#" disabled="" class="btn btn-danger">@lang('friends.you-refused-friend')</a>
               @elseif($friend->pivot->status === 'accept')
                  <a href="{{ url('friends/remove/' . $user->id) }}" class="btn btn-danger" onclick="return confirm('Are you sure?')">@lang('friends.unfriend')</a>
               @endif
            @else
               <a href="{{ url('friends/request/' . $user->id) }}" class="btn btn-primary">@lang('friends.add-friend')</a>
            @endif

            @if($user->profile->liked)
               <a href="{{ url('likes/unlike/user_profiles/' . $user->profile->id) }}" class="btn btn-danger"><i class="fa fa-thumbs-o-down"></i> @lang('common.unlike')</a>
            @else
               <a href="{{ url('likes/like/user_profiles/' . $user->profile->id) }}" class="btn btn-success"><i class="fa fa-thumbs-o-up"></i> @lang('common.like')</a>
            @endif

            <br><br>
            @if(\App\Models\Chat::getChat($user))
               <a href="{{ url('messages/chat/' . $user->id) }}" class="btn btn-primary">@lang('chats.send-message')</a>
            @else
               <a href="{{ url('messages/message/' . $user->id) }}" class="btn btn-primary">@lang('chats.send-message')</a>
            @endif

            <br><br>
            <a href="{{ url('albums/' . $user->id) }}" class="btn btn-primary">@lang('albums.see-albums')</a>

         </div><!-- end properties -->
      </div><!-- end left-section of main content -->

      <div class="right-section col-md-8 pad-big">
         <div class="posts" id="profiledata">

            @include('_blocks.posts', ['posts' => $posts])

         </div>
      </div><!-- end right-section-->
   </div><!-- end row of main-content -->

@endsection
