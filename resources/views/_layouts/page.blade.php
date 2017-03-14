@extends('_layouts._master')

@section('body')

   <header>
      @include('_blocks.nav')
      @include('_blocks.front-banner')
   </header>

   <section class="content">
      <div class="container">
         <div class="main-content bg-gray">

            @yield('content')

         </div>
      </div>
   </section>

   <footer>
      @include('_blocks.footer')
   </footer>

@endsection