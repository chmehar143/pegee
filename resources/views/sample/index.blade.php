@extends('layouts.app')
@section('title', isset($meta_tags) ? $meta_tags->title : $title . " - " . config('app.name', 'PetsWorld, Inc'))
@section('meta_description', isset($meta_tags) ? $meta_tags->description : '')
@section('content')

    <div class="main-content">
        <div class="main_title chart_bg">
            <div class="container text-center">
                <h2 class="title">Sample Request</h2>
            </div>
        </div>

        <section class="divider">
        <div class="container">
            @if (session('success'))
                <div class="alert alert-success">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> {{ session('success') }}
                </div>
            @elseif(session('error'))
                <div class="alert alert-danger">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> {{ session('error') }}
                </div>
            @endif
            <div class="section-content">
                <div class="row mt-30">
                    @if($success)
                        @include("sample._form")
                    @elseif($already_submitted)
                        @include("sample._details")
                    @endif
                </div>
            </div>
        </div>
        </section>
    </div>

    @include('sample._size_chart_model')


    <script type="text/javascript">
        $(document).ready(function () {
            $('#sample-request').submit(function () {
                $(this).find(':input[type=submit]').prop('disabled', true);
                $(".gender_class").prop('disabled', false);
            });
        });

        $(window).load(function () {
            var phones = [{"mask": "(###) ###-####"}];
            $('#phone-no').inputmask({
                mask: phones,
                greedy: false,
                definitions: {'#': {validator: "[0-9]", cardinality: 1}}
            });
        });

    </script>

@endsection