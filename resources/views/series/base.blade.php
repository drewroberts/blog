@extends('support::base')

@section('content')
    {{-- DO NOT REMOVE - identity tag --}}
    <!-- T:{{ $topic->id }} S:{{ $series->id }} -->

    {{-- Place holder content - safe to replace --}}
    <ul>
        <li>Topic: {{ $topic->name }}</li>
        <li>Series: {{ $series->name }}</li>
    </ul>
@endsection
