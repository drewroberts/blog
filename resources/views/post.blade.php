@extends('support::layout')

@section('content')
    <ul>
        <li>Topic: {{ $topic->name }}</li>
        <li>Series: {{ $series->name }}</li>
        <li>Post: {{ $post->name }}</li>
    </ul>
@endsection
