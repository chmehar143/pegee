<form method="POST"
      action="{{ $blog_post->id ? route('blog_posts.update', ['id' => $blog_post->id]) : route('blog_posts.store') }}">
    @if($blog_post->id)
        {{ method_field('PATCH') }}
    @endif
    {{ csrf_field() }}

    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
        <label for="name" class="control-label">Name</label>

        <input id="name" type="text" class="form-control" name="name"
               value="{{ old('name') ? old('name') : $blog_post->name }}" required autofocus>

        @if ($errors->has('name'))
            <span class="help-block">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
        @endif

    </div>

    <div class="form-group{{ $errors->has('blog_category_id') ? ' has-error' : '' }}">
        <label for="name" class="control-label">Blog Category</label>
        <select id="blog_category_id" name="blog_category_id" class="form-control" >
            <option value="">Please Select</option>
            @foreach($blog_categories as $blog_category)
                <option value="{{$blog_category->id}}" {{old('blog_category_id') && old('blog_category_id') == $blog_category->id ? 'selected' : ($blog_post->blog_category_id == $blog_category->id ? 'selected' : '') }}>{{$blog_category->name}}</option>
            @endforeach
        </select>

        @if ($errors->has('blog_category_id'))
            <span class="help-block">
                            <strong>{{ $errors->first('blog_category_id') }}</strong>
                        </span>
        @endif

    </div>

    <div class="form-group{{ $errors->has('post_content') ? ' has-error' : '' }}">
        <label for="post_content" class="control-label">Post Content</label>

        <textarea id="post_content" type="text" class="form-control" name="post_content">{{ old('post_content') ? old('post_content') : $blog_post->post_content }}</textarea>

        @if ($errors->has('post_content'))
            <span class="help-block">
                                <strong>{{ $errors->first('post_content') }}</strong>
                            </span>
        @endif

    </div>

    <div class="form-group{{ $errors->has('publish_date') ? ' has-error' : '' }}">
        <label for="publish_date" class="control-label">Publish Date</label>

        <input id="publish_date" type="text" class="form-control datepicker" name="publish_date"
               value="{{ old('publish_date') ? old('publish_date') : $blog_post->publish_date }}" required>

        @if ($errors->has('publish_date'))
            <span class="help-block">
                                <strong>{{ $errors->first('publish_date') }}</strong>
                            </span>
        @endif

    </div>

    <div class="form-group{{ $errors->has('author_name') ? ' has-error' : '' }}">
        <label for="author_name" class="control-label">Author Name</label>

        <input id="author_name" type="text" class="form-control" name="author_name"
               value="{{ old('author_name') ? old('author_name') : $blog_post->author_name }}" required>

        @if ($errors->has('author_name'))
            <span class="help-block">
                                <strong>{{ $errors->first('author_name') }}</strong>
                            </span>
        @endif
    </div>
    <div class="form-group">
        <label for="is_published" class="control-label">Published?</label>

        <input id="is_published" type="checkbox" name="is_published"
               {{old('is_published') ? 'checked' : ($blog_post->is_published ? 'checked' : '') }}
               value="1"/>
    </div>


    <div class="form-group">
        <div class="text-center">
            <button type="submit" class="btn btn-primary">
                Save
            </button>
            <a href="{{route('blog_posts.index')}}" class="btn btn-info">
                Back
            </a>
        </div>
    </div>
</form>

<script type="text/javascript">
    $(document).ready(function () {
        $('#post_content').summernote({
            height: 300, // set editor height
            minHeight: null, // set minimum height of editor
            maxHeight: null, // set maximum height of editor
        });
        $(".datepicker").datepicker({
            autoclose: true,
            format: 'yyyy-mm-dd',
            todayHighlight: true
        });

    });

</script>