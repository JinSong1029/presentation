<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>{{ $title }}</title>


    <link href="{{ asset('css/styleguide.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/redactor.css') }}" rel="stylesheet">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="/js/editor/css/froala_editor.min.css">
    <link rel="stylesheet" href="/js/editor/css/themes/gray.css">
    <link rel="stylesheet" href="/js/editor/css/plugins/colors.css">
    <link rel="stylesheet" href="{{ asset('css/jquery.fancybox.css') }}"/>

    <!-- Fav Icon -->
    <link rel="icon" href="/favicon.ico" type="image/x-icon"/>
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon"/>
    <link rel="apple-touch-icon" sizes="144x144"
          href="{{ asset('apple-icon-144x144.png') }}">
    <link rel="apple-touch-icon" sizes="114x114"
          href="{{ asset('apple-icon-114x114.png') }}">
    <link rel="apple-touch-icon" sizes="72x72"
          href="{{ asset('apple-icon-72x72.png') }}">
    <link rel="apple-touch-icon-precomposed"
          href="{{ asset('apple-icon-precomposed.png') }}">
    @yield('css')
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">

    <meta http-equiv="x-ua-compatible" content="IE=Edge"/>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>
<body>
@yield('main')
<script src="{{asset('js/lib/jquery.min.js')}}"></script>
<script src="{{asset('js/lib/bootstrap.min.js')}}"></script>
<script type="application/javascript" src="{{ asset('js/lib/jquery.fancybox.pack.js') }}"></script>

@yield('scripts')
</body>
</html>
