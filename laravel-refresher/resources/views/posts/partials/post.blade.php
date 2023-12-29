@if($loop->even)
<p>{{ $post['title']}}</p>
@else
<p style="background-color: aquamarine">{{ $post['title']}}</p>
@endif