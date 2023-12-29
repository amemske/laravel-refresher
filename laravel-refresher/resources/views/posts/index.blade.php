@extends('layouts.app')

@section('title', 'Blog Posts')

@section('content')


    {{-- @foreach ($posts as $key => $post)
        <p>{{ $post['title']}}</p>
    @endforeach --}}

   {{-- @break($key == 2)
   @continue($key == 1) --}}

   {{-- @each('posts.partials.post', $posts, 'post') --alternative to for loop --}}

    @forelse ($posts as $post)

       @include('posts.partials.post')
    
    @empty
        No posts found!
    @endforelse


@endsection
