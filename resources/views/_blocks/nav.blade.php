
<nav class="navbar navbar-default navbar-static-top">
   <div class="container">
      <div class="navbar-header">
         <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
         </button>
         <a class="navbar-brand" href="{{ url('/') }}">
            <img src="{{ asset('assets/img/main-logo.png') }}" class="logo" alt="logo" width="300"/>
         </a>
      </div>

      @if (Auth::guest())
         <form action="{{ url('/login') }}" method="POST">
            {!! csrf_field() !!}
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
               <ul class="nav navbar-nav navbar-right">
                  <li>
                     <input type="text" class="inpt no-bg" id="login_username" name="email" placeholder="@lang('common.email')" required>
                  </li>
                  <li>
                     <input type="password" class="inpt no-bg" id="login_password" name="password" placeholder="@lang('common.password')" required><br>
                     <a href="{{ url('password/email') }}" class="forgot-password">@lang('common.forgot-password')</a>
                  </li>
                  <li class="menu-items">
                     <button href="#" class="btn btn-flat btn-primary menu-item pull-left" id="login-btn">
                        <i class="fa fa-check"></i><br>@lang('common.enter')
                     </button>
                     <a href="{{ url('/register') }}" class="btn btn-flat btn-info menu-item pull-left">
                        <i class="fa fa-arrow-up"></i><br> @lang('common.signup')
                     </a>
                  </li>
               </ul>
            </div>
         </form>
      @else
         <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
               <li class="menu-items">
                  <a href="<?php echo url('/settings');?>" class="btn btn-flat btn-primary menu-item pull-left">
                     <i class="ico ico-setting"></i><br>@lang('common.settings')
                  </a>
                  <a href="<?php echo url('/logout');?>" class="btn btn-flat btn-info menu-item pull-left">
                     <i class="ico ico-logout"></i><br>@lang('common.logout')
                  </a>
               </li>
            </ul>
         </div>
      @endif

   </div>
</nav>

