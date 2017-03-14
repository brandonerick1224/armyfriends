@extends('_layouts.home')

@section('content')

   <div class="window-header">
      <a class="window-close" href="#"><i class="fa fa-times"></i></a>
   </div>
   <div class="main-row">
      <div class="left-section col-sm-4 col-xs-12 pad-big">

         <h2 class="section-title">@lang('chats.chats')</h2>

         <ul class="user-list remove-default">

            @if(isset($chats))

               @foreach($chats as $chat)
                  <li class="person">
                     <div>
                        <a href="{{ url('messages/chat/' . $chat->user->id) }}">
                           <img class="avatar" src="{{ $chat->user->pictureUrl('thumb') }}" width="50" height="50" />
                        </a>
                     </div>
                     <div>
                        <div class="title"><a href="{{ url('messages/chat/' . $chat->user->id) }}">{{ $chat->user->profile->fullName() }}</a></div>
                        <span class="desc"></span>
                     </div>
                  </li>
               @endforeach

            @else
               <li>
                  <p>@lang('chats.no-chats')</p>
               </li>
            @endif

         </ul><!-- end user-list -->

      </div><!-- end left-section of main content -->

      <div class="right-section col-sm-8 col-xs-12 pad-big">
         <h2 class="section-title">@lang('chats.send-message-to') {{ $user->profile->fullName() }}</h2>

         <div class="message-form">
            <form name="message-form" method="POST" action="{{ url('messages/send/' . $user->id) }}">
               {{ csrf_field() }}
               <div class="form-group">
                  <textarea name="message" class="form-control" placeholder="@lang('chats.write-a-message')" rows="4"></textarea>
               </div>
               <div class="form-group text-right">
                  <button class="btn btn-default" type="submit">@lang('chats.send')</button>
               </div>
            </form>
         </div>
      </div><!-- end right-section-->
   </div><!-- end row of main-content -->

@endsection
