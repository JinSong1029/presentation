<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ $presentation->title }}</title>
        <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('css/jquery.fancybox.css') }}"/>
        <link rel="stylesheet" href="{{ asset('css/frontend.css') }}"/>
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css"/>
        <link href="https://fonts.googleapis.com/css?family=Lato|Roboto" rel="stylesheet">
    </head>
    <body class="template">
        <div class="container">
        
            @if (Auth::check())
                @if($slideId)
                    <a href="{{ url('presentations/'.$presentation->id.'/slides/'.$slideId.'/edit') }}"
                       class="wmo-dashboard-button">Return to slide</a>
                @endif
            @endif
            {{--{{ dd($presentation) }}--}}

            <div class="wmo-splash-screen  @if($slideId) slide-mode @endif">
                <div class="wmo-container">
                    @include('frontend.splash',['slide'=>$slideId ? $presentation->slides->first() : $presentation->present()->introSection->slides->first() ])
                </div>

                @if(!$slideId)
                    <div class="wmo-splash-screen-close" style="display: none">
                        <a href="#" class="wmo-splash-screen-close__link js__go_back"></a>
                    </div>
                @endif
            </div>
            @include('frontend.partials.sidebar_menu')

            <!-- <nav class="wmo-back-button"><a class="js__go_back" href="#">menu</a></nav> -->
            @if(!$slideId)

                <div class="wmo-container" id="content">
                    @include('frontend.partials.menu')
                    {{--@include('frontend.partials.pyramid', [])--}}

                    @foreach($presentation->present()->secondarySections as $i => $section)
                        <section id="section_{{ $i }}" class="wmo-section" data-id="{{ $section->id }}"
                                data-name="{{ $section->name }}">
                            @foreach($section->slides as $j => $slide)
                                <article id="slide_{{ $j }}" class="wmo-slide @if($slide->color) colored_green @endif"
                                        data-id="{{ $slide->id }}" data-type="{{ $slide->type }}"
                                        data-name="{{ $slide->name }}">
                                    @include('frontend.partials.'.$slide->type, ['slide'=>$slide])
                                </article>
                            @endforeach
                        </section>
                    @endforeach

                </div>
            @endif
        </div>
        <script src="{{asset('js/lib/jquery.min.js')}}"></script>
        <script type="text/javascript">
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        </script>
        <script src="{{ asset('js/lib/jquery.fancybox.pack.js') }}"></script>
        <script src="{{ asset('js/lib/perfect-scrollbar.jquery.min.js') }}"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js"></script>
        <script src="{{ asset('js/frontend.js') }}"></script>
    </body>
</html>
