@extends('_layouts.home')

@section('content')

   <div class="window-header">
      <a class="window-close" href="#"><i class="fa fa-times"></i></a>
   </div>
   <div class="main-row">
      <div class="left-section col-md-4 pad-big">

      </div><!-- end left-section of main content -->

      <div class="right-section col-md-8 pad-big">
         <h2 class="section-title">@lang('notifications.notifications')</h2>
         <div class="notifications">

            @forelse($notifications as $notification)

               <?php if (! $notification->notificable) continue; ?>

               @if(View::exists('notifications._types.' . $notification->notificable_type))
                  @include('notifications._types.' . $notification->notificable_type, ['item' => $notification->notificable])
               @endif

            @empty
               <div class="col-xs-12">
                  <p>@lang('notifications.no-notifications')</p>
               </div>
            @endforelse

         </div>
      </div><!-- end right-section-->
   </div><!-- end row of main-content -->

@endsection
