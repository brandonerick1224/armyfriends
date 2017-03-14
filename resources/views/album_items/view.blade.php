@extends('_layouts.home')

@section('head')
   <link rel="stylesheet" href="{{ asset('assets/css/image-tags.css') }}">
@endsection

@section('content')

   <div class="window-header">
      <a class="window-close" href="#"><i class="fa fa-times"></i></a>
   </div>
   <div class="main-row">
      <div class="left-section col-md-4 pad-big">

         <h2 class="section-title">@lang('albums.albums')</h2>

         @include('_blocks.albums-list', ['albums' => $albums, 'current' => $item->album])

      </div><!-- end left-section of main content -->

      <div class="right-section col-md-8 pad-big">
         <h2 class="section-title">@lang('albums.image')</h2>

         <div class="single-image" data-listen-to="{{ $item->getUniqueKey() }}">

            <div class="si-top-btns row">
               <div class="col-sm-4">
                  @if($item->prev())
                     <a href="{{ url('album_items/view/' . $item->prev()->id) }}" class="btn btn-primary">@lang('pagination.previous')</a>
                  @endif
               </div>
               <div class="col-sm-4 text-center">
                  <a href="{{ url('albums/view/' . $item->album->id) }}" class="btn btn-primary">@lang('albums.back-to-album')</a>
               </div>
               <div class="col-sm-4 text-right">
                  @if($item->next())
                     <a href="{{ url('album_items/view/' . $item->next()->id) }}" class="btn btn-primary">@lang('pagination.next')</a>
                  @endif
               </div>
            </div>

            <div class="si-image">
               <a href="{{ $item->getFirstMediaUrl() }}" class="fancybox" rel="group">
                  <img class="si-img" src="{{ $item->getFirstMediaUrl() }}" alt="">
               </a>
            </div>

            <div class="si-title-form">
               @can('update', $item)
                  <form action="{{ url('album_items/update/' . $item->id) }}" method="post">
                     {{ csrf_field() }}
                     <div class="input-group">
                        <input class="form-control" type="text" id="album_item_title" name="title" value="{{ old('title', $item->title) }}" placeholder="Title"/>
                        <span class="input-group-btn">
                          <button class="btn btn-default" type="submit"><i class="fa fa-save"></i></button>
                        </span>
                     </div><!-- /input-group -->
                  </form>
               @else
                  <p>{{ $item->title }}</p>
               @endcan
            </div>

            <div class="si-bottom-btns clearfix">
               <div class="pull-left">
                  @can('remove', $item)
                     <a href="{{ url('album_items/remove/' . $item->id) }}" class="btn btn-danger" onclick="return confirm('Are you sure?')"><i class="fa fa-trash-o"></i> @lang('common.delete')</a>
                  @endcan
               </div>
               <div class="pull-right">
                  @can('as-profile', $item)
                     <a href="{{ url('album_items/as-profile/' . $item->id) }}" class="btn btn-success"><i class="fa fa-image"></i> @lang('albums.set-as-profile')</a>
                  @endcan
                  @if($item->liked)
                     <a href="{{ url('likes/unlike/album_items/' . $item->id) }}" class="btn btn-danger"><i class="fa fa-thumbs-o-down"></i> @lang('common.unlike')</a>
                  @else
                     <a href="{{ url('likes/like/album_items/' . $item->id) }}" class="btn btn-success"><i class="fa fa-thumbs-o-up"></i> @lang('common.like')</a>
                  @endif
                  <a href="{{ url('likes/likes/album_items/' . $item->id) }}" class="btn btn-success">{{ $item->likes_count }}</a>
               </div>
            </div>

            <comments
               class="album-item-comments"
               item-type="album_items"
               :item-id="{{ $item->id }}"
               token="{{ csrf_token() }}"
               action="{{ url('comments/add/album_items/' . $item->id) }}"
               :comments='<?php echo $item->getVueComments()->toJson() ?>'
            ></comments>

         </div>

      </div><!-- end right-section-->
   </div><!-- end row of main-content -->

@endsection

@section('foot')
   <script src="{{ asset('assets/js/image-tags.js') }}"></script>
   <script>
      jQuery(function($){
         $('.si-image').imageTags({
            tags: {!! $item->getUserTagsData()->toJson() !!},
            tagUrl: '{{ url('user_tag/tag/' . $item->id) }}',
            untagUrl: '{{ url('user_tag/untag') }}',
            usersUrl: '{{ url('user_tag/users') }}',
            canTag: {{ Gate::allows('tag', $item) ? 'true' : 'false' }},
            userId: {{ auth()->id() }},
         });
      });
   </script>
@endsection