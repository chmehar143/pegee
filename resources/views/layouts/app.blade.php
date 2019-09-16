<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <!-- Google Analytics -->
    <script>
        (function (i, s, o, g, r, a, m) {
            i['GoogleAnalyticsObject'] = r;
            i[r] = i[r] || function () {
                (i[r].q = i[r].q || []).push(arguments)
            }, i[r].l = 1 * new Date();
            a = s.createElement(o),
                m = s.getElementsByTagName(o)[0];
            a.async = 1;
            a.src = g;
            m.parentNode.insertBefore(a, m)
        })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');
        ga('create', 'UA-114989969-1', 'auto');
        ga('send', 'pageview');
    </script>

    <!-- Facebook Pixel Code -->
    <script>
        !function(f,b,e,v,n,t,s)
        {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
            n.callMethod.apply(n,arguments):n.queue.push(arguments)};
            if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
            n.queue=[];t=b.createElement(e);t.async=!0;
            t.src=v;s=b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t,s)}(window, document,'script',
            'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '234144747137794');
        fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
                   src="https://www.facebook.com/tr?id=234144747137794&ev=PageView&noscript=1"
        /></noscript>
    <!-- End Facebook Pixel Code -->
    <!-- End Google Analytics -->
    <meta name="viewport" content="width=device-width,initial-scale=1.0"/>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
    <meta name="description" content="@yield('meta_description')"/>
    <link rel="canonical" href="{{config('app.url')}}{{\Request::path() != '/' ? "/".\Request::path() : ''}}"/>
    <!-- Crazy Egg Script -->
    <script type="text/javascript" src="//script.crazyegg.com/pages/scripts/0037/3026.js" async="async"></script>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>
<!-- Favicon and Touch Icons -->
    <link href="{{ asset('images/favicon.png') }}" rel="shortcut icon" type="image/png">
    <link href="{{ asset('images/apple-touch-icon.png') }}" rel="apple-touch-icon">
    <link href="{{ asset('images/apple-touch-icon-72x72.png') }}" rel="apple-touch-icon" sizes="72x72">
    <link href="{{ asset('images/apple-touch-icon-114x114.png') }}" rel="apple-touch-icon" sizes="114x114">
    <link href="{{ asset('images/apple-touch-icon-144x144.png') }}" rel="apple-touch-icon" sizes="144x144">
    <!-- Custom Stylesheet -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/jquery-ui.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/animate.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/css-plugin-collections.css') }}" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.css">
    <!-- CSS | menuzord megamenu skins -->
    <link id="menuzord-menu-skins" href="{{ asset('css/menuzord-skins/menuzord-strip.css') }}" rel="stylesheet"/>
    <!-- CSS | Main style file -->
    <link href="{{ asset('css/style-main.css') }}" rel="stylesheet" type="text/css">
    <!-- CSS | Theme Color -->
    <link href="{{ asset('css/colors/theme-skin-lightgreen.css') }}" rel="stylesheet" type="text/css">
    <!-- CSS | Preloader Styles -->
    <link href="{{ asset('css/preloader.css') }}" rel="stylesheet" type="text/css">
    <!-- CSS | Custom Margin Padding Collection -->
    <link href="{{ asset('css/custom-bootstrap-margin-padding.css') }}" rel="stylesheet" type="text/css">
    <!-- CSS | Style css. This is the file where you can place your own custom css code. Just uncomment it and use it. -->
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet" type="text/css">
    <!--rating css-->
    {{--<link href="{{ asset('css/rating.css') }}" rel="stylesheet"/>--}}
    <!-- CSS | Responsive media queries -->
    <link href="{{ asset('css/responsive.css') }}" rel="stylesheet" type="text/css">
    <!-- Bxslider CSS -->
    <link href="{{ asset('css/jquery.bxslider.min.css') }}" rel="stylesheet" type="text/css">

    <link href="{{ asset('css/my-custom.css') }}" rel="stylesheet" type="text/css">
    <!-- Scripts -->
    <script src="{{ asset('js/jquery-2.2.4.min.js') }}"></script>
    <!-- external javascripts -->
    <script src="{{ asset('js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <!-- JS | jquery plugin collection for this theme -->
    <script src="{{ asset('js/jquery-plugin-collection.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.1.62/jquery.inputmask.bundle.js"></script>
    <!--rating js-->
    {{--<script src="{{ asset('js/rating.js') }}"></script>--}}
    <script src="{{ asset('js/jquery.rateyo.js') }}"></script>
    <!-- Bxslider JS -->
<!--<script src="{{ asset('js/jquery.bxslider.js') }}"></script>-->
    <script src="{{ asset('js/jquery.bxslider.min.js') }}"></script>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!--McAfee Script Code-->
    <script type="text/javascript" src="https://cdn.ywxi.net/js/1.js" async></script>
    <meta name="google-site-verification" content="JqiU_pEf7CgVOJo3d79TNTq39RlK0EQ4AMzVjBKZAsY"/>
    <meta name="msvalidate.01" content="5B5D206692D41F036E1AA89BBE61FF05"/>
    <script type="application/ld+json">
{ "@context" : "http://schema.org", "@type" : "LocalBusiness", "name" : "PetPads", "image" : "https://petpads.net/uploads/product/thumbnail/product_premium-training-potty-pads-30x36-150-per-case_M1Os2LP27mdmmI3MqF9ZXLzNUetgVBqV.jpeg", "priceRange" : "$$-$$$",
"address" : { "@type" : "PostalAddress", "streetAddress" : "1673 McDonald Ave", "addressLocality" : "Brooklyn", "addressRegion" : "NY", "postalCode" : "11230" },
"telephone": "844 777 6970", "email" : "info@petpads.net" }
    </script>
    <!-- Global site tag (gtag.js) - Google AdWords: 814712277 -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=AW-814712277"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'AW-814712277');
    </script>
</head>
<body class="">
<div id="wrapper">
    <!-- Header start -->
@include('layouts/_header-nav')
<!-- Header end -->
    <!-- Start main-content -->
    <div class="main-content">
        @yield('content')
    </div>
    <!-- End main-content -->
    @if(!isset($isCategoryPage))
    <hr>
    @endif
    <!-- First Autoship Modal -->
    <div class="modal fade" id="first-autoship-model" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="text-center widget-title line-bottom line- font-20">Save 20% on today's order when you
                        set up your first Autoship!</h4>
                    <h5 class="text-center">it's easy, select Autoship at checkout! No coupons necessary</h5>
                </div>
                <div class="modal-body">
                    <ul class="first-autoship-ul mt-5 modal-header">
                        <li class="">
                            <i class="fa fa-check fa-lg"></i><span
                                    class="first-autoship-span">Registered users only</span>
                        </li>
                        <li class="">
                            <i class="fa fa-check fa-lg"></i><span class="first-autoship-span">Cancel anytime, no hassles</span>
                        </li>
                        <li class="">
                            <i class="fa fa-check fa-lg"></i><span
                                    class="first-autoship-span">You set the schedule</span>
                        </li>
                        <li class="">
                            <i class="fa fa-check fa-lg"></i><span class="first-autoship-span">Save 5% on every Autoship order of select items</span>
                        </li>
                    </ul>
                    <div class="first-autoship-div text-center">
                        <span class=""><small>20% Off Promo: Maximum value of discount is 20%. Must select Autoship at checkout. Offer valid on first Autoship order only. Exclusions apply.</small></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Window -->
    <div class="modal fade" id="modal-window-video" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <!--            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title" id="myModalLabel"></h4>
                            </div>-->
                <div class="modal-body" style="padding: 9px;">
                    <video class="embed-responsive-item" id="videoContainer" preload="auto" controls="controls"
                           controlsList="nodownload" poster="" width="100%">
                        <source src="{{asset('wlmrt.mp4')}}" type='video/mp4'>
                    </video>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-theme-colored btn-circled" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#modal-window-video').on('hidden.bs.modal', function (e) {
                $("#videoContainer")[0].pause();
            })
        });
    </script>
    <!--First Autoship Model End Here-->
    <!-- Footer -->
    <footer id="footer" class="bg-black-22" style="background:#222">
        <div class="container pt-30">
            <div class="row border-bottom-black">
                <div class="col-sm-6 col-md-3">
                    <div class="widget">
                        <h5 class="widget-title line-bottom adjust_font_color">Useful Links</h5>
                        <ul class="list angle-double-right">
                            <li><a class="text-white" href="{{ route('homepage') }}">Home</a></li>
                            @if(count($nav_static_pages) > 0)
                                @foreach($nav_static_pages as $static_page)
                                    <li >
                                        <a href="{{ route('static-page', ['slug' => $static_page->slug])}}">{{ $static_page->page_name }}</a>
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="widget">
                        <h5 class="widget-title line-bottom adjust_font_color">Why Buy From Us</h5>
                        <ul class="list angle-double-right">
                            @if(count($footer_homepage) > 0)
                                @foreach($footer_homepage as $footer)
                                    <li>
                                        <a class="text-white"  href="{{ route('static-page', ['slug' => $footer->slug]) }}">{{ $footer->page_name }}</a>
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="widget">
                        <h5 class="widget-title line-bottom adjust_font_color">My Account</h5>
                        <ul class="list angle-double-right">
                            @if (Auth::guest())
                                <li><a class="text-white" href="{{ route('login') }}">Sign In</a></li>
                                <li><a class="text-white" href="{{ route('register') }}">Sign Up</a></li>
                            @else
                                <li><a class="text-white" href="{{ route('edit.profile') }}">Profile</a></li>
                                <li><a class="text-white" href="{{ route('logout') }}" onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">Sign Out</a>
                                </li>
                            @endif
                            <li><a class="text-white" href="{{ url('shop/cart') }}">View Cart </a></li>
                            <!--<li><a href="#">My Wishlist</a></li>-->
                            <li><a  class="text-white" href="{{ route('track.order') }}">Track My Order</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="widget">
                        <h5 class="widget-title line-bottom adjust_font_color">Stay Updated!</h5>
                        <form id="" class="newsletter-form" method="GET" action="{{ route('register') }}">
                            <div class="input-group">
                                <input type="email" value="{{ old('email') }}" name="email" placeholder="Your Email"
                                       class="form-control input-lg font-16" data-height="45px" id="mce-EMAIL-footer"
                                       style="height: 45px;">
                                <span class="input-group-btn">
                                            <button data-height="45px"
                                                    class="btn btn-colored btn-theme-colored btn-xs m-0 font-14"
                                                    type="submit">Subscribe</button>
                                        </span>
                            </div>
                        </form>
                    </div>

                    <div class="widget">
                        <a href="https://www.facebook.com/PetsWorld-Inc-159478731432418/" target="_blank"
                           style="text-decoration: none; margin: 0 2px"><img alt="Facebook" style="width: 32px;"
                                                                             src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAAABHNCSVQICAgIfAhkiAAAAAlwSFlzAAALEwAACxMBAJqcGAAABJlJREFUWIXFl21sU2UUx//n3LZuxYgKjheNCBghfMDQ25lioh8MLLi1vBjQRJN90ChoJGRi1xINTQ1B1rIIIX6YfCDg24eSkNEXBiEmhJhsoy1B40yUIKASTYjDANtoe8/xA7Rps5fW8fZP2uQ+zznn/3vO7XNvH+A+i2oNXLQu5KgbcTaxYDmUXMoylwRTBGwR4aqSnGWlPiXtySQC3wOkdwTA09T5aMFutUHxpjJ6FXpEifpv1F0/NxALXwOA51bsfkhsuQUCLCXRlQTMAWPXUP31vQOxcG7SAGZLpFVVtjHRASVjVybx4eVaVuVaEZlPjI+I4RHV9dlk4OT/AjDNLjtmDn5BxPMNw2rt695yvhbjUSC+HR4o7WfQ3nSifWdNAKbZZadZVw4pcGle/dx3Y7FXrcmYF/Xsqs8etlu5Q1D0ppOBLVUBXC2RAwwdSicDG27HuFyetZ31hRHrqApimVT7nvI5Lr8wfdG3mPBE2j303p0yB4Deg5uHbTljNbFsany5w10+V+rA4jXRBlteM7aCLO3vCf5RrahnbWd9ftgKksILYKYABgCAtTmbCGTHynH5oi9BZGfWPeRGOCxAWQcceW0naFct5gCQH7G+IsJWMFxgzGbGDGbMAKljvJxs3P8dkZ43s87XimMMAKY35AT0dYzonvGSy7V4TbSBgFcqBkUui+BvKFXZ98anaqGtAoDg9InS8czx4L+1ADjymFMxoNiWTgUfy6baZ47X/qLSCf8pgJxLfNufLgEIqIlBqVrMAUDIMir8Sf+sNRcAmDVpqNEEADYAIMBkxrZqiaZ353QWcatgYfkGJuiixubICgDI2e29Z7rbrkxUh5R6ReErB3iy33XtAuJVyEXcyjgyxsxGZWwEALvmFgKYEMAS6ywbxq1bEAqxCKS4LW5XNoftYrUYBzv+gchU4FYHmFGTOdnoolrSpaQNBF5TNnUSqgNKGO49uHm4Wh2x8qQ2VgBghMMicrMT1RL7D/sH0snABiVEyscV+k06GdiQSQTaxsutkKHTVG7eJr71dcGdrnuqpuQ7IAvGM0z4tQQA0lNChudeARCwlID+EgCBjgLqu1cASvAWlI6VAAatB1IEfaFx9fZpd9u8sTn6IgF/nU75L5QAzvZsukHK+6Rg++BuAyjpx0roLF6Xfvl5m72TIG8Un9F3Q6a3YzUgzkzcf3gUwJnutiuq7DfU9vWidaFxX6mTlael83GC7iLG+vK/7BV7P5NsjwHSVzfs3D/Rc4EuPZIhwazix15n2z+Rublsx9QcCnFRhE7Fgz9V1BoVHQqxO+38EkT2KVevt544ER6peZljaMnKjtlkIcGEb9OJQHTUYsZOUzJbIhElXQZLW7NHtvw4GXOzpaMZoM+J5JN0IrhvrJgJDyau5mgLs7UboGNMHO2P+3+rxdjtjTZCdSsIDRbh7dPx9h/Gi616NDO9ISfplHdA8j5AvwNIkXAfiXVuxDIGH6wXLihPV0sXKOvzEF0FpjyAaNocilV7y9Z8OAWUGr1Rj0KXC8gEZB4EU4nYUuggKf0C1j4R7TmdCv5ce937rP8ABb/ivoJuLEIAAAAASUVORK5CYII="
                                                                             data-filename="facebook.png"></a>
                        <a href="https://twitter.com/PetsWorldInc" target="_blank"
                           style="text-decoration: none; margin: 0 2px"><img alt="Twitter" style="width: 32px;"
                                                                             src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAAABHNCSVQICAgIfAhkiAAAAAlwSFlzAAALEwAACxMBAJqcGAAABWBJREFUWIXFV2tsVFUQ/mbu7bZQte0Wd0tr8IEBTSQkFrXFIEkfC+Gh/AGjECJCdwExKBoTRCQ1qAmPBCRot2vSQGJAmkgiUtttlTSCtkU0KMYECRTsY7clpVi0dts744+6m+12tyyPhO/fnZk73zfnzJ17DnCHQckGLj50xna1N9sFUCmgjwN4EIJ0MFsC9BFwDkCzKmob3I4TINLbIsDlu2SHpL4OlZeV0KRKX5sGWvoH6HzjOuc1AJi7+/I9SAtNtdQsJNZnReR+Yt6Vmdntq17yWOimBbgqg8tFdSsR7Q/p0K5GT97lZKqaWxGcbJFuIqUCYvLUuR3f3ZCAfK+mZGuwUqCTDcXyujUTW5MhjkVJZaCARfeB2Of3OHckJSDfqyl2Ch6GUEem3bGmeglZN0MexuyqK5m2UOgwSJvq3TkbryugtLJzP4H/8budq2+FOBoFOy+Nuys9pY6Zq/1u555oH8eQr1TwfYXtjrW3ixwAmt6Y1M/G4CKFrC+p6J4R7YusQOnHnQ5lOmWyWVjrntB2OwVEOCo7i0ixo7AjZ0Z5OQkAmBGvyW8R1Huz5MUVgWkG0UuicBLjdCjF5mtckdW7+NAZW1+fPaN2ZW53vXvit66KYOuJvODzAA5EBCzwto//F/IiNPXR2MQuX+eTUH4qdu+iUVIZeIGh+wEyeXhNl9oGQq+UVnbW9Pbw0zI4WBSOZbI+VBh7wwIYAELMCwloaPDYr47KLlwEkd0llYG3oTqqaYv3tGWzkA9gM9pOjPtV4CbWn43UlPlhe60n96QKxrt8wYcjAkTJBUVNvOoUOgBmYtD7Lm9XQ3FFYFq030y1FYORHu9dZjagSM/I7D440q5HVeACIj2g+SBsjStA+CslazszG2AUGaKnXRXBY8r4QoWbVcUx1jxNsdLcseNYgSZAF0YJoEkz250X6+MkMAzLpuAPBLKJwQxmAlBEQBGxJGYGIBAJGBnXRtkF5wg6vAVbtigzSMKfxWjQLACbGczx/YnByq2nPDQYa1c1ewicAYR7QJCwFHMo7XMASf2ERhFBG+PZbQZIWRQAuLychHl4JeIFH12beYXVmidA640KIB7+1GIhlpXNoF4gvALQi8cnBR9IlGgIaWdZcVxE+pIlF+hP/lXOhng+ZZoC0B8RAQw6aQyiIFGyBo/9KgjdzHx3cuQirPRqolMRkRYC2hIRoNA6MC0cK6nf7dwAUg+gPwIyqrFGEChv9Huc348hcYHJ4o8IMPr/qgFkVvGetuwxE1t8BEALBGbcABFV6OZ6j3NbohylFV3PiCBQsyr3IvD/HKhdP2XA5Q1WGTbeAGBTOHj2FjVteV3LoJiuhOkKaxbAJjjO5BFcAHhtvdtZO1YRSvqOQbQz/Bzp/AGbbacqloZnNAA0ltNQjzo+U9IWCP4W0IgmFEEPFEcAXZZh737Ev3pscpc3sIgh4+vKnF+GbSNKKfV2LVbom1lZ3bMSnWZdvkt2GJw+QOl9jSuyescijEbRJ5fzDLJOMMv8OvfE3+IKGBYR+IiI7i1sdyxNPB1vDCXengzGwDFV3l2/2rkv2jdq+MzscL6mgPyQFzw4u+pC2i2Tf9qdyxg4psQHYsmBRPcCVSr1BbaRoMQCLf9mdc6vN0Xu65oH1b1MeM9f5qyKFzPmxWRORdd8YWs3AD+A7fXuiReSIZ7r7XhiSI13QXCYrGW1ZTm/JIq97tVsgbd9fIgMt0LXQflPEGog1Gwwn7fSBq+MC5ncL0MTSHgqGDNV8BxBB2Ho9sK2nOrr9VHSl1Oo0hxvsEAJpSDKh+IhgWaAyGKVKwI+S9BmZaltKMv9Pem8dxr/AZ+EQbUsQUyXAAAAAElFTkSuQmCC"
                                                                             data-filename="twitter.png"></a>
                        <a href="https://www.pinterest.com/petsworldinc/" target="_blank"
                           style="text-decoration: none; margin: 0 2px"><img alt="Pinterest" style="width: 32px;"
                                                                             src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAAABHNCSVQICAgIfAhkiAAAAAlwSFlzAAALEwAACxMBAJqcGAAABLpJREFUWIXNl19sFFUUxn/n7rZACX8qgnR3WhAIKEYfbDEF0aS2XZMKig9CVILxDxqJRPENNRQSEkwKCYoPRoiEmohCIkkTS7uzSxMRbBEhEiMGK/23LTVoaQIIlO49PnS2aQo73QKJfi9z557zne+7dybnzsB/DMk0cR/zs3PpjQimHPRhi94LjDeYpKIXBWlWtAlMXRkdRwT0jhiow7kriK4DfQVMI3AQ9FiAvrMlnL8EUMuciVlcnQe6UJCnFTtDMNt7mLhzOb/23bIBl/AqQTYrWh3Ebi/h3F+ZrCpO/myLfV+gGMwbZXQcHpWB4xRmXaD7M4XZWQRXldDWmonwcEQJFxtkj8DOUhJbMzJwnMKsXv48AHT1kHhzOSRvRTyFBmZMTpI8ADSWkVg/IsHFqY7ifHo7osNxFGdclPB3Ls7a4TEz9CaG86qCc4TEmjtpYBGJKxZZpti3o+QX3TSpnnumRXE6Ggg7d1J8KOKEn4jhnKgcsvDBd8AlvBWkt5zEZr8itcwZk83VlcCzYO+3MEYwCYGDiv2knK6//fguoW8MZn8pib3gOakhL0fQFyB7hx+5jrz7glz9GdgFzAUaBdOgMBnYqJjf6sl71H8fzBbFrhvmKn+Fi1Ptv/LpU2OEOmM4l13yVwyPx3Bei+EkXUI9UfJDfrWihH5pwJkD3g4INiJQ60fKJrARTMjC6nI6vo4RWhojvDIVLyOxS9FqweQK9l2/WiDf9kNk0IAihUlMkx9F0edBWyIkvnQJLQFTA/JFDOeRwbJIvXct9atlkEbQokEDYAuO0t6WjnCYglzB5IKcHDBjlqRiSexgr7do38DVTvAzYKFZYeARVIIRjN0ENh1hHFMvWei36IQB13rZC50/StepVJ5gZnorPOdnwEAPyCRvnDKVHkX8dB1wQUpihB9SpNUL1Q41LiQj3vAHv3oBVFLHtfEKmMphXfFGkqwF22aRXNCF3nRLKh4lXGwxESBpCe72q2VhimB7AYLeRNtiCmZC+9l0pFI6/qiEuZvAxnC+8KbXxHHaLTpBkA0MNLaqCG2n/QwAcxV+HzQA/KjYYiCtAYBNYONMn6GQD3raIq0GPhcECxcFfa+Mzg9HEEeRhQrHwNt2A/WgS0ciDpADjw2MxI2QqFDsPIMpyiIwrZzOLRl+ii0JkIyCtwN9jK0N8s8Ol9CUkXo5yAJvFYcAyuk6k4nxFOI4jyfR7gjdbeDtQAXN1wyyG8wIHQwUnWqx3dcZUzca4RSS6AeC2Za6H3zzAwS3KbyY6tHpIHDFEFhfQfO10YrHcJYJklNGR81NE+KEn4sSatrH/Ox0RQ5RUDhaYU88HMVpjZP/wAiJoY+jhPeO1BdGA5dZk2I4J1xCLw2P3SBymK53DGoX43zVwIyxtyseJT8k9DUo7C2na09GJAVxCVfFcE5GcR68VfE44QqXcEsc5+V0Ob4/JlHCT4F+ZJBokkDVk7S3+OWn4OIsENhgsdMMsrqMzlPpckf8NashLycH87pF3zKYDoVaA00GPdtH/4Xx9JvLjL/bYOcJusgizwh6HUzV93Ts9ztlMzKQgoLECBULplzRQkFngZmkaFKQC6BnFJqUYF0GZ8H/B/8Ca0arVH47jugAAAAASUVORK5CYII="
                                                                             data-filename="pinterest.png"></a>
                        <a href="https://www.instagram.com/petsworldinc/" target="_blank"
                           style="text-decoration: none; margin: 0 2px"><img alt="Instagram" style="width: 32px;"
                                                                             src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAAABHNCSVQICAgIfAhkiAAAAAlwSFlzAAALEwAACxMBAJqcGAAABXlJREFUWIXNl31s1WcVxz/n3Jc2ZRkCA+PrcGPCvVCJK0vKMmhiBi4DtraCJi5hidPO+RI3M9f2NnpT0ze2JRvZNNn4Y+Ifaiz0wnQTzbKFYCMFTdSOe1vGsOiimYWCb2W39/7O8Y++eHtLey/MRL/J74/feZ5zvt/zvJ3ngf8xpNyO8V3JqOSyW11li8Gtav4RUxYpGgD/wPwMwgCuR9KHOvsB/68IiO9MLiXIPYLwOYfj7vwsrH7CNHo23dv+T4BV9yWvrxjPrjZ0o8A9Bjcq/jTh6L50b/vENQtY05DYjViHunw/n4s+ffqn7efLyWptfdvNgXobeK0ID2YOdh+7KgE1TU2R8dGlzwt6c2DB7uHDe0bKIb5CArUq7He3fZlUz5NlCahpaopcPr805eifM6E3HqK3N7gW8mmsvzf5ngmdSIEcz6S6WovbQ8WGJR/65PdM5MJQX9eDpNNlLaSF8Pbw0Xcq193240qPJJbH7rhudOiXJwrbtfAn1tj6gMMHh6ojX3q3xIV468BTlwlF6k38a+s+ldhQ2DYzBR9rSK6YkNxvIp7fOJh6/K3iINXbWpYEVfmKcggjE4ve+d3h9kvF9nhD2ydwfzK9PrKB9naDghHIee4xwZ+7EnmsMfFsUKFjBNG/lPPlQrmL8cZEZ3GcdKrzVdRH4q/nPzNtU4Ca7ckqUftsNmTPXClzgS+XytqwN4EEkHBjCKO5pqkpUtxP3LvN/ZFZAsaj+R2YvnK2d8/fih3KHXbQV9J9Xd3pvq5uEV5ECZ3Pvm/OIj+V6jmp5lXxnS2rZgSIB1tN/OXyiOahd5vJ1oU5mc+CyEsW6FaAMICJ1phKx9UQGjwnYi9MMuoD7ty/prFlHYDA+hK+xxF2zAgAPnx6bfgcBxZy8r8qMg6sBP/uUF934boYiDe2CsjnzfijKeMK806dm54JqU1NQTKpCja9LeaDwlPgbQAq8kJxu4hO2sSbBX9+oVgWsTF3Fk/FBYwFyf8jXQUgcKmaE9SpmhQ3+3C7EiqDvLhOlmulvd3QyZEo5RhYvh9wMW+uq0tOTx91dcmw4I9hZo72l4pjyDKFS5MCJk3nqgezK0s5Dh/eM2LwLMrdo8uyx2L1iS/GGlsfentZth/Ygugzmb7Oc6XiOOGPgr8B07sAPQleC5wt5fzeC5Gvjy7NXTbnYVVqQXDzCRd6VoxFvlnKH8DFN4pxYkYAzs8R+TTwg/ndRACOHm3PA83xnck94tkNAJEcJwdf6rqYme7pIgtddcRsu2toL0wVo1V3fbUiWrnoTYP1Q4d6LhR2XnVf8vro5dwl3EaA10BLlGgTRO8Cli2/ELluSvAMYo1tm8W9I53q2gxT94GxMyeC5bHNS0Tl9tHMsVcLHcYGj2ZviN0RuOsOUdmAcOvCn3zczCoQmn99pONXxfJWxDbtc2fv+aFjwzMjAJM3l5xkf0uYO9MHes4UO9bVJcMjK2cOrgWxcoR8ceaT2bfWY/Jo5lDXJqZuzbNmKt7QtsskeFRDFZtK3WavFrfsTHwgkrd+D4W3ZQ52nJq2z9r76VRnL+gAQW5/OedCubhpV/PiSJ6fECJZSD5HAMBQdeRhNyw+OPGjG+9PVr5b8tX3fOP9lbnQa678MH2wZ39x+3ybReKNiccNu9OD8O7hwx2D10Iea2y5W9Dv4PbtdKpnTv1YSAAAaxoS2xDbq66/yIfkidMHOv9QDvHahpbbTPRbjq0Ii3zh9YPdv5+vb8mnWc32ZNW/IrkmxL4iLn9C5GWQgbDnzsqi4GL276oejd4QDoLVLnI7JveKknPkiUx1uLdUlS37cQrImvqWWlXZYkiNwk2GLVY0wLgIfhphQDx05NShjkzpcP8n+DcNsVCmQuh0FQAAAABJRU5ErkJggg=="
                                                                             data-filename="instagram.png"></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom bg-black-333">
            <div class="container pt-20 pb-20">
                <div class="row">
                    <div class="col-md-4 card-icons">
                        <img src="{{ asset('images/batches/ax-plane-s.svg')}}" alt="American Express"
                             class="card-bacthes"/>
                        <img src="{{ asset('images/batches/discover-plane-s.svg')}}" alt="Discover"
                             class="card-bacthes"/>
                        <img src="{{ asset('images/batches/master-card-plane-s.svg')}}" alt="Master Card"
                             class="card-bacthes"/>
                        <img src="{{ asset('images/batches/visa-plane-s.svg')}}" alt="Visa" class="card-bacthes"/>
                    </div>
                    <div class="col-md-4 text-center">
                        <p class="font-11 text-black-777 m-0 copyright">petpads.net | 1673 McDonald Ave Brooklyn, NY 11230 | 844 777 6970
                            <br/>
                            Copyright &copy;
                            2017 {{ config('app.name', 'PetsWorld, Inc.') }}. All Rights Reserved</p>

                        <g:plusone size="medium"></g:plusone>
                    </div>
                    <div class="col-md-4 text-right">
                        <div class="widget no-border m-0">
                            <ul class="list-inline sm-text-center mt-5 font-12">
                                <!-- <li>
                                    <a href="https://www.bbb.org/new-york-city/business-reviews/pet-supplies/petsworld-inc-in-brooklyn-ny-172572/#sealclick" target="_blank" rel="nofollow"><img src="https://seal-newyork.bbb.org/seals/blue-seal-96-50-bbb-172572.png" style="border: 0;" alt="PetsWorld, Inc. BBB Business Review" /></a>
                                    <script src="https://apis.google.com/js/platform.js" async defer></script>
                                </li> -->
                                <li>
                                    <!-- (c) 2005, 2018. Authorize.Net is a registered trademark of CyberSource Corporation --> <div class="AuthorizeNetSeal"> <script type="text/javascript" language="javascript">var ANS_customer_id="18e7b25d-13d7-4bab-b4a4-0a41d68ab946";</script> <script type="text/javascript" language="javascript" src="https://verify.authorize.net/anetseal/seal.js" ></script> </div>
                                </li>
								<li>
								<script src="https://apis.google.com/js/platform.js?onload=renderBadge" async defer></script>

								<script>
								  window.renderBadge = function() {
									var ratingBadgeContainer = document.createElement("div");
									document.body.appendChild(ratingBadgeContainer);
									window.gapi.load('ratingbadge', function() {
									  window.gapi.ratingbadge.render(ratingBadgeContainer, {"merchant_id": 125279986});
									});
								  }
								</script>
								</li>

                            </ul>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <a class="scrollToTop" href="#"><i class="fa fa-angle-up"></i></a>
</div>
<!-- Footer Scripts -->
<!-- JS | Custom script for all pages -->
<script src="{{ asset('js/custom.js') }}"></script>
<!--Start of Tawk.to Script-->
<script type="text/javascript">
    var Tawk_API = Tawk_API || {}, Tawk_LoadStart = new Date();
    (function () {
        var s1 = document.createElement("script"), s0 = document.getElementsByTagName("script")[0];
        s1.async = true;
        s1.src = 'https://embed.tawk.to/59f88a9d4854b82732ff9297/default';
        s1.charset = 'UTF-8';
        s1.setAttribute('crossorigin', '*');
        s0.parentNode.insertBefore(s1, s0);
    })();
    $(document).ready(function () {
        $('#chat-live').on('click', function () {
            Tawk_API.maximize();
        });
    });
</script>
<!--End of Tawk.to Script-->
</body>
</html>