@extends('support::base')

@section('content')
    {{-- DO NOT REMOVE - identity tag --}}
    <!-- T:{{ $topic->id }} -->

    {{-- Place holder content - safe to replace --}}
    <ul>
        <li>Topic: {{ $topic->name }}</li>
    </ul>
@endsection
