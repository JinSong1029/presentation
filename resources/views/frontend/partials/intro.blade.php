
<div class="screen-wm-logo">
    <img src="{{ asset('images/new-wm-logo.png') }}" alt="WM Logo" />
</div>

<?php
$split = $slide->splits->first();
?>

@if ($presentation->present()->backgroundFor($split))
<style>body.template #intro_{{$slide->id}}:after { background-color: {{ $presentation->present()->backgroundFor($split) }}!important; }</style>
@endif
<div class="main-content">
    @if (isset($split) && isset($split->image))
    <div id="intro_{{$slide->id}}" class="template-content screen-intro-content overlay-blue" style="background-image: url({{ asset('img/splits/'.$split->image) }})">
    @elseif (background_color($presentation, $split))
    <div id="intro_{{$slide->id}}" class="template-content screen-intro-content overlay-blue" style="background-image: url({{ asset('images/bg-placeholder.jpg') }})">
    @else
    <div id="intro_{{$slide->id}}" class="template-content screen-intro-content overlay-blue" style="background-image: url({{ asset('images/bg-placeholder.jpg') }})">
    @endif
        <div class="info-content">
            @if(!empty($presentation->image))
                <img src="{{ asset('img/presentations/'.$presentation->image) }}" class="client-logo " alt="Client Logo" />
            @else
                <img src="{{ asset('images/cat-client-logo.png') }}" class="client-logo " alt="Client Logo" />
            @endif
            <div class="screen-text">{!! $split->text !!}</div>
        </div>
    </div>
</div>
