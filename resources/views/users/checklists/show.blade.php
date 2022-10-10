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
                            <th></th>
                            <th>{{ __('Task name') }}</th>
                            <th></th>
                        </tr>
                    </thead>
                    @livewire('check-list-user-show', ['checkList' => $checkList])
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
