@extends('layouts.app')

@section('content')
<div class="row p-0 m-0 justify-content-center">
    <div class="col-md-12 p-0 m-0">
        <div class="card mb-3">
            <form action="{{ route('admin.check_list_groups.update', $checkListGroup) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card-header">
                {{ __('Edit Check List Group') }}
                @badge([
                    'type' => 'danger',
                    'text' => 'white',
                    'show' => now()->diffInMinutes($checkListGroup->created_at) < 5
                ]) new !
                @endbadge
            </div>
            @include('admin.checklistgroups.partials.form')
            <div class="card-footer">
                <button class="btn btn-sm btn-primary" type="submit"> {{ __('Update') }}</button>
            </div>
            </form>
        </div>
        <form action="{{ route('admin.check_list_groups.destroy', $checkListGroup) }}" method="POST">
            @csrf
            @method('DELETE')
            <button class="btn btn-sm btn-danger" type="submit"
                onclick="return confirm('{{ __('Are you sure?') }}')"> {{ __('Delete This Checklist Group') }}</button>
        </form>
    </div>
</div>
@endsection