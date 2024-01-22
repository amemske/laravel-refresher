@if($loop->even)
<p>{{ $post['title']}}</p>
@else
<p style="background-color: aquamarine">{{ $post['title']}}</p>
@endif

<div>
     <form action="{{ route('posts.destroy', ['post' => $post->id])}}" method="POST">
        @csrf
        @method('DELETE')
        <input type="submit" value="Delete">

     </form>
</div>