@extends('_layouts.home')

@section('head-bottom')
   <link href="{{ asset('assets/vendor/emoji-picker/css/nanoscroller.css') }}" rel="stylesheet">
   <link href="{{ asset('assets/vendor/emoji-picker/css/emoji.css') }}" rel="stylesheet">
@endsection

@section('content')

   <div class="window-header">
      <a class="window-close" href="#"><i class="fa fa-times"></i></a>
   </div>
   <div class="main-row">
      <div class="left-section col-sm-4 col-xs-12 pad-big">
         <h2 class="section-title">@lang('chats.chats')</h2>

         <ul class="user-list remove-default">

            @if(isset($chats))

               @foreach($chats as $item)
                  <li class="person">
                     <div>
                        <a href="{{ url('messages/chat/' . $item->user->id) }}">
                           <img class="avatar" src="{{ $item->user->pictureUrl('thumb') }}" width="50" height="50" />
                        </a>
                     </div>
                     <div>
                        <div class="title"><a href="{{ url('messages/chat/' . $item->user->id) }}">{{ $item->user->profile->fullName() }}</a></div>
                        <span class="desc"></span>
                        @if(! $item->seen)
                           <span class="badge">@lang('chats.new-message')</span>
                        @endif
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
         <h2 class="section-title">@lang('chats.messages')</h2>


         @if(isset($messages))

            <div class="messages-list" data-chat-id="{{ $chat->id }}" data-last-id="{{ $messages ? $messages->last()->id : 0 }}">

               @foreach($messages as $message)

                  <div class="message {{ $message->mine() ? 'sent' : 'received' }}" id="message-{{ $message->id }}" data-message-id="{{ $message->id }}">
                     @if(! $message->mine())
                        <div class="msg-content">
                           <p>{{ $message->message }}</p>
                        </div>
                     @endif

                     <div class="avatar">
                        <div class="photo-wrap">
                           <a href="{{ url('profile/' . $message->user->id) }}">
                              <img class="photo" src="{{ $message->user->pictureUrl('thumb') }}" width="100%" />
                           </a>
                        </div>
                        <div class="name"><a href="{{ url('profile/' . $message->user->id) }}">{{ $message->user->profile->fullName() }}</a></div>
                     </div>

                     @if($message->mine())
                        <div class="msg-content">
                           <p>{{ $message->message }}</p>
                        </div>
                     @endif
                  </div><!-- end message -->

               @endforeach

            </div><!-- end messages-holder -->

            <div class="message-form">
               <form name="message-form" method="POST" action="{{ url('messages/send/' . $user->id) }}">
                  {{ csrf_field() }}
                  <div class="form-group emoji-picker-container messages-emoji-textarea">
                     <textarea name="message" class="form-control" placeholder="@lang('chats.write-a-message')" rows="4" data-emojiable="true" data-emoji-input="unicode"></textarea>
                  </div>
                  <div class="form-group text-right">
                     <button class="btn btn-default" type="submit">@lang('chats.send')</button>
                  </div>
               </form>
            </div>

         @else
            <p>@lang('chats.select-chat')</p>
         @endif

      </div><!-- end right-section-->
   </div><!-- end row of main-content -->

@endsection

@section('foot')
   <script src="{{ asset('assets/vendor/emoji-picker/js/nanoscroller.min.js') }}"></script>
   <script src="{{ asset('assets/vendor/emoji-picker/js/tether.min.js') }}"></script>
   <script src="{{ asset('assets/vendor/emoji-picker/js/config.js') }}"></script>
   <script src="{{ asset('assets/vendor/emoji-picker/js/util.js') }}"></script>
   <script src="{{ asset('assets/vendor/emoji-picker/js/jquery.emojiarea.js') }}"></script>
   <script src="{{ asset('assets/vendor/emoji-picker/js/emoji-picker.js') }}"></script>
   <script>
      $(function() {
         // Initializes and creates emoji set from sprite sheet
         window.emojiPicker = new EmojiPicker({
            emojiable_selector: '[data-emojiable=true]',
            assetsPath: '{{ asset('assets/vendor/emoji-picker/img/') }}',
            popupButtonClasses: 'fa fa-smile-o'
         });
         // Finds all elements with `emojiable_selector` and converts them to rich emoji input fields
         // You may want to delay this step if you have dynamically created input fields that appear later in the loading process
         // It can be called as many times as necessary; previously converted input fields will not be converted again
         window.emojiPicker.discover();
      });
   </script>
@endsection
