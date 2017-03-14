@extends('_layouts.home')

@section('content')

   <div class="window-header">
      <a class="window-close" href="#"><i class="fa fa-times"></i></a>
   </div>
   <div class="main-row">
      <div class="left-section col-md-4 pad-big">
         <ul class="vsubmenu comments-vsubmenu remove-default">
            <li>
               <a href="#">Participated</a>
            </li>
            <li>
               <a href="#">My</a>
            </li>
         </ul>

         <h2 class="section-title">Commented Items</h2>

         <ul class="user-list remove-default">

            @foreach($comments as $comment)
               <li class="person">
                  <div>
                     @if($comment->commentable_type === 'posts')
                        <a href="{{ url('profile/' . $comment->commentable->user_id) }}">
                     @elseif($comment->commentable_type === 'album_items')
                        <a href="{{ url('album_items/view/' . $comment->commentable_id) }}">
                     @endif
                        <img class="avatar" src="{{ $comment->commentable->user->pictureUrl('thumb') }}" width="50" height="50">
                     </a>
                  </div>
                  <div>
                     <div class="title">
                        @if($comment->commentable_type === 'posts')
                           <a href="{{ url('album_items/view/' . $comment->commentable_id) }}">Post</a>
                        @elseif($comment->commentable_type === 'album_items')
                           <a href="{{ url('album_items/view/' . $comment->commentable_id) }}">Image</a>
                        @endif
                     </div>
                     <span class="desc">By: <a href="{{ url('profile/' . $comment->commentable->user_id) }}">{{ $comment->commentable->user->profile->fullName() }}</a></span>
                  </div>
               </li>
            @endforeach

         </ul>

      </div><!-- end left-section of main content -->

      <div class="right-section col-md-8 pad-big">
         <h2 class="section-title">Comments</h2>
         <ul class="messages-holder">
            <li class="message">
               <div class="avatar">
                  <div class="photo-wrap">
                     <img class="" src="assets/img/avatar.jpg" width="70" />
                  </div>
                  <div>Testing</div>
               </div>
               <div class="msg-content">
                  <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa.</p>
               </div>
            </li>
            <li class="message received">
               <div class="msg-content">
                  <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa.</p>
               </div>
               <div class="avatar">
                  <div class="photo-wrap">
                     <img class="" src="assets/img/avatar.jpg" width="70" />
                  </div>
                  <div>Testing</div>
               </div>
            </li>
            <li class="message received">
               <div class="msg-content">
                  <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa.</p>
               </div>
               <div class="avatar">
                  <div class="photo-wrap">
                     <img class="" src="assets/img/avatar.jpg" width="70" />
                  </div>
                  <div>Testing</div>
               </div>
            </li>
         </ul><!-- end message-holder-->
         <div class="message-form">
            <div class="form-group">
               <textarea class="form-control" rows="4" placeholder="Write a Comment"></textarea>
            </div>
            <div class="form-group text-right">
               <button class="btn btn-default" >Send</button>
            </div>
         </div>
      </div><!-- end right-section-->
   </div><!-- end row of main-content -->

@endsection
