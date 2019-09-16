<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    Filters
                </div>
            </div>
            <div class="panel-body">
                <form method="GET" action="{{route('product.index')}}">
                    <div class="form-group col-md-3">
                        <select name="category" id="category-id" class="form-control">
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{$category->id}}" {{ Input::get('category') == $category->id ? 'selected' : '' }} >{{$category->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group  col-md-3">
                        <input id="product" type="text" class="form-control" name="product"
                               placeholder="Product Name"
                               value="{{ Input::get('product', '') }}">
                    </div>
                    <div class="form-group col-md-3">
                        <input id="description" type="text" class="form-control" name="description"
                               placeholder="Description"
                               value="{{ Input::get('description', '') }}">
                    </div>
                    <div class="form-group col-md-3">
                        <input id="price" type="text" class="form-control" name="price" placeholder="Price"
                               value="{{ Input::get('price', '') }}">
                    </div>
                    <div class="form-group col-md-3">
                        <input id="quantity" type="text" class="form-control" name="quantity" placeholder="Quantity"
                               value="{{ Input::get('quantity', '') }}">
                    </div>


                    <div class="form-group col-md-3">
                        <input id="code" type="text" class="form-control" name="code" placeholder="Code"
                               value="{{ Input::get('code', '') }}">
                    </div>

                    <div class="form-group col-md-3">
                        <select name="status" id="status" class="form-control">
                            <option value="">Select Product Status</option>
                            @foreach($statuses as $key => $status)
                                <option value="{{ $key }}" {{ Input::get('status') == $key ? 'selected' : '' }}>{{ $status }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <select id="outofstock" name="outofstock" class="form-control">
                            <option value="">Please select stock</option>
                            @foreach($stocks as $abr => $stock)
                                <option value="{{ $abr }}" {{ Input::get('outofstock') == $abr ? 'selected' : '' }}>{{ $stock }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-md-3">
                        <select id="samplerequest" name="samplerequest" class="form-control">
                            <option value="">Sample Request</option>
                            @foreach($sampleRequests as $abr => $sampleRequest)
                                <option value="{{ $abr }}" {{ Input::get('samplerequest') == $abr ? 'selected' : '' }}>{{ $sampleRequest }}</option>
                            @endforeach
                        </select>
                    </div>


                    <div class="form-group col-md-12 text-center">
                        <button type="submit" class="btn btn-primary">
                            Search
                        </button>
                        <a href="{{route('product.index')}}" class="btn btn-default">
                            Reset Filters
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>