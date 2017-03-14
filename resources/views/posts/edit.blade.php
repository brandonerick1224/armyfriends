@extends('_layouts.home')

@section('content')

   <div class="window-header">
      <a class="window-close" href="#"><i class="fa fa-times"></i></a>
   </div>
   <div class="main-row">
      <div class="left-section col-md-4 pad-big">

      </div><!-- end left-section of main content -->

      <div class="right-section col-md-8 pad-big">
         <h2 class="section-title">@lang('posts.edit-post')</h2>

         <div class="post-form">

            <form action="{{ url('posts/update/' . $post->id) }}" id="status_form" name="status_form" method="post" accept-charset="UTF-8" enctype="multipart/form-data">
               {!! csrf_field() !!}
               <div class="form-group{{ $errors->has('content') ? ' has-error' : '' }}">
                  <textarea class="form-control" id="status" name="content" rows="4" placeholder="@lang('posts.whats-new')">{{ old('content', $post->content) }}</textarea>
                  @if ($errors->has('content'))
                     <span class="help-block"><strong>{{ $errors->first('content') }}</strong></span>
                  @endif
               </div>
               <div id="pf-image-box">
                  @if($post->hasMedia())
                     <div><img src="{{ $post->getFirstMediaUrl() }}" alt="" /></div>
                  @endif
               </div>
               <div class="pf-buttons clearfix">
                  <div class="pull-left">
                     <span class="btn-icon">
                        <input id="pf-image-input" name="image" type="file" class="hidden" />
                        <a href="#" id="pf-btn-image"><i class="fa fa-camera"></i></a>
                     </span>
                     <div id="upload_desc"></div>
                  </div>
                  <div class="pull-right">
                     <button class="btn btn-default" type="submit" id="postdata">@lang('common.save')</button>
                  </div>
               </div>
            </form>

         </div>

      </div><!-- end right-section-->
   </div><!-- end row of main-content -->

@endsection
