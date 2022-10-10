@extends('layouts.app')

@section('content')
<div class="row p-0 m-0 justify-content-center">
    <div class="col-md-12 p-0 m-0">
        <div class="card mb-3">
            <form action="{{ route('admin.check_list_groups.check_lists.update', [$checkListGroup, $checkList]) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-header">{{ __('Edit Check List') }}</div>
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
            <div class="card-body p-3 m-0">
                <table class="table table-responsive-sm table-hover table-striped table-bordered">
                    <thead>
                        <tr>
                            <td scope="col"></td>
                            <td scope="col">{{ __('Name') }}</td>
                            <td scope="col">{{ __('Edit / Delete') }}</td>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse ($tasks as $key => $task)
                        @include('admin.tasks.partials.task')
                    @empty
                        <tr>
                            <td colspan="2" class="text-center">{{ __('No Tasks Found') }}</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-3">
                {{ $tasks->links() }}
            </div>
        </div>
    </div>
</div>
<hr class="my-3" />
@endsection
