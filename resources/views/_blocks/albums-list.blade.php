<div class="albums-list">
   @forelse($albums as $album)
      <div class="al-col">
         <div class="al-item{{ isset($current) && $album->current($current) ? ' al-current' : '' }}">
            <div class="al-image">
               <a href="{{ url('albums/view/' . $album->id) }}">
                  <img src="{{ $album->coverUrl() }}" alt="">
               </a>
            </div>
            <div class="al-footer">
               <div class="al-title">{{ $album->title }}</div>

               @if(! isset($current) || ! $album->current($current))
                  @can('update', $album)
                     <div class="al-buttons">
                        <a href="{{ url('albums/edit/' . $album->id) }}"><i class="fa fa-pencil"></i></a>
                     </div>
                  @endcan
               @endif
            </div>
         </div>
      </div>
   @empty
      <div class="al-col">
         <p>No albums</p>
         <br>
      </div>
   @endforelse
</div>

