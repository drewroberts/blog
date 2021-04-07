@extends('support::layout')

@section('content')
    <ul>
        <li>Topic: {{ $topic->name }}</li>
        <li>Series: {{ $series->name }}</li>
    </ul>
@endsection
