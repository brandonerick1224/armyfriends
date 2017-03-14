@forelse($posts as $post)
   <div class="single-post full-block" data-listen-to="{{ $post->getUniqueKey() }}">
      <div class="original-post full-block">
         <img src="{{ $post->user->pictureUrl('thumb')  }}" class="avatar pull-left" width="70px">
         <div class="post-content pull-left">
            <h5>{{ $post->user->profile->fullName() }}</h5>
            @if($post->hasMedia())
               <div class="post-image">
                  <a href="{{ $post->getFirstMediaUrl() }}" class="fancybox">
                     <img src="{{ $post->getFirstMediaUrl() }}" alt="" />
                  </a>
               </div>
            @endif
            <p class="break-all">{{ $post->content }}</p>
            <div class="post-date">{{ $post->created_at }}</div>
         </div>
      </div>
      <div class="post-meta">
         <div class="comment-btns pull-left">
            @can('update', $post)
            <a class="comment-btn" href="{{ url('posts/edit/' . $post->id) }}"><i class="fa fa-pencil "></i> @lang('common.edit')</a>
            @endcan
            @can('remove', $post)
            <a class="comment-btn" href="{{ url('posts/remove/' . $post->id) }}" onclick="return confirm('Are you sure?')"><i class="fa fa-remove "></i> @lang('common.delete')</a>
            @endcan
         </div>
         <div class="comment-btns text-right">
            @if($post->liked)
               <a href="{{ url('likes/unlike/posts/' . $post->id) }}" class="comment-btn like-btn like">
                  <i class="fa fa-thumbs-o-down"></i>
                  <span class="title-of-button">@lang('common.unlike')</span>
               </a>
            @else
               <a href="{{ url('likes/like/posts/' . $post->id) }}" class="comment-btn like-btn like">
                  <i class="fa fa-thumbs-o-up"></i>
                  <span class="title-of-button">@lang('common.like')</span>
               </a>
            @endif
            <a href="{{ url('likes/likes/posts/' . $post->id) }}" class="comment-btn likecount">{{ $post->likes_count ?: '' }}</a>
         </div>
      </div>

      <comments
         item-type="posts"
         :item-id="{{ $post->id }}"
         :user-id="{{ $post->user_id }}"
         :comments='<?php echo str_replace("'", "&#39;", $post->getVueComments()->toJson()) ?>'
      ></comments>

   </div><!-- end single-post-->
@empty
   <div class="col-xs-12">
      <p>@lang('posts.no-posts')</p>
   </div>
@endforelse