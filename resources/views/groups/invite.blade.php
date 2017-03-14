@extends('_layouts.home')

@section('content')

   <div class="window-header">
      <a class="window-close" href="#"><i class="fa fa-times"></i></a>
   </div>
   <div class="main-row">
      <div class="left-section col-md-4 pad-big">

      </div><!-- end left-section of main content -->

      <div class="right-section col-md-8 pad-big">
         <h2 class="section-title">@lang('groups.invite-to-group') {{ $group->title }}</h2>
         <div class="friends-boxes grid" id="allfriendslist">

            <form method="post">
               {{ csrf_field() }}
               <div class="form-group{{ $errors->has('users') ? ' has-error' : '' }}">
                  <label for="group_users">@lang('groups.select-to-invite')</label>
                  {!! Form::select('users[]', $user->friends->pluck('profile.full_name', 'id'), null, ['class' => 'form-control select2', 'multiple']) !!}
                  @if ($errors->has('users'))
                     <span class="help-block"><strong>{{ $errors->first('users') }}</strong></span>
                  @endif
               </div>
               <button type="submit" class="btn btn-primary">@lang('groups.invite')</button>
            </form>

         </div><!-- end friends-boxes -->
      </div><!-- end right-section-->
   </div><!-- end row of main-content -->

@endsection
