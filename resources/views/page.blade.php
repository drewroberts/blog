@extends('support::layout')

@section('content')
    {{ $page->name }}
    {{ $child_page->name }}
    {{ $grand_child_page->name }}
@endsection