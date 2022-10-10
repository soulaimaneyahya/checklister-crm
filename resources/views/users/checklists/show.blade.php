@extends('layouts.app')

@section('content')
<div class="row p-0 m-0 justify-content-center">
    <div class="col-md-12 p-0 m-0">
        <div class="card p-3">
            <h3 class="mb-3">{{ $checkList->name }}</h3>
            <p>{!! $checkList->description !!}</p>
        </div>
    </div>
</div>
@endsection