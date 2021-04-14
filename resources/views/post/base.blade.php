@extends('support::base')

@section('content')
    {{-- DO NOT REMOVE - identity tag --}}
    <!-- T:{{ $topic->id ?? '0' }} S:{{ $series->id ?? '0' }} P:{{ $post->id }} -->

    {{-- Place holder content - safe to replace --}}
    <ul>
        <li>Topic: {{ $topic->name ?? 'NONE' }}</li>
        <li>Series: {{ $series->name ?? 'NONE' }}</li>
        <li>Post: {{ $post->name }}</li>
    </ul>
@endsection
