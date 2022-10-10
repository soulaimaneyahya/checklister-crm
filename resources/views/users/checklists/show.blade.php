@extends('layouts.app')

@section('content')
<div class="row p-0 m-0 justify-content-center">
    <div class="col-md-12 p-0 m-0">
        <div class="card">
            <div class="card-header">{{ __('Check List: ') }} ({{ $checkList->name }})</div>
            <div class="card-body p-3 m-0">
                <table class="table table-responsive-sm table-hover table-striped table-bordered" id="datatable">
                    <thead>
                        <tr>
                            <th>{{ __('Task name') }}</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($checkList->tasks as $task)
                        <tr class="task-description-toggle" data-id="{{ $task->id }}">
                            <td class="w-75" colspan="2">{{ $task->name }}</td>
                            <td>
                                <svg id="task-caret-bottom-{{ $task->id }}" class="m-0 c-sidebar-nav-icon">
                                    <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-caret-bottom') }}"></use>
                                </svg>
                                <svg id="task-caret-top-{{ $task->id }}" class="m-0 c-sidebar-nav-icon d-none">
                                    <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-caret-top') }}"></use>
                                </svg>
                            </td>
                        </tr>
                        <tr class="d-none" id="task-description-{{ $task->id }}">
                            <td colspan="3" class="p-3">{!! $task->description !!}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    $('.task-description-toggle').click(function () { 
        $('#task-description-' + $(this).data('id')).toggleClass('d-none');
        $('#task-caret-bottom-' + $(this).data('id')).toggleClass('d-none');
        $('#task-caret-top-' + $(this).data('id')).toggleClass('d-none');
    });
</script>
@endsection
