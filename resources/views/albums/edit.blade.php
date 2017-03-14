@extends('_layouts.home')

@section('content')

   <div class="window-header">
      <a class="window-close" href="#"><i class="fa fa-times"></i></a>
   </div>
   <div class="main-row">
      <div class="left-section col-md-4 pad-big">

         @include('_blocks.albums-list', ['albums' => $albums, 'current' => $album])

      </div><!-- end left-section of main content -->

      <div class="right-section col-md-8 pad-big">
         <h2 class="section-title">@lang('albums.edit-album')</h2>

         <form action="{{ url('albums/update/' . $album->id) }}" method="POST">
            {!! csrf_field() !!}
            <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
               <label for="album_title">@lang('albums.album-title')</label>
               <input type="text" id="album_title" class="form-control" name="title" value="{{ old('title', $album->title) }}" />
               @if ($errors->has('title'))
                  <span class="help-block"><strong>{{ $errors->first('title') }}</strong></span>
               @endif
            </div>
            <div class="form-group buttons">
               <button class="btn btn-default" type="submit" id="postdata">@lang('albums.save')</button>
               <div class="pull-right">
                  <a href="{{ url('albums/remove/' . $album->id) }}" class="btn btn-danger" onclick="return confirm('Are you sure?')"><i class="fa fa-remove"></i> @lang('albums.delete-album')</a>
               </div>
            </div>
         </form>

      </div><!-- end right-section-->
   </div><!-- end row of main-content -->

@endsection
