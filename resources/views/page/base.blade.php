@extends('support::base')

@section('content')
    {{-- DO NOT REMOVE - page identity tag --}}
    <!-- P:{{ $page->id }} C:{{ $child_page->id ?? '0' }} GC:{{ $grand_child_page->id ?? '0' }} -->


    {{-- Place holder content - safe to replace --}}
    <ul>
        <li>Page: {{ $page->name }}</li>
        <li>Child: {{ $child_page->name ?? 'NONE' }}</li>
        <li>Grand Child: {{ $grand_child_page->name ?? 'NONE' }}</li>
    </ul>
@endsection
