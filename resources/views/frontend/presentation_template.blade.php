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
        <div class="wmo-splash-screen">
            <div class="wmo-splash-screen-close" style="display: block">
                @if (Auth::check())
                    <a href="{{ url('presentations/'.$presentation->id.'/menu-screen') }}" class="wmo-splash-screen-close__link js__go_back"></a>
                @else
                    <a href="{{ url('presentations/menu-screen') }}" class="wmo-splash-screen-close__link js__go_back"></a>
                @endif
            </div>
        </div>
        @include('frontend.partials.sidebar_menu')
        @yield('main')
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
