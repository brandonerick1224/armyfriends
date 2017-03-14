@extends('_layouts.home')

@section('content')

   <div class="window-header">
      <a class="window-close" href="#"><i class="fa fa-times"></i></a>
   </div>
   <div class="main-row">
      <div class="left-section col-md-4 pad-big">

      </div><!-- end left-section of main content -->

      <div class="right-section col-md-8 pad-big">
         <h2 class="section-title">@lang('groups.edit-group-user') {{ $groupUser->user->full_name }}</h2>
         <div class="friends-boxes grid" id="allfriendslist">

            <form method="post" action="{{ url('group_user/update/' . $groupUser->id) }}">

               {!! csrf_field() !!}

               <div class="form-group{{ $errors->has('type') ? ' has-error' : '' }}">
                  <label for="group_type">Type</label>
                  {!! Form::select('type', ['participant' => 'Participant', 'admin' => 'Admin'], old('type', $groupUser->type), ['class' => 'form-control']) !!}
                  @if ($errors->has('type'))
                     <span class="help-block"><strong>{{ $errors->first('type') }}</strong></span>
                  @endif
               </div>

               <div class="pull-right">
                  <button type="submit" id="btn-singup" class="btn btn-primary">@lang('common.update')</button>
               </div>
            </form>

         </div><!-- end friends-boxes -->
      </div><!-- end right-section-->
   </div><!-- end row of main-content -->

@endsection
