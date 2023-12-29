@extends('layouts.app')

@section('title', $post['title'])

@section('content')
@if ($post['is_new'])
<p> Latest News</p>
    
@else
<p> Old News</p>
@endif

@unless ($post['is_new'])
    <p>It is an old post ... using unless directive</p>
@endunless

@isset($post['has_comments'])
    <p>See comments</p>
@endisset
<h1>{{ $post['title'] }}</h1>
<p>{{$post['content']}}</p>
   
@endsection
