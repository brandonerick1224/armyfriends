@extends('_layouts.page')

@section('title', 'Armyfriends')
@section('description', 'Armyfriends web site description')

@section('content')

   <h2 class="section-title">@lang('front.latest-updates')</h2>

   <!-- Latest Updates slider -->
   <div class="slick-slider latest-updates">

      <div class="slide-item col-md-4">
         <div class="article-box">
            <div id="startappContainer-1"></div>
         </div><!-- end article-box -->
      </div> <!-- end col-md-4 -->

      <div class="slide-item col-md-4">
         <div class="article-box">
            <div id="startappContainer-2"></div>
         </div><!-- end article-box -->
      </div> <!-- end col-md-4 -->

      <div class="slide-item col-md-4">
         <div class="article-box">
            <div id="startappContainer-3"></div>
         </div><!-- end article-box -->
      </div> <!-- end col-md-4 -->

   </div><!-- end Latest Updates slider -->

@endsection

@section('foot')
   <script>
      var startappContainerId = "startappContainer-1";
      var publisherId = '110034249';
      var productId = '204752047';
      var width = 337;
      var height = 450;
   </script>
   <script src="{{ asset('assets/vendor/startapp-tag.js') }}"></script>

   <script>
      var startappContainerId = "startappContainer-2";
      var publisherId = '110034249';
      var productId = '204752047';
      var width = 337;
      var height = 450;
   </script>
   <script src="{{ asset('assets/vendor/startapp-tag.js') }}"></script>

   <script>
      var startappContainerId = "startappContainer-3";
      var publisherId = '110034249';
      var productId = '204752047';
      var width = 337;
      var height = 450;
   </script>
   <script src="{{ asset('assets/vendor/startapp-tag.js') }}"></script>

   <script type="text/javascript">
      $(function(){
         $('.latest-updates').slick({
            slidesToShow: 3,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 3000,
            dots: true,
            prevArrow: '<button class="slider-arrow arrow-prev"><i class="fa fa-chevron-left"></i></button>',
            nextArrow: '<button class="slider-arrow arrow-next"><i class="fa fa-chevron-right"></i></button>',
            responsive: [
               {
                  breakpoint: 769,
                  settings: {
                     slidesToShow: 2,
                     dots: false
                  }
               },
               {
                  breakpoint: 600,
                  settings: {
                     slidesToShow: 1,
                     dots: false
                  }
               }
            ]
         });
      })
   </script>
@endsection