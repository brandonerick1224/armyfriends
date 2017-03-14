<div class="post-form">
   <form action="{{ url('posts/store') }}" id="status_form" name="status_form" method="post" accept-charset="UTF-8" enctype="multipart/form-data">
      {!! csrf_field() !!}
      @if(! empty($group))
         <input type="hidden" name="group_id" value="{{ $group->id }}" />
      @endif
      <div class="form-group{{ $errors->has('content') ? ' has-error' : '' }}">
         <textarea class="form-control" id="status" name="content" rows="4" placeholder="@lang('posts.whats-new')"></textarea>
         @if ($errors->has('content'))
            <span class="help-block"><strong>{{ $errors->first('content') }}</strong></span>
         @endif
      </div>
      <div id="pf-image-box"></div>
      <div class="pf-buttons clearfix">
         <div class="pull-left">
            {{--<span class="btn-icon">
               <label for="post-file">
                  <i class="fa fa-upload"></i>
                  <input id="post-file" name="file" type="file" class="hidden"/>
               </label>
            </span>--}}
            <span class="btn-icon">
               <input id="pf-image-input" name="image" type="file" class="hidden" />
               <a href="#" id="pf-btn-image"><i class="fa fa-camera"></i></a>
            </span>
            {{--<button class="btn-icon" type="button"><i class="fa fa-map-marker"></i></button>--}}
            <div id="upload_desc"></div>
         </div>
         <div class="pull-right">
            <button class="btn btn-default" type="submit" id="postdata">@lang('posts.submit-post')</button>
         </div>
      </div>
   </form>
</div><!-- end post-form-->
<div class="separator"></div>