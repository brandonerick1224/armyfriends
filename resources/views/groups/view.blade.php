@extends('_layouts.home')

@section('profile-image')
   <div class="user-img" style="background-image:url('{{ $group->getFirstMediaUrl('cover', 'thumb') }}')"></div>
@endsection

@section('content')

   <div class="window-header">
      <a class="window-close" href="#"><i class="fa fa-times"></i></a>
   </div>
   <div class="main-row">
      <div class="left-section col-md-4 pad-big">

         <h2 class="section-title">@lang('common.users')</h2>

         <ul class="user-list remove-default">

            @foreach($group->users as $user)
               <li class="person">
                  <div>
                     <a href="{{ url('profile/' . $user->id) }}">
                        <img class="avatar" src="{{ $user->pictureUrl('thumb') }}" width="50" height="50" />
                     </a>
                  </div>
                  <div>
                     <div class="title"><a href="{{ url('profile/' . $user->id) }}">{{ $user->profile->fullName() }}</a></div>
                     <span class="desc"></span>
                     @if($user->pivot->type === 'admin')
                        <span class="badge">@lang('common.admin')</span>
                     @endif
                  </div>
                  @if($groupUser && $groupUser->status === 'accept' && $groupUser->type === 'admin')
                     <div class="pull-right">
                        <a href="{{ url('group_user/edit/' . $user->pivot->id) }}"><i class="fa fa-pencil"></i></a>
                        <a href="{{ url('group_user/remove/' . $user->pivot->id) }}"><i class="fa fa-trash-o"></i></a>
                     </div>
                  @endif
               </li>
            @endforeach

         </ul><!-- end user-list -->

         <br>
         @if(! $groupUser)
            <a href="{{ url('groups/join/' . $group->id) }}" class="btn btn-success">
               {{ $group->type === 'private' ? 'Request to join' : 'Join' }}
               @lang('groups.group')
            </a>
         @elseif($groupUser->status === 'request')
            <a href="#" class="btn btn-success" disabled>@lang('groups.requested-to-join')</a>
         @endif

         @if($groupUser && $groupUser->status === 'accept')

            <a href="{{ url('groups/leave/' . $group->id) }}" class="btn btn-danger">@lang('groups.leave-group')</a>

            @if($group->type === 'public' || $groupUser->type === 'admin')
               <br><br>
               <a href="{{ url('groups/invite/' . $group->id) }}" class="btn btn-primary">@lang('groups.invite-friends')</a>
            @endif

            @if($groupUser->type === 'admin')
               <br><br>
               <a href="{{ url('groups/edit/' . $group->id) }}" class="btn btn-primary">@lang('groups.edit-group')</a>

               <h2 class="section-title">@lang('groups.requests')</h2>

               <div class="user-list">
                  @foreach($group->requests as $user)
                     <div class="person">
                        <div>
                           <a href="{{ url('profile/' . $user->id) }}">
                              <img class="avatar" src="{{ $user->pictureUrl('thumb') }}" width="50" height="50">
                           </a>
                        </div>
                        <div>
                           <div class="title"><a href="{{ url('profile/' . $user->id) }}">{{ $user->profile->fullName() }}</a></div>
                           <a href="{{ url('group_user/approve/' . $user->pivot->id) }}" class="btn btn-xs btn-success">@lang('groups.approve')</a>
                           <a href="{{ url('group_user/decline/' . $user->pivot->id) }}" class="btn btn-xs btn-danger">@lang('groups.decline')</a>
                        </div>
                     </div>
                  @endforeach
               </div>

               <h2 class="section-title">@lang('groups.invitations')</h2>

               <div class="user-list">
                  @foreach($group->invitations as $user)
                     <div class="person">
                        <div>
                           <a href="{{ url('profile/' . $user->id) }}">
                              <img class="avatar" src="{{ $user->pictureUrl('thumb') }}" width="50" height="50">
                           </a>
                        </div>
                        <div>
                           <div class="title"><a href="{{ url('profile/' . $user->id) }}">{{ $user->profile->fullName() }}</a></div>
                           <a href="{{ url('group_user/cancel/' . $user->pivot->id) }}" class="btn btn-xs btn-success">@lang('groups.cancel')</a>
                        </div>
                     </div>
                  @endforeach
               </div>

            @endif

         @endif

      </div><!-- end left-section of main content -->

      <div class="right-section col-md-8 pad-big">
         <h2 class="section-title">{{ $group->title }}</h2>

         @if($group->description)
            <p>{{ $group->description }}</p>
            <br><br>
         @endif

         @if($groupUser && $groupUser->status === 'accept')
            @include('_blocks.post-form', ['group' => $group])
         @else
            <p>@lang('groups.need-join-to-post')</p>
            <br><br>
         @endif

         <div class="posts" id="profiledata">
            @include('_blocks.posts', ['posts' => $posts])
         </div>

      </div><!-- end right-section-->
   </div><!-- end row of main-content -->

@endsection
