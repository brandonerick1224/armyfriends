<!DOCTYPE html>
<!--[if IE 8]>
<html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]>
<html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en" xmlns="http://www.w3.org/1999/html"> <!--<![endif]-->
<head>
   <title>Armyfriends API Documentation</title>
   <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
   <link rel="stylesheet" href="<?= url('assets/docs/bootstrap/css/bootstrap.min.css') ?>"/>
   <link rel="stylesheet" href="<?= url('assets/docs/bootstrap/css/bootstrap-responsive.min.css') ?>"/>
   <link rel="stylesheet" href="<?= url('assets/docs/bootstrap/css/bootstrap-overrides.css') ?>"/>
   <link rel="stylesheet" href="<?= url('assets/docs/font-awesome/css/font-awesome.min.css') ?>"/>
   <!--[if IE 7]>
   <link rel="stylesheet" href="<?= url('assets/docs/font-awesome/css/font-awesome-ie7.min.css') ?>">
   <![endif]-->
   <!--[if lt IE 9]>
   <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
   <![endif]-->
   <link rel="stylesheet" href="<?= url('assets/docs/default/css/api.css') ?>"/>
</head>
<body>

<div class="navbar navbar-inverse">
   <div class="navbar-inner">
      <div class="container-fluid">
         <a class="brand" href="">Armyfriends API Documentation</a>
      </div>
   </div>
</div>
<div id="sidebar">
   <ul>

      <li class="has-sub">
         <a href="#user">
            <i class="icon-book"></i>
            <span class="title">User</span>
            <span class="arrow"></span>
         </a>
         <ul class="sub">
            <li class=""><a href="#connect_socket">Connect to socket</a></li>
            <li class=""><a href="#user_register">Register</a></li>
            <li class=""><a href="#user_login">Log in</a></li>
            <li class=""><a href="#user_forgot">Forgot password</a></li>
            <li class=""><a href="#user_logout">Log out</a></li>
            <li class=""><a href="#user_my_info">My info</a></li>
            <li class=""><a href="#user_my_guests">My guests</a></li>
            <li class=""><a href="#user_user_info">User info</a></li>
            <li class=""><a href="#user_update_profile">Update Profile</a></li>
            <li class=""><a href="#user_search">Search user</a></li>
         </ul>
      </li>

      <li class="has-sub">
         <a href="#message">
            <i class="icon-book"></i>
            <span class="title">Messages</span>
            <span class="arrow"></span>
         </a>
         <ul class="sub">
            <li class=""><a href="#message_chats">Chats list</a></li>
            <li class=""><a href="#message_chat">Show chat</a></li>
            <li class=""><a href="#message_send">Send message</a></li>
         </ul>
      </li>

      <li class="has-sub">
         <a href="#friend">
            <i class="icon-book"></i>
            <span class="title">Friends</span>
            <span class="arrow"></span>
         </a>
         <ul class="sub">
            <li class=""><a href="#friend_list">Friends list</a></li>
            <li class=""><a href="#friend_request">Friend request</a></li>
            <li class=""><a href="#friend_accept">Accept friend</a></li>
            <li class=""><a href="#friend_refuse">Refuse friend</a></li>
            <li class=""><a href="#friend_remove">Remove friend</a></li>
            <li class=""><a href="#friend_search">Search friends</a></li>
         </ul>
      </li>

      <li class="has-sub">
         <a href="#album">
            <i class="icon-book"></i>
            <span class="title">Albums</span>
            <span class="arrow"></span>
         </a>
         <ul class="sub">
            <li class=""><a href="#album_list">List albums</a></li>
            <li class=""><a href="#album_create">Create album</a></li>
            <li class=""><a href="#album_update">Update album</a></li>
            <li class=""><a href="#album_remove">Remove album</a></li>
         </ul>
      </li>

      <li class="has-sub">
         <a href="#album_item">
            <i class="icon-book"></i>
            <span class="title">Album items</span>
            <span class="arrow"></span>
         </a>
         <ul class="sub">
            <li class=""><a href="#album_item_list">List items</a></li>
            <li class=""><a href="#album_item_show">Show item</a></li>
            <li class=""><a href="#album_item_upload">Upload</a></li>
            <li class=""><a href="#album_item_update">Update</a></li>
            <li class=""><a href="#album_item_remove">Remove</a></li>
            <li class=""><a href="#album_item_as_profile">Set as profile</a></li>
            <li class=""><a href="#album_item_tag">Tag user</a></li>
            <li class=""><a href="#album_item_untag">Untag user</a></li>
         </ul>
      </li>

      <li class="has-sub">
         <a href="#notification">
            <i class="icon-book"></i>
            <span class="title">Notifications</span>
            <span class="arrow"></span>
         </a>
         <ul class="sub">
            <li class=""><a href="#notification_status">Status</a></li>
            <li class=""><a href="#notification_list">List</a></li>
         </ul>
      </li>

      <li class="has-sub">
         <a href="#post">
            <i class="icon-book"></i>
            <span class="title">Posts</span>
            <span class="arrow"></span>
         </a>
         <ul class="sub">
            <li class=""><a href="#post_list">List posts</a></li>
            <li class=""><a href="#post_show">Show post</a></li>
            <li class=""><a href="#post_create">Create post</a></li>
            <li class=""><a href="#post_update">Update post</a></li>
            <li class=""><a href="#post_remove">Remove post</a></li>
         </ul>
      </li>

      <li class="has-sub">
         <a href="#comment">
            <i class="icon-book"></i>
            <span class="title">Comments</span>
            <span class="arrow"></span>
         </a>
         <ul class="sub">
            <li class=""><a href="#comment_list">List comments</a></li>
            <li class=""><a href="#comment_create">Create comment</a></li>
            <li class=""><a href="#comment_update">Update comment</a></li>
            <li class=""><a href="#comment_remove">Remove comment</a></li>
         </ul>
      </li>

      <li class="has-sub">
         <a href="#like">
            <i class="icon-book"></i>
            <span class="title">Likes</span>
            <span class="arrow"></span>
         </a>
         <ul class="sub">
            <li class=""><a href="#like_list">List likes</a></li>
            <li class=""><a href="#like_like">Like</a></li>
            <li class=""><a href="#like_unlike">Unlike</a></li>
         </ul>
      </li>

      <li class="has-sub">
         <a href="#group">
            <i class="icon-book"></i>
            <span class="title">Groups</span>
            <span class="arrow"></span>
         </a>
         <ul class="sub">
            <li class=""><a href="#group_my">My groups</a></li>
            <li class=""><a href="#group_search">Search groups</a></li>
            <li class=""><a href="#group_show">Show group</a></li>
            <li class=""><a href="#group_create">Create group</a></li>
            <li class=""><a href="#group_update">Update group</a></li>
            <li class=""><a href="#group_remove">Remove group</a></li>
            <li class=""><a href="#group_join">Join group</a></li>
            <li class=""><a href="#group_leave">Leave group</a></li>
            <li class=""><a href="#group_invite">Invite to group</a></li>
         </ul>
      </li>

      <li class="has-sub">
         <a href="#group_user">
            <i class="icon-book"></i>
            <span class="title">Group users</span>
            <span class="arrow"></span>
         </a>
         <ul class="sub">
            <li class=""><a href="#group_user_approve">Approve request</a></li>
            <li class=""><a href="#group_user_decline">Decline request</a></li>
            <li class=""><a href="#group_user_cancel">Cancel invitation</a></li>
            <li class=""><a href="#group_user_accept">Accept invitation</a></li>
            <li class=""><a href="#group_user_refuse">Refuse invitation</a></li>
            <li class=""><a href="#group_user_update">Update group user</a></li>
            <li class=""><a href="#group_user_remove">Remove group user</a></li>
         </ul>
      </li>

   </ul>
</div>

<div class="content">
   <div class="container-fluid">

      <h1>General info</h1>
      <h2>Authentification</h2>
      <p>
         You will get api_token response on successfull login, this will be permanent authentification token
         that you need to use on every request, it can be passed to server either as post form field "api_token"
         or as header "Authorization" with value "Bearer {api_token_here}" or header "PHP_AUTH_PW". In this docs
         it will be also set automatically to all requests after login method is launched.
      </p>

      @include('+api._sections.user')
      @include('+api._sections.message')
      @include('+api._sections.friend')
      @include('+api._sections.album')
      @include('+api._sections.album_item')
      @include('+api._sections.notification')
      @include('+api._sections.post')
      @include('+api._sections.comment')
      @include('+api._sections.like')
      @include('+api._sections.group')
      @include('+api._sections.group_user')

   </div>
</div>
<div class="footer">
   2016
</div>

<script>
   app_settings = {
      socket_io_port: {{ env('SOCKET_IO_PORT') }},
   };
</script>

<script>
   var app = {
      url: '{{ env('APP_URL') }}',
      socket: {
         url: '{{ env('SOCKET_IO_URL') }}',
      },
   };
</script>

<script src="<?= url('assets/docs/bootstrap/js/jquery.js') ?>"></script>
<script src="<?= url('assets/docs/bootstrap/js/bootstrap.min.js') ?>"></script>
<script src="<?= url('assets/docs/default/js/hash.js') ?>"></script>
<script src="<?= url('assets/docs/default/js/Base64.js') ?>"></script>
<script src="{{ asset('assets/vendor/socket-io/socket.io.js') }}"></script>
<script src="<?= url('assets/docs/default/js/api.js') ?>"></script>
</body>
</html>
