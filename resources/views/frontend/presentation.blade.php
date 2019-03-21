<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $presentation->title }}</title>
    <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/jquery.fancybox.css') }}"/>
    <link rel="stylesheet" href="{{ asset('css/frontend.css') }}"/>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css"/>
    <link href="https://fonts.googleapis.com/css?family=Lato|Roboto" rel="stylesheet">
</head>
<body>

{{--{{ dd($presentation) }}--}}

<div class="wmo-splash-screen">
    <div class="wmo-container">
        @include('frontend.splash',['slide'=>$slideId ? $presentation->slides->first() : $presentation->present()->introSection->slides->first() ])
    </div>

    @if(!$slideId)
        <div class="wmo-splash-screen-close" style="display: none">
            <a href="#" class="wmo-splash-screen-close__link js__go_back"></a>
        </div>
    @endif
</div>

<header class="wmo-headline">
    <div class="wmo-headline-wrap">
        <h1>
            <span>{{ $presentation->title }}</span>
            @if(strlen($presentation->title)<= 26)
                <span style="font-weight: 100">{{ $presentation->present()->createdShort() }}</span>
            @endif</h1>

        @if(!$slideId)
            <div class="wmo-hearline-breadcrumbs">
                <ul class="wmo-hearline-breadcrumbs__list">
                    <li class="wmo-hearline-breadcrumbs__item">
                        <a href="#" class="wmo-hearline-breadcrumbs__link js__go_back"
                           style="font-size: 1rem!important">
                            Home
                        </a>
                    </li>
                    <li class="wmo-hearline-breadcrumbs__item wmo-hearline-breadcrumbs__item--section-name"
                        style="font-size: 1rem!important"></li>
                    <li class="wmo-hearline-breadcrumbs__item wmo-hearline-breadcrumbs__item--slide-name"
                        style="font-size: 1rem!important"></li>
                </ul>
            </div>
        @endif
        <div class="wmo-headline-textureline">

        </div>
        <div class="wmo-art-strip"
             @if($presentation->color)style="background-color: rgb({{$presentation->color}}) !important" @endif></div>
        <div class="wmo-persimmon-logo">
            @if($presentation->image)
                <img class="wmo-persimmon-logo__image" style="width: 100%;height: 100%;"
                     src="{{asset('img/presentations/'.$presentation->image)}}"
                     alt="{{$presentation->title}}">
            @endif
        </div>
        @if (Auth::check())
            @if($slideId)
                <a href="{{ url('presentations/'.$presentation->id.'/slides/'.$slideId.'/edit') }}"
                   class="wmo-dashboard-button">Return to slide</a>
            @else
                <a href="{{ url('presentations') }}" class="wmo-dashboard-button">Admin dashboard</a>
            @endif
        @endif
        @if(getenv('APP_MODE') != 'dashboard')
            <a href="{{ url('presentations/quit') }}" class="wmo-logout-button">Quit</a>
        @endif

    </div>
</header>


<!-- <nav class="wmo-back-button"><a class="js__go_back" href="#">menu</a></nav> -->
@if(!$slideId)
    <nav class="wmo-next-button">
        <a class="js__go_prev" href="#" style="display: none"></a>
        <a class="js__go_next" href="#"><span class="wmo-menu-hint"></span></a>
    </nav>


    <div class="wmo-container" id="content">
        @include('frontend.partials.menu')
        {{--@include('frontend.partials.pyramid', [])--}}

        @foreach($presentation->present()->secondarySections as $i => $section)
            <section id="section_{{ $i }}" class="wmo-section" data-id="{{ $section->id }}"
                     data-name="{{ $section->name }}">
                @foreach($section->slides as $j => $slide)
                    <article id="slide_{{ $j }}" class="wmo-slide @if($slide->color) colored_green @endif"
                             data-id="{{ $slide->id }}" data-type="{{ $slide->type }}"
                             data-name="{{ $slide->name }}"
                             style="top:{{$slide->marginForMedia()}}rem">
                        @include('frontend.partials.'.$slide->type, ['slide'=>$slide])
                    </article>
                @endforeach
            </section>
        @endforeach

    </div>
@endif


<div class="wmo-logo"><img src="{{ asset('images/new-logo-front.png') }}" alt="Walker Morris OPT logo"/></div>
<div class="wmo-quote">
    <blockquote>A distinctive law firm valued by its clients for consistently delivering excellent results.</blockquote>
</div>
<script src="{{asset('js/lib/jquery.min.js')}}"></script>
<script src="{{ asset('js/lib/jquery.fancybox.pack.js') }}"></script>
<script src="{{ asset('js/lib/perfect-scrollbar.jquery.min.js') }}"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js"></script>
<script src="{{ asset('js/frontend.js') }}"></script>
</body>
</html>
