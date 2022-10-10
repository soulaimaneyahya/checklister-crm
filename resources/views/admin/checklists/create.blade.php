@extends('layouts.app')

@section('content')
<div class="row p-0 m-0 justify-content-center">
    <div class="col-md-12 p-0 m-0">
        <div class="card">
            <form action="{{ route('admin.check_list_groups.check_lists.store', $checkListGroup) }}" method="POST">
                @csrf
                <div class="card-header">{{ __('Create List') }}</div>
                @include('admin.checklists.partials.form')
                <div class="card-footer">
                    <button class="btn btn-sm btn-primary" type="submit"> {{ __('Save') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection