<div class="col-sm-3">
    <div class="panel panel-default">
        <div class="panel-heading">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                Filters
            </div>
        </div>
        <div class="panel-body">
            <form class="form-horizontal" method="GET" action="{{route('blog_posts.index')}}">
                <div class="table-responsive users-table">
                    <table class="table table-striped table-condensed data-table">
                        <tr>
                            <th>Name</th>
                        </tr>
                        <tr>
                            <td>
                                <input id="name" type="text" class="form-control" name="name"
                                       value="{{ Input::get('name', '') }}">
                            </td>
                        </tr>
                        <tr>
                            <th>Post Content</th>
                        </tr>
                        <tr>
                            <td>
                                <input id="postContent" type="text" class="form-control" name="postContent"
                                       value="{{ Input::get('postContent', '') }}">
                            </td>
                        </tr>
                        <tr>
                            <th>Publish Date</th>
                        </tr>
                        <tr>
                            <td>
                                <input id="publishDate" type="text" class="form-control datepicker" name="publishDate"
                                       value="{{ Input::get('publishDate', '') }}">
                            </td>
                        </tr>
                        <tr>
                            <th>Author Name</th>
                        </tr>
                        <tr>
                            <td>
                                <input id="authorName" type="text" class="form-control" name="authorName"
                                       value="{{ Input::get('authorName', '') }}">
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">
                        Search
                    </button>
                    <a href="{{route('blog_posts.index')}}" class="btn btn-default">
                        Reset Filters
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $(".datepicker").datepicker({
            autoclose: true,
            format: 'yyyy-mm-dd',
            todayHighlight: true
        });
    });
</script>