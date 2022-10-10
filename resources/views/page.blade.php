@extends('layouts.app')

@section('content')
<div class="row p-0 m-0 justify-content-center">
    <div class="col-md-12 p-0 m-0">
        <div class="card px-4 pt-4">
            <h3>{{ $page->title }}</h3>
            <p>{!! $page->content !!}</p>
        </div>
    </div>
</div>
@endsection