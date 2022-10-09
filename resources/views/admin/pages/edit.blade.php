@extends('layouts.app')

@section('content')
<div class="row p-0 m-0 justify-content-center">
    <div class="col-md-12 p-0 m-0">
        <div class="card mb-3">
            <form action="{{ route('admin.pages.update', $page) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-header">{{ __('Edit Page') }} ({{ $page->title }})</div>
                @include('admin.pages.partials.form')
                <div class="card-footer">
                    <button class="btn btn-sm btn-primary" type="submit"> {{ __('Update') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection