@extends('frontend.presentation_template')

@section('main')
    <div class="screen-wm-logo">
        <img src="{{ asset('images/new-wm-logo.png') }}" alt="WM Logo" />
    </div>
    <div class="main-content">
        @if (isset($presentation->background_image))
        <div class="template-content screen-intro-content overlay-blue" style="background-image: url({{ asset('images/bg-placeholder.jpg') }})">
        @elseif ($presentation->color != null && $presentation->color != '')
        <div class="template-content screen-intro-content" style="background-color: rgb({{ $presentation->color }})">
        @else
        <div class="template-content screen-intro-content overlay-blue" style="background-image: url({{ asset('images/bg-placeholder.jpg') }})">
        @endif
            <div class="info-content">
                @if($presentation->image != null && $presentation->image != '')
                    <img src="{{ asset('img/presentations/'.$presentation->image) }}" class="client-logo " alt="Client Logo" />
                @else
                    <img src="{{ asset('images/cat-client-logo.png') }}" class="client-logo " alt="Client Logo" />
                @endif
                <?php 
                    $text = $slideId ? $presentation->slides->first()->texts[0] : $presentation->present()->introSection->slides->first()->texts[0]; 
                ?>
                @if (isset($text))
                    <div class="screen-text">{!! $text->text !!}</div>
                @else
                    <p class="screen-text"></p>
                @endif
            </div>
        </div>
    </div>
@stop