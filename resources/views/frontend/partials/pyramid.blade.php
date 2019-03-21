<?php
$outside = [];

foreach ($slide->groups as $group) {
    $outside[$group->pivot->position] = $group;
}

?>

<div class="wmo-pyramid">
    <div class="wmo-pyramid-image">
        <img src="{{ asset('images/pyramid.jpg') }}">
    </div>

    @if(isset($outside[1]))
        <div class="wmo-pyramid-group group-tl">
            <div class="wmo-pyramid-icon"><img src="{{ asset('images/pyr-image1.jpg') }}"></div>
            <div class="wmo-pyramid-title">{{ $outside[1]->title }}</div>
            <div class="wmo-pyramid-content">{!! nl2br($outside[1]->content) !!}</div>
        </div>
    @endif


    @if(isset($outside[2]))
        <div class="wmo-pyramid-group group-tr">
            <div class="wmo-pyramid-icon"><img src="{{ asset('images/pyr-image3.jpg') }}"></div>
            <div class="wmo-pyramid-title">{{ $outside[2]->title }}</div>
            <div class="wmo-pyramid-content">{!! nl2br($outside[2]->content)  !!}</div>
        </div>
    @endif

    @if(isset($outside[3]))
        <div class="wmo-pyramid-group group-bl">
            <div class="wmo-pyramid-icon"><img src="{{ asset('images/pyr-image2.jpg') }}"></div>
            <div class="wmo-pyramid-title">{{ $outside[3]->title }}</div>
            <div class="wmo-pyramid-content">{!! nl2br($outside[3]->content) !!}</div>
        </div>
    @endif

    @if(isset($outside[4]))
        <div class="wmo-pyramid-group group-br">
            <div class="wmo-pyramid-icon"><img src="{{ asset('images/pyr-image4.jpg') }}"></div>
            <div class="wmo-pyramid-title">{{ $outside[4]->title }}</div>
            <div class="wmo-pyramid-content">{!! nl2br($outside[4]->content) !!} </div>
        </div>
    @endif
    @if(isset($outside[5]))
        <div class="wmo-pyramid-group group-thl">
            <div class="wmo-pyramid-icon"><img src="{{ asset('images/pyr-image3.jpg') }}"></div>
            <div class="wmo-pyramid-title">{{ $outside[5]->title }}</div>
            <div class="wmo-pyramid-content">{!! nl2br($outside[5]->content) !!} </div>
        </div>
    @endif
    @if(isset($outside[6]))
        <div class="wmo-pyramid-group group-thr">
            <div class="wmo-pyramid-icon"><img src="{{ asset('images/pyr-image1.jpg') }}"></div>
            <div class="wmo-pyramid-title">{{ $outside[6]->title }}</div>
            <div class="wmo-pyramid-content">{!! nl2br($outside[6]->content) !!} </div>
        </div>
    @endif


</div>