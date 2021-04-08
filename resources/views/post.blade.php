@extends('support::layout')

@section('content')
    <ul>
        <li>Topic: {{ $topic->name ?? 'NONE' }}</li>
        <li>Series: {{ $series->name ?? 'NONE' }}</li>
        <li>Post: {{ $post->name }}</li>
    </ul>
@endsection
