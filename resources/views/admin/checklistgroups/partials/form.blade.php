<div class="card-body">
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group">
                <label for="checklist-group-name">{{ __('Name') }}</label>
                <input class="form-control" name="name" type="text" value="{{ old('name', $checkListGroup->name ?? '') }}" 
                placeholder="{{ __('Checklist Group name') }}" maxlength="255" id="checklist-group-name" required autofocus>
            </div>
            <div class="form-group">
                <label for="description">{{ __('Check List Group Description') }}</label>
                <textarea class="form-control" name="description" id="textarea-desc" maxlength="500" placeholder="Check List Group Description">{{ old('description', $checkListGroup->description ?? '') }}</textarea>
            </div>
            @if ($errors->any())
            <ul>
                @foreach ($errors->all() as $error)
                    <li class="text-danger">{{ $error }}</li>
                @endforeach
            </ul>
            @endif
        </div>
    </div>
</div>
@section('scripts')
@include('partials.ckeditor')
@endsection