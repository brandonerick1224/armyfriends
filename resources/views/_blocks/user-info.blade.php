
@if(! $user->getOption('hide_email'))
   <div class="row">
      <div class="col-xs-12 col-sm-4 property">@lang('common.email')</div>
      <div class="col-xs-12 col-sm-8 value text-right">{{ $user->email }}</div>
   </div>
@endif
<div class="row">
   <div class="col-xs-12 col-sm-4 property">@lang('common.city')</div>
   <div class="col-xs-12 col-sm-8 value text-right">{{ $user->profile->city }}</div>
</div>
<div class="separator"></div>
<div class="row">
   <div class="col-xs-12 col-sm-4 property">@lang('common.location')</div>
   <div class="col-xs-12 col-sm-8 value text-right">{{ $user->profile->service_city }}</div>
</div>
<div class="row">
   <div class="col-xs-12 col-sm-4 property">@lang('profile.from')</div>
   <div class="col-xs-12 col-sm-8 value text-right">{{ $user->profile->service_start_date }}</div>
</div>
<div class="row">
   <div class="col-xs-12 col-sm-4 property">@lang('profile.to')</div>
   <div class="col-xs-12 col-sm-8 value text-right">{{ $user->profile->service_end_date }}</div>
</div>
@if($user->profile->about_me)
   <div class="separator"></div>
   <div class="property prop-vertical">@lang('profile.about-me')</div>
   <div class="value">{{ $user->profile->about_me }}</div>
@endif