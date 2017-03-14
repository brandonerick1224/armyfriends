@extends('_layouts._master')

@section('body')

   <header>
      @include('_blocks.nav')
      @include('_blocks.flash')
      @include('_blocks.home-banner')
   </header>

   <section class="content mainlayout">

      @include('_sidebars.left')

      <div class="main-container">
         <div class="main-home-content bg-gray">

            @yield('content')

         </div>
      </div>

      @include('_sidebars.right')

   </section>

   <footer>
      @include('_blocks.footer')
   </footer>

@endsection