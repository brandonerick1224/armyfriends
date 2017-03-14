@extends('_layouts.home')

@section('content')

   <div class="window-header">
      <a class="window-close" href="#"><i class="fa fa-times"></i></a>
   </div>
   <div class="main-row">
      <div class="left-section col-md-4 pad-big">
         <ul class="settings-menu remove-default">
            <li class="active"><a href="#personal-tab" data-toggle="tab" class="inner-menu-item">@lang('profile.personal-info')</a></li>
            <li><a href="#served-tab" data-toggle="tab" class="inner-menu-item">@lang('profile.served-info')</a></li>
            <li><a href="#login-tab" data-toggle="tab" class="inner-menu-item">@lang('common.login')</a></li>
            <li><a href="#options-tab" data-toggle="tab" class="inner-menu-item">@lang('common.options')</a></li>
         </ul>
      </div><!-- end left-section of main content -->

      <div class="right-section col-md-8 pad-big">

         <h2 class="section-title">@lang('common.settings')</h2>

         <form name="signup_form" method="post" enctype="multipart/form-data" action="{{ url('settings/update') }}">

            {!! csrf_field() !!}

            <div class="tab-content">

               <div role="tabpanel" class="tab-pane active" id="personal-tab">
                  <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                     <label for="signup_first_name">@lang('profile.first-name')</label>
                     <input type="text" class="form-control thick" id="signup_first_name" name="first_name" value="{{ old('first_name', $user->profile->first_name) }}" placeholder="@lang('profile.first-name')" >
                     @if ($errors->has('first_name'))
                        <span class="help-block"><strong>{{ $errors->first('first_name') }}</strong></span>
                     @endif
                  </div>
                  <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                     <label for="signup_last_name">@lang('profile.last-name')</label>
                     <input type="text" class="form-control thick" id="signup_last_name" name="last_name" value="{{ old('last_name', $user->profile->last_name) }}" placeholder="@lang('profile.last-name')" >
                     @if ($errors->has('last_name'))
                        <span class="help-block"><strong>{{ $errors->first('last_name') }}</strong></span>
                     @endif
                  </div>
                  <div class="form-group{{ $errors->has('birth_date') ? ' has-error' : '' }}">
                     <label for="signup_date_of_birth">@lang('profile.birth-date') (dd/mm/yyyy)</label>
                     <input type="text" class="form-control thick datepicker" id="signup_date_of_birth" name="birth_date" value="{{ old('birth_date', $user->profile->birth_date) }}" placeholder="@lang('profile.birth-date') (dd/mm/yyyy)" >
                     <input type="hidden" id="currentdate" value="">
                     @if ($errors->has('birth_date'))
                        <span class="help-block"><strong>{{ $errors->first('birth_date') }}</strong></span>
                     @endif
                  </div>
                  <div class="form-group{{ $errors->has('city') ? ' has-error' : '' }}">
                     <label for="city">@lang('common.city')</label>
                     <input type="city" class="form-control thick" id="city" name="city" value="{{ old('city', $user->profile->city) }}" placeholder="@lang('common.city')" >
                     @if ($errors->has('city'))
                        <span class="help-block"><strong>{{ $errors->first('city') }}</strong></span>
                     @endif
                  </div>
                  <div class="form-group{{ $errors->has('country') ? ' has-error' : '' }}">
                     <label for="country">@lang('common.country')</label>
                     {!! Form::select('country', $countries, old('country', $user->profile->country_id), ['class' => 'form-control thick', 'placeholder' => trans('common.country')], true) !!}
                     @if ($errors->has('country'))
                        <span class="help-block"><strong>{{ $errors->first('country') }}</strong></span>
                     @endif
                  </div>
                  <div class="form-group{{ $errors->has('image') ? ' has-error' : '' }}">
                     <label for="file">@lang('profile.profile-picture')</label>
                     <div>
                        <img src="{{ $user->pictureUrl('thumb') }}" id="profile-output" class="singup-preview-img" />
                     </div>
                     <input type="file" id="file" name="image" accept="image/*" onChange="loadFile(event)" value="files">
                     @if ($errors->has('image'))
                        <span class="help-block"><strong>{{ $errors->first('image') }}</strong></span>
                     @endif
                  </div>
                  <div class="form-group{{ $errors->has('about_me') ? ' has-error' : '' }}">
                     <label for="about_me">@lang('profile.about-me')</label>
                     <textarea name="about_me" class="form-control thick" id="about_me" rows="10">{{ old('about_me', $user->profile->about_me) }}</textarea>
                     @if ($errors->has('about_me'))
                        <span class="help-block"><strong>{{ $errors->first('about_me') }}</strong></span>
                     @endif
                  </div>

               </div>

               <div role="tabpanel" class="tab-pane" id="served-tab">

                  <div class="form-group{{ $errors->has('service_start_date') ? ' has-error' : '' }}">
                     <label for="signup_start_date">@lang('profile.start-date') (dd/mm/yyyy)</label>
                     <input class="form-control thick datepicker" id="signup_start_date" name="service_start_date" value="{{ old('service_start_date', $user->profile->service_start_date) }}"  placeholder="@lang('profile.start-date') (dd/mm/yyyy)" >
                     @if ($errors->has('service_start_date'))
                        <span class="help-block"><strong>{{ $errors->first('service_start_date') }}</strong></span>
                     @endif
                  </div>
                  <div class="form-group{{ $errors->has('service_end_date') ? ' has-error' : '' }}">
                     <label for="signup_start_date">@lang('profile.end-date') (dd/mm/yyyy)</label>
                     <input class="form-control thick datepicker" id="signup_end_date" name="service_end_date" value="{{ old('service_end_date', $user->profile->service_end_date) }}"  placeholder="@lang('profile.end-date') (dd/mm/yyyy)" >
                     @if ($errors->has('service_end_date'))
                        <span class="help-block"><strong>{{ $errors->first('service_end_date') }}</strong></span>
                     @endif
                  </div>
                  <div class="form-group{{ $errors->has('service_city') ? ' has-error' : '' }}">
                     <label for="signup_service_city">@lang('common.city')</label>
                     <input class="form-control thick" id="signup_service_city" name="service_city" value="{{ old('service_city', $user->profile->service_city) }}"  placeholder="@lang('common.city')" >
                     @if ($errors->has('service_city'))
                        <span class="help-block"><strong>{{ $errors->first('service_city') }}</strong></span>
                     @endif
                  </div>
                  <div class="form-group{{ $errors->has('service_country') ? ' has-error' : '' }}">
                     <label for="service_country">@lang('common.country')</label>
                     {!! Form::select('service_country', $countries, old('', $user->profile->service_country_id), ['class' => 'form-control thick', 'placeholder' => trans('common.country')], true) !!}
                     @if ($errors->has('service_country'))
                        <span class="help-block"><strong>{{ $errors->first('service_country') }}</strong></span>
                     @endif
                  </div>

               </div>

               <div role="tabpanel" class="tab-pane" id="login-tab">

                  <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                     <label for="signup_password">@lang('common.password')</label>
                     <input type="password" class="form-control thick" id="signup_password" name="password" placeholder="@lang('common.password')" >
                     @if ($errors->has('password'))
                        <span class="help-block"><strong>{{ $errors->first('password') }}</strong></span>
                     @endif
                  </div>
                  <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                     <label for="signup_confirm_password">@lang('common.confirm-password')</label>
                     <input type="password" class="form-control thick" id="signup_confirm_password" name="password_confirmation" placeholder="@lang('common.confirm-password')" >
                     @if ($errors->has('password_confirmation'))
                        <span class="help-block"><strong>{{ $errors->first('password_confirmation') }}</strong></span>
                     @endif
                  </div>

               </div>

               <div role="tabpanel" class="tab-pane" id="options-tab">

                  <div class="checkbox">
                     <label>
                        <input type="hidden" name="options[hide_email]" value="0">
                        <input type="checkbox" name="options[hide_email]" value="1" {{ $user->getOption('hide_email') ? 'checked' : '' }}> Hide my email
                     </label>
                  </div>

               </div>
            </div>

            <div class="text-right">
               <button type="submit" id="btn-singup" class="btn btn-lg btn-primary">@lang('common.update')</button>
            </div>
         </form>

      </div><!-- end right-section-->
   </div><!-- end row of main-content -->

@endsection
