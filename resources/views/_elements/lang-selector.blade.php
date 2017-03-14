<div class="dropup">
   <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">{{ mb_convert_case(array_get(config('laravellocalization.supportedLocales.' . App::getLocale()), 'native'), MB_CASE_TITLE) }}
      <span class="caret"></span></button>
   <ul class="dropdown-menu">
      @foreach(config('laravellocalization.supportedLocales') as $key => $item)
         <li><a href="{{ url('/locale/change?locale=' . $key) }}">{{ mb_convert_case($item['native'], MB_CASE_TITLE) }}</a></li>
      @endforeach
   </ul>
</div>