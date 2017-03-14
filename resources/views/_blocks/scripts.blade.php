<script>
   var app = {
      url: '{{ env('APP_URL') }}',
      userId: {{ auth()->id() ?: 'null' }},
      socket: {
         url: '{{ env('SOCKET_IO_URL') }}',
         token: '{{ data_get(auth()->user(), 'socket_token') }}',
      },
      notification_sound: '{{ asset('assets/sounds/message.aac') }}',
   };
   var trans = {!!  App\Miscellaneous\FrontEndTranslations::json() !!};
</script>

<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/vendor/jquery-ui/jquery-ui.min.js') }}"></script>
<script src="{{ asset('assets/vendor/slick/slick.min.js') }}"></script>
<script src="{{ asset('assets/vendor/fancybox/jquery.fancybox.pack.js') }}"></script>
<script src="{{ asset('assets/vendor/select2/js/select2.full.min.js') }}"></script>
<script src="{{ asset('assets/vendor/notifyjs/notify.js') }}"></script>
<script src="{{ asset('assets/vendor/socket-io/socket.io.js') }}"></script>
<script src="{{ asset('assets/js/notifications.js') }}"></script>

<script src="{{ asset('assets/js/vendor.js') }}"></script>
<script src="{{ asset('assets/js/bundle.js') }}"></script>
<script src="{{ asset('assets/js/app.js') }}"></script>