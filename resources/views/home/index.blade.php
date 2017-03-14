@extends('_layouts.home')

@section('content')

   <div class="window-header">
      <a class="window-close" href="#"><i class="fa fa-times"></i></a>
   </div>
   <div class="main-row">
      <div class="left-section col-md-4 pad-big">
         <h2 class="section-title">{{ $user->profile->fullName() }}</h2>
         <div class="properties">

            @include('_blocks.user-info', ['user' => $user])

         </div><!-- end properties -->
      </div><!-- end left-section of main content -->

      <div class="right-section col-md-8 pad-big">

         @include('_blocks.post-form')

         <div class="posts" id="profiledata">

            @include('_blocks.posts', ['posts' => $posts])

         </div>
      </div><!-- end right-section-->
   </div><!-- end row of main-content -->

@endsection
