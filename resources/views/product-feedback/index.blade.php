@extends('layouts.app')

@section('title', $title)

@section('content')
<!-- Section: inner-header -->
<div class="main-content">
    <div class="main_title chart_bg">
        <div class="container text-center">
            <h2 class="title">Customer Reviews</h2>
        </div>
    </div>

    <section class="divider">
        <div class="container">
            <nav class="navbar navbar-default">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <span class="navbar-brand" > Showing <?php echo $feedbacks->currentPage() . ' - ' . $feedbacks->lastPage() ?> of {{ $feedbacks->total() }} Reviews</span>
                    </div>

                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <div class="nav navbar-nav navbar-right">
                            <form class="form-inline star_rating_select" method="GET" action="{{ route('feedback.show', ['slug' => $product->slug] ) }}">
                                <label class="control-label">Filter By:</label>
                                <select class="form-control dropdown " name="rating" id="filter-by" onchange="this.form.submit()">
                                    <option value="">All stars</option>
                                    @foreach($ratings as $key => $rating)
                                    <option value="{{ $key }}" {{ Input::get('rating') == $key ? 'selected' : '' }}>{{ $rating }}</option>
                                    @endforeach
                                </select>
                            </form>
                        </div>
                    </div>
                </div>
            </nav>
            <div class="tab-content">
                <div class="reviews">
                    <ol class="commentlist">
                        @if(count($feedbacks) > 0)
                        @foreach($feedbacks as $feedback)
                        <li class="comment">
                            <div class="media-body">
                                <ul class="review_text list-inline mt-5">
                                    <li>
                                        <div title="{{ $feedback->rating }} out of 5">
                                          <div class="ratingPreview" data-rateyo-rating="{{$feedback->rating}}"></div>
                                        </div>
                                    </li>
                                    <li>
                                        <h5 class="media-heading meta"><span class="author">{{ $feedback->is_anonymous == 1 ? 'Anonymous User' : $feedback->getUser->first_name }}</span> – {{ Carbon\Carbon::parse($feedback->review_date)->format('M d, Y') }}</h5>
                                    </li>
                                </ul>
                                {{ $feedback->product_feedback }}
                            </div>
                        </li>
                        @endforeach
                        @else
                        Review not found
                        @endif
                    </ol>
                </div>
            </div>
            <div class="row text-center">
                <div class="col-md-12">
                    <nav>
                        {{ $feedbacks->links() }}
                    </nav>
                </div>
            </div>
        </div>
    </section>
</div>
    <script type="text/javascript">
        $('.ratingPreview').rateYo({
            normalFill: "#FFF",
            spacing: '3px',
            starWidth: '14px',
            strokeFill: '#ff9800',
            ratedFill: '#ff9800',
            strokeWidth: 20,
            numStars: 5,
            readOnly: true
        }); // Call the rating plugin for preview
    </script>
@endsection
