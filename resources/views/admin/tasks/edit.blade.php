@extends('layouts.app')

@section('content')
<div class="row p-0 m-0 justify-content-center">
    <div class="col-md-12 p-0 m-0">
        <div class="mb-3">
            <a href="{{ route('admin.check_list_groups.check_lists.edit', [$checkList->check_list_group_id, $checkList]) }}" class="btn btn-sm btn-dark">Back</a>
        </div>
        <div class="card mb-3">
            <form action="{{ route('admin.check_lists.tasks.update', [$checkList, $task]) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-header">{{ __('Edit Task') }}</div>
                @include('admin.tasks.partials.form')
                <div class="card-footer">
                    <button class="btn btn-sm btn-primary" type="submit"> {{ __('Update') }}</button>
                </div>
            </form>
        </div>
        <form action="{{ route('admin.check_lists.tasks.destroy', [$checkList, $task]) }}" method="POST">
            @csrf
            @method('DELETE')
            <button class="btn btn-sm btn-danger" type="submit"
                onclick="return confirm('{{ __('Are you sure?') }}')"> {{ __('Delete This Task') }}</button>
        </form>
    </div>
</div>
@endsection