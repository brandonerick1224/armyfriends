@extends('_layouts._master')

@section('body')

   <header>
      @include('_blocks.nav')
   </header>

   @yield('content')

@endsection