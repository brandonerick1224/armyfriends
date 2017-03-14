@extends('_layouts.home')

@section('head')
   <link rel="stylesheet" href="{{ asset('assets/vendor/mgVideoChat/mgVideoChat-1.10.1.css') }}"/>
@endsection

@section('content')

   <div class="window-header">
      <a class="window-close" href="#"><i class="fa fa-times"></i></a>
   </div>
   <div class="main-row">
      <div id="friends_chat" class=""></div>
   </div><!-- end row of main-content -->

@endsection

@section('foot')
   <script src="{{ asset('assets/vendor/mgVideoChat/mgVideoChat-1.10.1-min.js') }}"></script>
   <script>

      var wsDomain = '';
      var mgChat;
      var rtc;

      var friends_ids = JSON.parse("{{ $user->friends->pluck('id')->toJson() }}");

      if (! wsDomain) {
         wsDomain = document.domain;
      }
      wsPort = 8080;
      wsProtocol = 'ws';
      wsPath = '';

      var forceHttpsDirs = ['desktop_capture'];

      $(document).ready(function() {
         //check https
         var loc = window.location.pathname;
         var dir = loc.substring(loc.lastIndexOf('/') + 1);
         if (! dir) {
            loc = loc.substring(0, loc.length - 1);
            dir = loc.substring(loc.lastIndexOf('/') + 1);
         }
         var forceHttps = forceHttpsDirs.indexOf(dir) > - 1;
         if (forceHttps && window.location.protocol != "https:") {
            window.location.href = "https:" + window.location.href.substring(window.location.protocol.length);
         }
         //https traffic
         if (window.location.protocol == "https:") {
            wsProtocol = 'wss';
            wsPort = '443';
            wsPath = '/wss/';
         }
         wsUrlDefault = wsProtocol + '://' + wsDomain + ':' + wsPort + wsPath;

         mgChat = $('#friends_chat').mgVideoChat({
            wsURL: wsUrlDefault + '?room=9',
            debug: false
         });

         $('#friends_chat').mgVideoChat('on', 'connections', function(connections) {

            if (typeof connections !== "undefined" && Object.keys(connections).length > 0) {
               for (var connectionId in connections) {
                  var loggedin_userdata = connections[connectionId].data.userData;
                  var loggedin_user_id = loggedin_userdata.id;

                  if (friends_ids.indexOf(loggedin_user_id) === - 1) {
                     $('#connection_' + connectionId).remove();

                     if ($('#connections li').length == 0) {
                        $("#lonely").show();
                     }
                  }
               }
            }

            if (Object.keys(connections).length == 0) {
               if ($('#connections li').length == 0) {
                  $("#lonely").show();
               }
            }
         });
      })
   </script>
@endsection