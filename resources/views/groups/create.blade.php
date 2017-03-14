@extends('_layouts.home')

@section('content')

   <div class="window-header">
      <a class="window-close" href="#"><i class="fa fa-times"></i></a>
   </div>
   <div class="main-row">
      <div class="left-section col-md-4 pad-big">

      </div><!-- end left-section of main content -->

      <div class="right-section col-md-8 pad-big">
         <h2 class="section-title">@lang('groups.create-new-group')</h2>
         <div class="friends-boxes grid" id="allfriendslist">

            <form name="group_form" method="post" enctype="multipart/form-data" action="{{ url('groups/store') }}">

               {!! csrf_field() !!}

               <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                  <label for="group_title">@lang('groups.title')</label>
                  <input type="text" class="form-control" id="group_title" name="title" value="{{ old('title') }}" placeholder="@lang('groups.title')" >
                  @if ($errors->has('title'))
                     <span class="help-block"><strong>{{ $errors->first('title') }}</strong></span>
                  @endif
               </div>
               <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                  <label for="group_description">@lang('groups.description')</label>
                  <input type="text" class="form-control" id="group_description" name="description" value="{{ old('description') }}" placeholder="@lang('groups.description')" >
                  @if ($errors->has('description'))
                     <span class="help-block"><strong>{{ $errors->first('description') }}</strong></span>
                  @endif
               </div>
               <div class="form-group{{ $errors->has('type') ? ' has-error' : '' }}">
                  <label for="group_type">@lang('groups.group-type')</label>
                  {!! Form::select('type', ['public' => trans('groups.public'), 'private' => trans('groups.private')], null, ['class' => 'form-control']) !!}
                  @if ($errors->has('type'))
                     <span class="help-block"><strong>{{ $errors->first('type') }}</strong></span>
                  @endif
               </div>
               <div class="form-group{{ $errors->has('image') ? ' has-error' : '' }}">
                  <label for="file">@lang('groups.cover-image')</label>
                  <div><img src="" id="profile-output" class="singup-preview-img" /></div>
                  <input type="file" id="file" name="image" accept="image/*" onChange="loadFile(event)" value="files">
                  @if ($errors->has('image'))
                     <span class="help-block"><strong>{{ $errors->first('image') }}</strong></span>
                  @endif
               </div>

               <button type="submit" id="btn-singup" class="btn btn-primary btn-lg">@lang('common.create')</button>
            </form>

         </div><!-- end friends-boxes -->
      </div><!-- end right-section-->
   </div><!-- end row of main-content -->

@endsection
