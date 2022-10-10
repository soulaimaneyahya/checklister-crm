@extends('layouts.app')
@section('styles')
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.css">
@section('content')
<div class="row p-0 m-0 justify-content-center">
    <div class="col-md-12 p-0 m-0">
        <div class="card">
            <div class="card-header">{{ __('Manage Users') }}</div>
            <div class="card-body p-3 m-0">
                <table class="table table-responsive-sm table-hover table-striped table-bordered" id="datatable">
                    <thead>
                        <tr>
                            <th>{{ __('#') }}</th>
                            <th>{{ __('Register Time') }}</th>
                            <th>{{ __('Name') }}</th>
                            <th>{{ __('Email') }}</th>
                            <th>{{ __('Website') }}</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.js"></script>
<script>
    $(document).ready( function () {
        $('#datatable').DataTable({
            "pageLength": 10,
            "processing": true,
            "serverSide": true,  
            "ajax": "{{ route('api.admin.users') }}",
            "columns": [
                { "data": "id" },
                { "data": "created_at" },
                { "data": "name" },
                { "data": "email" },
                { "data": "website" },
            ]
        });
    });
</script>
@endsection