<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Walker Morris Presentation</title>
    <link rel="stylesheet" href="{{ asset('css/frontend.css') }}"/>
</head>
<body class="template">
    <div class="container">
        <div class="main-page-wrap">
            @include('frontend.partials.sidebar_menu')
            <div class="screen-wm-logo">
                <img src="{{ asset('images/new-wm-logo.png') }}" alt="WM Logo" />
            </div>
            <div class="main-page">
                @if($errors->any())
                    <div class="main-page-alert">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{$error}}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="main-page-opt">
                    <div class="main-page-link">Please enter your key:</div>
                </div>
                <div class="main-page-form">

                    <form class="form-horizontal" role="form" method="POST"
                        action="{{url('presentations/key')}}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="form-group">
                            <div class="col-md-6">
                                <input class="main-page-input" autofocus="autofocus" type="text" autocomplete="off" name="key" spellcheck="false" value="{{ old('key') }}"/>
                                <input class="main-page-submit hide" type="submit" name="submit" value="Login"/>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/lib/jquery.min.js') }}"></script>
    <script>
        $('.fullscreen-toggle').click(function(){
            var el = document.body;
            if($(this).hasClass('active')){
                $(this).removeClass('active');
                if (document.cancelFullScreen) {  
                    document.cancelFullScreen();  
                } else if (document.mozCancelFullScreen) {  
                    document.mozCancelFullScreen();  
                } else if (document.webkitCancelFullScreen) {  
                    document.webkitCancelFullScreen();  
                }else{
                    // Older IE.
                    var wscript = new ActiveXObject("WScript.Shell");
                
                    if (wscript !== null) {
                        wscript.SendKeys("{F11}");
                    }
                }
            }else{
                $(this).addClass('active');
                var requestMethod = el.requestFullScreen || el.webkitRequestFullScreen 
                || el.mozRequestFullScreen || el.msRequestFullScreen;
            
                if (requestMethod) {
            
                    // Native full screen.
                    requestMethod.call(el);
            
                } else if (typeof window.ActiveXObject !== "undefined") {
            
                    // Older IE.
                    var wscript = new ActiveXObject("WScript.Shell");
            
                    if (wscript !== null) {
                        wscript.SendKeys("{F11}");
                    }
                }
            }
        });
    </script>
</body>
</html>
