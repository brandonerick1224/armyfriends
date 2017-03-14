<!-- banner -->
<section class="banner mainpage-banner">
   <div class="container">
      <div class="main-menu-container text-center">
         <ul class="main-menu">
            <li>
               <a href="{{ url('messages') }}" class="btn-primary{{ Request::is('messages') ? ' active' : '' }}"  data-toggle="tooltip" data-placement="top" id="messages-link" title="Messages"><i class="fa fa-envelope"></i>
                  @if($chats_count)
                     <span class="menu-alert">{{ $chats_count }}</span>
                  @endif
               </a>
            </li>
            <li>
               <a href="{{ url('friends') }}" class="btn-primary{{ Request::is('friends') ? ' active' : '' }}"  data-toggle="tooltip" data-placement="top" id="friends-link" title="Friends"><i class="fa fa-fw fa-user"></i>
                  @if($friends_requests_count)
                     <span class="menu-alert">{{ $friends_requests_count }}</span>
                  @endif
               </a>
            </li>
            <li>
               <a href="{{ url('notifications') }}" class="btn-primary{{ Request::is('notifications') ? ' active' : '' }}" data-toggle="tooltip" data-placement="top" id="notifications-link" title="Notification"><i class="fa fa-fw fa-bell"></i>
                  @if($notifications_count)
                     <span class="menu-alert">{{ $notifications_count }}</span>
                  @endif
               </a>
            </li>
            <li>
               <a href="{{ url('home') }}" class="btn-primary{{ Request::is('home') ? ' active' : '' }}" data-toggle="tooltip" data-placement="top"  id="home-link" title="Home"><i class="fa fa-fw fa-home"></i></a>
            </li>
            <li>
               <a href="{{ url('groups') }}" class="btn-primary{{ Request::is('groups') ? ' active' : '' }}"  data-toggle="tooltip" data-placement="top" id="discussions-link" title="Discussions"><i class="fa fa-fw fa-group"></i></a>
            </li>
            <li>
               <a href="{{ url('guests') }}" class="btn-primary{{ Request::is('guests') ? ' active' : '' }}"  data-toggle="tooltip" data-placement="top" id="guests-link" title="Guests"><i class="fa fa-fw fa-eye"></i></a>
            </li>
            <li>
               <a href="{{ url('video-chat') }}" class="btn-primary{{ Request::is('video-chat') ? ' active' : '' }}"  data-toggle="tooltip" data-placement="top" id="videos-link" title="Video calls"><i class="fa fa-fw fa-video-camera"></i></a>
            </li>
         </ul>

         @if (View::hasSection('profile-image'))
            @yield('profile-image')
         @else
            <a href="{{ url('albums/view/' . data_get(Auth::user()->profile_album, 'id')) }}">
               <div class="user-img" style="background-image:url('{{ Auth::user()->pictureUrl('thumb') }}')"></div>
            </a>
         @endif
      </div>
   </div>
</section>
<!-- end banner -->