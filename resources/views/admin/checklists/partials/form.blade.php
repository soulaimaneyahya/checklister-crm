<div class="card-body">
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group">
                <label for="checklist-name">{{ __('Name') }}</label>
                <input class="form-control" name="name" type="text" value="{{ old('name', $checkList->name ?? '') }}" 
                placeholder="{{ __('List name') }}" maxlength="255" id="checklist-name" required autofocus>
            </div>
            <div class="form-group">
                <label for="description">{{ __('CheckList Description') }}</label>
                <textarea class="form-control" name="description" id="textarea-desc" maxlength="500" placeholder="CheckList Description">{{ old('description', $checkList->description ?? '') }}</textarea>
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