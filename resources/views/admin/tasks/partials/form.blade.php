<div class="card-body">
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group">
                <label for="task-name">{{ __('Task Name') }}</label>
                <input class="form-control" name="name" type="text" value="{{ old('name', $task->name ?? '') }}" 
                placeholder="{{ __('Task name') }}" maxlength="255" id="task-name" required autofocus>
            </div>
            <div class="form-group">
                <label for="description">{{ __('Task Description') }}</label>
                <textarea class="form-control" id="textarea-desc-ckeditor" name="description" maxlength="800" placeholder="Task Description">{{ old('description', $task->description ?? '') }}</textarea>
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