@extends('support::layout')

@section('content')
    <ul>
        <li>Page: {{ $page->name }}</li>
        <li>Child: {{ $child_page->name ?? 'NONE' }}</li>
        <li>Grand Child: {{ $grand_child_page->name ?? 'NONE' }}</li>
    </ul>
@endsection
