@extends('layouts.app')

@section('content')
<div class="row p-0 m-0 justify-content-center">
    <div class="col-md-12 p-0 m-0">
        @livewire('header-totals-count', [
            'check_list_group_id' => $checkList->check_list_group_id,
            'check_list_id' => $checkList->id
        ])
    </div>
</div>
<div class="row p-0 m-0 justify-content-center">
    <div class="col-md-12 p-0 m-0">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <strong>
                    {{ __('CheckList: ') }}{{ $checkList->name }}
                </strong>
                <strong>
                    @if (auth()->user()->payment && auth()->user()->payment->payment_status == "approved")
                    ☑️ Pro Version
                    @endif
                </strong>
            </div>
            <div class="card-body p-3 m-0">
                <table class="table table-responsive-sm table-hover table-striped table-bordered" id="datatable">
                    <thead>
                        <tr>
                            <th></th>
                            <th>{{ __('Task name') }}</th>
                            <th></th>
                        </tr>
                    </thead>
                    @livewire('check-list-user-show', [
                        'checkList' => $checkList
                    ])
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
