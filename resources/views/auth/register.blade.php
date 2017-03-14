@extends('_layouts.page')

@section('content')

   <h2 class="section-title ">@lang('register.signup-title')</h2>

   <div class="row">
      <div class="col-md-8 col-md-offset-2">

         <form id="signup_form" name="signup_form" method="post" enctype="multipart/form-data" action="{{ url('/register') }}">

            {!! csrf_field() !!}

            <div class="row">
               <div class="col-md-6 col-sm-6 form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                  <input type="text" class="form-control" id="signup_username" name="name" value="{{ old('name') }}" placeholder="@lang('register.user-name')" minlength="4" >
                  @if ($errors->has('name'))
                     <span class="help-block"><strong>{{ $errors->first('name') }}</strong></span>
                  @endif
               </div>
               <div class="col-md-6 col-sm-6 form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                  <input type="text" class="form-control" id="signup_first_name" name="first_name" value="{{ old('first_name') }}" placeholder="@lang('profile.first-name')" >
                  @if ($errors->has('first_name'))
                     <span class="help-block"><strong>{{ $errors->first('first_name') }}</strong></span>
                  @endif
               </div>
               <div class="col-md-6 col-sm-6 form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                  <input type="email" class="form-control" id="signup_email" name="email" value="{{ old('email') }}" placeholder="@lang('register.email-id')" >
                  @if ($errors->has('email'))
                     <span class="help-block"><strong>{{ $errors->first('email') }}</strong></span>
                  @endif
               </div>
               <div class="col-md-6 col-sm-6 form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                  <input type="text" class="form-control" id="signup_last_name" name="last_name" value="{{ old('last_name') }}" placeholder="@lang('profile.last-name')" >
                  @if ($errors->has('last_name'))
                     <span class="help-block"><strong>{{ $errors->first('last_name') }}</strong></span>
                  @endif
               </div>
               <div class="col-md-6 col-sm-6 form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                  <input type="password" class="form-control" id="signup_password" name="password" placeholder="@lang('common.password')" >
                  @if ($errors->has('password'))
                     <span class="help-block"><strong>{{ $errors->first('password') }}</strong></span>
                  @endif
               </div>
               <div class="col-md-6 col-sm-6 form-group{{ $errors->has('birth_date') ? ' has-error' : '' }}">
                  <input type="text" class="form-control datepicker" id="signup_date_of_birth" name="birth_date" value="{{ old('birth_date') }}" placeholder="@lang('profile.birth-date') (dd/mm/yyyy)" >
                  <input type="hidden" id="currentdate" value="">
                  @if ($errors->has('birth_date'))
                     <span class="help-block"><strong>{{ $errors->first('birth_date') }}</strong></span>
                  @endif
               </div>
               <div class="col-md-6 col-sm-6 form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                  <input type="password" class="form-control" id="signup_confirm_password" name="password_confirmation" placeholder="@lang('common.confirm-password')" >
                  @if ($errors->has('password_confirmation'))
                     <span class="help-block"><strong>{{ $errors->first('password_confirmation') }}</strong></span>
                  @endif
               </div>
               <div class="col-md-6 col-sm-6 form-group{{ $errors->has('city') ? ' has-error' : '' }}">
                  <input type="city" class="form-control" id="city" name="city" value="{{ old('city') }}" placeholder="@lang('common.city')" >
                  @if ($errors->has('city'))
                     <span class="help-block"><strong>{{ $errors->first('city') }}</strong></span>
                  @endif
               </div>
               <div class="col-md-6 col-sm-6 form-group{{ $errors->has('country') ? ' has-error' : '' }}">
                  {!! Form::select('country', $countries, null, ['class' => 'form-control', 'placeholder' => trans('common.country')], true) !!}
                  @if ($errors->has('country'))
                     <span class="help-block"><strong>{{ $errors->first('country') }}</strong></span>
                  @endif
               </div>
            </div><!-- end Row -->

            <div class="row">
               <div class="col-md-6 col-sm-12">
                  <h2 class="section-title">@lang('register.date-of-service')</h2>

                  <div class="form-group{{ $errors->has('service_start_date') ? ' has-error' : '' }}">
                     <input class="form-control datepicker" id="signup_start_date" name="service_start_date" value="{{ old('service_start_date') }}"  placeholder="@lang('profile.start-date') (dd/mm/yyyy)" >
                     @if ($errors->has('service_start_date'))
                        <span class="help-block"><strong>{{ $errors->first('service_start_date') }}</strong></span>
                     @endif
                  </div>
                  <div class="form-group{{ $errors->has('service_end_date') ? ' has-error' : '' }}">
                     <input class="form-control datepicker" id="signup_end_date" name="service_end_date" value="{{ old('service_end_date') }}"  placeholder="@lang('profile.end-date') (dd/mm/yyyy)" >
                     @if ($errors->has('service_end_date'))
                        <span class="help-block"><strong>{{ $errors->first('service_end_date') }}</strong></span>
                     @endif
                  </div>
                  <div class="form-group{{ $errors->has('service_city') ? ' has-error' : '' }}">
                     <input class="form-control" id="signup_service_city" name="service_city" value="{{ old('service_city') }}"  placeholder="@lang('common.city')" >
                     @if ($errors->has('service_city'))
                        <span class="help-block"><strong>{{ $errors->first('service_city') }}</strong></span>
                     @endif
                  </div>
                  <div class="form-group{{ $errors->has('service_country') ? ' has-error' : '' }}">
                     {!! Form::select('service_country', $countries, null, ['class' => 'form-control', 'placeholder' => trans('common.country')], true) !!}
                     @if ($errors->has('service_country'))
                        <span class="help-block"><strong>{{ $errors->first('service_country') }}</strong></span>
                     @endif
                  </div>

               </div><!-- col-md-6 Date of Service-->

               <div class="col-md-6 col-sm-12">
                  <h2 class="section-title">@lang('register.profile-picture')</h2>

                  <div class="form-group{{ $errors->has('image') ? ' has-error' : '' }}">
                     <img src="" id="profile-output" class="singup-preview-img" />
                     <input type="file" id="file" name="image" accept="image/*" onChange="loadFile(event)" value="files">
                     @if ($errors->has('image'))
                        <span class="help-block"><strong>{{ $errors->first('image') }}</strong></span>
                     @endif
                  </div>
               </div>
            </div>

            <button type="submit" id="btn-singup" class="btn btn-flat btn-primary widget-submit">@lang('register.register')</button>
         </form>

      </div>
   </div>

@endsection
