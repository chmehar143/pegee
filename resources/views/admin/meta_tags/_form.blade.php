<form class="" method="POST"
      action="{{ $meta_tag->id ? route('meta_tags.update', ['id' => $meta_tag->id]) : route('meta_tags.store') }}">
    {{ csrf_field() }}
    @if($meta_tag->id)
        {{ method_field('PATCH') }}
    @endif

    <div class="form-group {{ $errors->has('resource_type') ? 'has-error' : '' }}">
        <label for="resource_id" class="control-label">Select Page</label>

        <select id="resource_id" name="resource_id" class="form-control">
            <option value="1"
                    data-type="home-page" {{old('resource_type') == 'home-page' && old('resource_id') == 1 ? 'selected' : ($meta_tag->resource_type == 'home-page' && $meta_tag->resource_id == 1 ? 'selected' : '')}}>
                Pages - Home
            </option>
            <option value="1"
                    data-type="shop-page" {{old('resource_type') == 'shop-page' && old('resource_id') == 1 ? 'selected' : ($meta_tag->resource_type == 'shop-page' && $meta_tag->resource_id == 1 ? 'selected' : '')}}>
                Pages - Shop
            </option>
            <option value="1"
                    data-type="deals-page" {{old('resource_type') == 'deals-page' && old('resource_id') == 1 ? 'selected' : ($meta_tag->resource_type == 'deals-page' && $meta_tag->resource_id == 1 ? 'selected' : '')}}>
                Pages - Today Deals
            </option>
            <option value="1"
                    data-type="sample-page" {{old('resource_type') == 'sample-page' && old('resource_id') == 1 ? 'selected' : ($meta_tag->resource_type == 'sample-page' && $meta_tag->resource_id == 1 ? 'selected' : '')}}>
                Pages - Free Sample Request
            </option>
            <option value="1"
                    data-type="track-page" {{old('resource_type') == 'track-page' && old('resource_id') == 1 ? 'selected' : ($meta_tag->resource_type == 'track-page' && $meta_tag->resource_id == 1 ? 'selected' : '')}}>
                Pages - Track Order
            </option>
            <option value="1"
                    data-type="view-cart-page" {{old('resource_type') == 'view-cart-page' && old('resource_id') == 1 ? 'selected' : ($meta_tag->resource_type == 'view-cart-page' && $meta_tag->resource_id == 1 ? 'selected' : '')}}>
                Pages - Your Cart
            </option>
            <option value="1"
                    data-type="checkout-page" {{old('resource_type') == 'checkout-page' && old('resource_id') == 1 ? 'selected' : ($meta_tag->resource_type == 'checkout-page' && $meta_tag->resource_id == 1 ? 'selected' : '')}}>
                Pages - Checkout
            </option>
            <option value="1"
                    data-type="my-orders-page" {{old('resource_type') == 'my-orders-page' && old('resource_id') == 1 ? 'selected' : ($meta_tag->resource_type == 'my-orders-page' && $meta_tag->resource_id == 1 ? 'selected' : '')}}>
                Pages - My Orders
            </option>
            <option value="1"
                    data-type="order-detail-page" {{old('resource_type') == 'order-detail-page' && old('resource_id') == 1 ? 'selected' : ($meta_tag->resource_type == 'order-detail-page' && $meta_tag->resource_id == 1 ? 'selected' : '')}}>
                Pages - Order Details Page
            </option>

            <option value="1"
                    data-type="blog_post-page" {{old('resource_type') == 'blog_post-page' && old('resource_id') == 1 ? 'selected' : ($meta_tag->resource_type == 'blog_post-page' && $meta_tag->resource_id == 1 ? 'selected' : '')}}>
                Pages - Blog
            </option>

            @foreach($static_pages as $static_page)
                <option value="{{$static_page->id}}"
                        data-type="static-page" {{old('resource_type') == 'static-page' && old('resource_id') == $static_page->id ? 'selected' : ($meta_tag->resource_type == 'static-page' && $meta_tag->resource_id == $static_page->id ? 'selected' : '')}}>
                    Pages
                    - {{$static_page->page_name}}</option>
            @endforeach
            @foreach($categories as $category)
                <option value="{{$category->id}}"
                        data-type="category" {{old('resource_type') == 'category' && old('resource_id') == $category->id ? 'selected' : ($meta_tag->resource_type == 'category' && $meta_tag->resource_id == $category->id ? 'selected' : '')}}>
                    Category
                    - {{$category->name}}</option>
            @endforeach
            @foreach($products as $product)
                <option value="{{$product->id}}"
                        data-type="product" {{old('resource_type') == 'product' && old('resource_id') == $product->id ? 'selected' : ($meta_tag->resource_type == 'product' && $meta_tag->resource_id == $product->id ? 'selected' : '')}}>
                    Product- {{$product->name}}</option>
            @endforeach

            @foreach($blog_posts as $blog_post)
                <option value="{{$blog_post->id}}"
                        data-type="blog_post" {{old('resource_type') == 'blog_post' && old('resource_id') == $blog_post->id ? 'selected' : ($meta_tag->resource_type == 'blog_post' && $meta_tag->resource_id == $blog_post->id ? 'selected' : '')}}>
                    Blog Post- {{$blog_post->name}}</option>
            @endforeach
        </select>
        <input type="hidden" id="resource_type" name="resource_type"
               value="{{ old("resource_type") ? old("resource_type") : ($meta_tag->resource_type ? $meta_tag->resource_type  : 'home-page') }}"/>
        @if ($errors->has('resource_type'))
            <span class="help-block"><strong>{{ $errors->first('resource_type') }}</strong></span>
        @endif
    </div>
    <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
        <label for="title" class="control-label">Title</label>
        <input type="text" class="form-control" name="title" id="title"
               value="{{old('title') ? old('title') : ($meta_tag->title ? $meta_tag->title : '')}}"/>
        @if ($errors->has('title'))
            <span class="help-block"><strong>{{ $errors->first('title') }}</strong></span>
        @endif
    </div>
    <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
        <label for="title" class="control-label">Description</label>
        <textarea class="form-control" name="description" id="description"
                  rows="5">{{old('description') ? old('description') : ($meta_tag->description ? $meta_tag->description : '')}}</textarea>
        @if ($errors->has('description'))
            <span class="help-block"><strong>{{ $errors->first('description') }}</strong></span>
        @endif
    </div>

    <div class="form-group">
        <div class="text-center">
            <button type="submit" class="btn btn-primary">
               @if($meta_tag->id)
                   Update
                    @else
                    Create
                @endif
            </button>
            <a href="{{route('meta_tags.index')}}" class="btn btn-info">
                Back
            </a>
        </div>
    </div>
</form>
<script type="text/javascript">
    $(document).ready(function () {
        $("#resource_id").on('change', function () {
            var selected = $(this).find('option:selected');
            $("#resource_type").val(selected.data('type'));
        });
    });
</script>