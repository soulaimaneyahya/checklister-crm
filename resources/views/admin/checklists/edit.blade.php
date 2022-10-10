@extends('layouts.app')

@section('content')
<div class="row p-0 m-0 justify-content-center">
    <div class="col-md-12 p-0 m-0">
        <div class="card mb-3">
            <form action="{{ route('admin.check_list_groups.check_lists.update', [$checkListGroup, $checkList]) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-header">
                    {{ __('Edit Check List') }}
                    @badge([
                        'type' => 'danger',
                        'text' => 'white',
                        'show' => now()->diffInMinutes($checkListGroup->created_at) < 5
                    ]) new !
                    @endbadge
                </div>
                @include('admin.checklists.partials.form')
                <div class="card-footer">
                    <button class="btn btn-sm btn-primary" type="submit"> {{ __('Update') }}</button>
                </div>
            </form>
        </div>
        <form action="{{ route('admin.check_list_groups.check_lists.destroy', [$checkListGroup, $checkList]) }}" method="POST">
            @csrf
            @method('DELETE')
            <button class="btn btn-sm btn-danger" type="submit"
                onclick="return confirm('{{ __('Are you sure?') }}')"> {{ __('Delete This List') }}</button>
        </form>
    </div>
</div>
<hr class="my-3" />
<div class="row p-0 m-0 justify-content-center">
    <div class="col-md-12 p-0 m-0">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <svg class="c-icon c-icon-lg">
                        <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-menu') }}"></use>
                    </svg> {{ __('List of Tasks') }}
                </div>
                <div>
                    <a href="{{ route('admin.check_lists.tasks.create', $checkList) }}" class="btn btn-dark btn-sm">
                        <svg class="c-icon c-icon-lg">
                            <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-playlist-add') }}"></use>
                        </svg> <span class="mx-1">{{ __('Add Task') }}</span>
                    </a>
                </div>
            </div>
            @livewire('tasks-table', ['checkList' => $checkList])
        </div>
    </div>
</div>
<hr class="my-3" />
@endsection
