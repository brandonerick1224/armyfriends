@extends('_layouts.home')

@section('head')
{{--   <link rel="stylesheet" href="{{ asset('assets/vendor/dropzone/basic.min.css') }}"/>--}}
   <link rel="stylesheet" href="{{ asset('assets/vendor/dropzone/dropzone.min.css') }}"/>
@endsection

@section('content')

   <div class="window-header">
      <a class="window-close" href="#"><i class="fa fa-times"></i></a>
   </div>
   <div class="main-row">
      <div class="left-section col-md-4 pad-big">

         <h2 class="section-title">@lang('albums.albums')</h2>

         @include('_blocks.albums-list', ['albums' => $albums, 'current' => $album])

      </div><!-- end left-section of main content -->

      <div class="right-section col-md-8 pad-big">
         <h2 class="section-title">@lang('albums.upload-images')</h2>

         <a href="{{ url('albums/view/' . $album->id) }}" class="btn btn-primary">@lang('albums.back-to-album')</a>
         <br><br>

         <form action="{{ url('album_items/upload/' . $album->id) }}" class="dropzone">
            <div class="fallback">
               <input name="file" type="file" multiple />
            </div>
         </form>

      </div><!-- end right-section-->
   </div><!-- end row of main-content -->

@endsection

@section('foot')
   <script src="{{ asset('assets/vendor/dropzone/dropzone.min.js') }}"></script>
   <script>
      Dropzone.autoDiscover = false;
      $('.dropzone').each(function(index){
         $(this).dropzone({
            dictDefaultMessage: '@lang('albums.drop-files-to-upload')',
         })
      });
   </script>
@endsection