{{--@extends('frontend.presentation_template')--}}

{{--@section('main')--}}
    <div class="main-content">
        <div class="template-content images-view-content">
            @foreach ($slide->gallarys as $gallary)
            <h1 class="title-rule">{!! $gallary->label !!}</h1>
            <div class="images-contain">                
                @if($gallary->image3!='')         
                <div style="background-image: url({{ asset('img/gallarys/'.$gallary->image) }})"></div>
                <div style="background-image: url({{ asset('img/gallarys/'.$gallary->image2) }})"></div>
                <div style="background-image: url({{ asset('img/gallarys/'.$gallary->image3) }})"></div>
                <div style="background-image: url({{ asset('img/gallarys/'.$gallary->image4) }})"></div>
                @else
                <div class="" style="background-image: url({{ asset('img/gallarys/'.$gallary->image) }})"></div>
                <div class="" style="background-image: url({{ asset('img/gallarys/'.$gallary->image2) }})"></div>
                @endif
                <!-- <p>{!! $gallary->label !!}</p> -->
            </div>
            @endforeach
        </div>
    </div>
{{--@stop--}}
