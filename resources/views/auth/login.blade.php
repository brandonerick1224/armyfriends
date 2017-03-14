@extends('_layouts.page')

@section('content')

   <h2 class="section-title">@lang('common.login')</h2>

   <div class="row">
      <div class="col-md-8 col-md-offset-2">

         <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
            {!! csrf_field() !!}

            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
               <label class="col-md-4 control-label">@lang('common.email-address')</label>

               <div class="col-md-6">
                  <input type="email" class="form-control" name="email" value="{{ old('email') }}">

                  @if ($errors->has('email'))
                     <span class="help-block">
                         <strong>{{ $errors->first('email') }}</strong>
                     </span>
                  @endif
               </div>
            </div>

            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
               <label class="col-md-4 control-label">@lang('common.password')</label>

               <div class="col-md-6">
                  <input type="password" class="form-control" name="password">

                  @if ($errors->has('password'))
                     <span class="help-block">
                         <strong>{{ $errors->first('password') }}</strong>
                     </span>
                  @endif
               </div>
            </div>

            <div class="form-group">
               <div class="col-md-6 col-md-offset-4">
                  <div class="checkbox">
                     <label>
                        <input type="checkbox" name="remember"> @lang('common.remember-me')
                     </label>
                  </div>
               </div>
            </div>

            <div class="form-group">
               <div class="col-md-6 col-md-offset-4">
                  <button type="submit" class="btn btn-primary">
                     <i class="fa fa-btn fa-sign-in"></i> @lang('common.login')
                  </button>

                  <a class="btn btn-link" href="{{ url('/password/reset') }}">@lang('common.forgot-password')</a>
               </div>
            </div>
         </form>

      </div>
   </div>

@endsection
