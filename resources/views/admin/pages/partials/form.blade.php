<div class="card-body">
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group">
                <label for="title">{{ __('Page Title') }}</label>
                <input class="form-control" name="title" type="text" value="{{ old('title', $page->title ?? '') }}" 
                placeholder="{{ __('Page title') }}" maxlength="255" id="title" required autofocus>
            </div>
            <div class="form-group">
                <label for="content">{{ __('Content') }}</label>
                <textarea class="form-control" id="textarea-desc-ckeditor" name="content" maxlength="500" placeholder="Page Content">{{ old('content', $page->content ?? '') }}</textarea>
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