<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
   <meta name="viewport" content="width=device-width, initial-scale=1">

   <title>@yield('title')</title>
   <meta name="description" content="@yield('description')">

   <meta id="meta-csrf-token" name="csrf-token" content="{{ csrf_token() }}" />

   @yield('head')

   <link rel="stylesheet" href="{{ asset('assets/vendor/fancybox/jquery.fancybox.css') }}" />
   <link rel="stylesheet" href="{{ asset('assets/vendor/jquery-ui/jquery-ui.min.css') }}" />
   <link rel="stylesheet" href="{{ asset('assets/vendor/slick/slick.css') }}" />
   <link rel="stylesheet" href="{{ asset('assets/vendor/select2/css/select2.min.css') }}" />
   <link href='https://fonts.googleapis.com/css?family=Roboto:400,100' rel='stylesheet' type='text/css' />

   <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.css') }}" />
   <link rel="stylesheet" href="{{ asset('assets/css/vendor.css') }}" />
   <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}" />

   <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
   <script>jQuery.ajaxSetup({headers: {'X-CSRF-TOKEN': $('#meta-csrf-token').attr('content')}});</script>

   @yield('head-bottom')

</head>
<body>

@yield('body')

@include('_blocks.scripts')

@yield('foot')

</body>
</html>
