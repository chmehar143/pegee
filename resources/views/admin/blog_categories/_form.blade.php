<form method="POST"
      action="{{ $blog_category->id ? route('blog_categories.update', ['id' => $blog_category->id]) : route('blog_categories.store') }}">
    @if($blog_category->id)
        {{ method_field('PATCH') }}
    @endif
    {{ csrf_field() }}

    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
        <label for="name" class="control-label">Name</label>

        <input id="name" type="text" class="form-control" name="name"
               value="{{ $errors->has('name') ? old('name') : $blog_category->name }}" required autofocus/>

        @if ($errors->has('name'))
            <span class="help-block">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
        @endif

    </div>


    <div class="form-group">
        <div class="text-center">
            <button type="submit" class="btn btn-primary">
                Save
            </button>
            <a href="{{route('blog_categories.index')}}" class="btn btn-info">
                Back
            </a>
        </div>
    </div>
</form>