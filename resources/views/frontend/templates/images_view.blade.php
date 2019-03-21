@extends('frontend.presentation_template')

@section('main')
    <div class="main-content">
        <div class="template-content images-view-content">
            <h1 class="title-rule">Our credentials</h1>
            <div class="images-contain">
                <div style="background-image: url({{ asset('images/images/1.jpg') }})"></div>
                <div style="background-image: url({{ asset('images/images/2.jpg') }})"></div>
                <!--div style="background-image: url({{ asset('images/images/3.jpg') }})"></div>
                <div style="background-image: url({{ asset('images/images/1.jpg') }})"></div-->
            </div>
        </div>
    </div>
@stop