@extends('layouts.app')

@section('content')
<div class="row p-0 m-0 justify-content-center">
    <div class="col-md-12 p-0 m-0">
        <div class="mb-3">
            <a href="{{ route('admin.check_list_groups.check_lists.edit', [$checkList->check_list_group_id, $checkList]) }}" class="btn btn-sm btn-dark">Back</a>
        </div>
        <div class="card">
            <form action="{{ route('admin.check_lists.tasks.store', $checkList) }}" method="POST">
                @csrf
                <div class="card-header">{{ __('Create Task') }}</div>
                @include('admin.tasks.partials.form')
                <div class="card-footer">
                    <button class="btn btn-sm btn-primary" type="submit"> {{ __('Save') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
