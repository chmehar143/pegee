<!-- start Bxslider -->
<ul class="slider">
    @if(!is_null($home_sliders) && count($home_sliders) > 0)
        @foreach($home_sliders as $slider)
            <li>
                @if($slider->layer_1)
                    <a href="{{$slider->layer_1}}">
                        @endif
                        <img src="{{ asset('uploads/slider/images/'. $slider->slider_image) }}" alt="{{$slider->layer_2}}" />
                        @if($slider->layer_1)
                    </a>
                @endif
            </li>
        @endforeach
    @else
        <li><img src="{{ asset('images/slider1.jpg') }}"></li>
    @endif
</ul>
<!-- end Bxslider-->

<!-- Js BxSlider Initialize the slider-->
<script type="text/javascript">
    $(document).ready(function () {
        $('.slider').bxSlider({
            responsive: true,
            auto: true,
            controls: false,
            hideControlOnEnd: false,
            pager: false,
            touchEnabled: false,
            adaptiveHeight: 450,
        });
    });
</script>