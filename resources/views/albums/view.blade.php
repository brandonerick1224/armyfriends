@extends('_layouts.home')

@section('content')

   <div class="window-header">
      <a class="window-close" href="#"><i class="fa fa-times"></i></a>
   </div>
   <div class="main-row">
      <div class="left-section col-md-4 pad-big">

         <h2 class="section-title">@lang('albums.albums')</h2>

         @include('_blocks.albums-list', ['albums' => $albums, 'current' => $album])

         @if($album->mine())
            <a href="{{ url('albums/create') }}" class="btn btn-primary">@lang('albums.add-new-album')</a>
         @endif

      </div><!-- end left-section of main content -->

      <div class="right-section col-md-8 pad-big">
         <h2 class="section-title">@lang('albums.images')</h2>

         <div class="friends-boxes grid" id="allfriendslist">

            @forelse($album_items as $item)
               <div class="col-xs-6 col-sm-4 col-md-3">
                  <div class="friend-box">
                     <div class="photo-wrap">
                        <a href="{{ url('album_items/view/' . $item->id) }}">
                           <img src="{{ $item->getFirstMediaUrl('default', 'thumb') }}" alt="">
                        </a>
                     </div>
                     <div class="fb-footer">
                        @can('remove', $item)
                           <div class="pull-right">
                              <a href="{{ url('album_items/remove/' . $item->id) }}" onclick="return confirm('Are you sure?')"><i class="fa fa-trash-o"></i></a>
                           </div>
                        @endcan
                        <div class="pull-left">
                           <span class="fb-meta"><i class="fa fa-comment"></i> {{ $item->comments_count }}</span>
                           <span class="fb-meta"><i class="fa fa-thumbs-o-up"></i> {{ $item->likes_count }}</span>
                        </div>
                        <div class="clearfix"></div>
                        <div class="desc text-center">
                           {{ str_limit($item->title, 20) }}
                        </div>
                     </div>
                  </div>
               </div><!-- end of col-->

            @empty
               <div class="col-xs-12">
                  <p>@lang('albums.no-images')</p>
                  <br>
               </div>
            @endforelse

         </div><!-- end friends-boxes -->

         @can('upload', $album)
            <a href="{{ url('albums/upload/' . $album->id) }}" class="btn btn-success">@lang('albums.upload-images')</a>
         @endcan
         @can('update', $album)
            <a href="{{ url('albums/edit/' . $album->id) }}" class="btn btn-primary">@lang('albums.edit-album')</a>
         @endcan

      </div><!-- end right-section-->
   </div><!-- end row of main-content -->

@endsection
