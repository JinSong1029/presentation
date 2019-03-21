<?php

// converting laravel object to array of objects
$logos = [];

foreach ($slide->images as $logo) {
    $logos[] = $logo;
}

$count = count($logos);

// ["class, position"]
$variants = [
        0 => [],
        1 => ["row,1", "row-empty,3", "row-empty,4"],
        2 => ["row,1", "row,2"],
        3 => ["row,1", "row-small,3", "row-empty,4"],
        4 => ["row-small,1", "row-empty,2", "row-small,3", "row-empty,4"],
        5 => ["row,1", "row-small,3", "row-small,4"],
        6 => ["row-small,1", "row-small,2", "row-small,3", "row-empty,4"],
        7 => ["row-small,1", "row-small,2", "row-small,3", "row-small,4"],
        8 => ["row-small,1", "row-small,2", "row-small,3", "row-small,4"],
];
$colors = [
        'green', 'gray', 'lgreen', 'dgreen', 'green', 'gray', 'lgreen', 'dgreen', 'green', 'gray', 'lgreen', 'dgreen', 'lgreen', 'dgreen', 'green', 'gray', 'lgreen', 'dgreen'
];
$i = 0;
?>


<div class="wmo-tombstones">
    @foreach($variants[$count] as $var)

        <?php
        $exp = explode(',', $var);
        $class = $exp[0];
        $pos = $exp[1];
        ?>

        @if($class == "row")
            <div class="wmo-tombstone-row pos-{{ $pos }} {{ $colors[$i+2] }}">
                <div class="wmo-tombstone-wrapper">
                    <?php $item = array_shift($logos);  ?>
                    @if(!empty($item))
                        <a href="#logo_{{ $item->id }}"
                           class="wmo-tombstone-block {{ $colors[$i++] }} {{ (strlen($item->desc)>3) ? "js__fancybox" : "" }}">
                            <div class="wmo-tombstone-block__image js__preload"
                                 style="background-image: url('{{ asset('img/images/'.$item->image) }}')"></div>
                            <div class="wmo-tombstone-block__headline">{!! $item->name !!}</div>
                            <div class="wmo-tombstone-plus"><i class="fa fa-plus"></i></div>
                        </a>
                        <div class="hide">
                            <div class="wmo-tombstone-popup" id="logo_{{ $item->id }}">{!! $item->desc !!}</div>
                        </div>
                    @endif
                </div>
            </div>
        @endif

        @if($class == "row-small")

            <div class="wmo-tombstone-row-small pos-{{ $pos }} {{ $colors[$i+2] }}">
                <div class="wmo-tombstone-wrapper">

                    <?php $item = array_shift($logos);  ?>

                    @if(!empty($item))
                        <a href="#logo_{{ $item->id }}"
                           class="wmo-tombstone-block {{ $colors[$i++] }} js__fancybox">
                            <div class="wmo-tombstone-block__image js__preload"
                                 style="background-image: url('{{ asset('img/images/'.$item->image) }}')"></div>
                            <div class="wmo-tombstone-block__headline">{!! $item->name !!}</div>
                            <div class="wmo-tombstone-plus"><i class="fa fa-plus"></i></div>
                        </a>
                        <div class="hide">
                            <div class="wmo-tombstone-popup" id="logo_{{ $item->id }}">{!! $item->desc !!}</div>
                        </div>
                    @endif

                    <?php $item = array_shift($logos); ?>

                    @if(!empty($item))
                        <a href="#logo_{{ $item->id }}"
                           class="wmo-tombstone-block {{ $colors[$i++] }} js__fancybox">
                            <div class="wmo-tombstone-block__image js__preload"
                                 style="background-image: url('{{ asset('img/images/'.$item->image) }}')"></div>
                            <div class="wmo-tombstone-block__headline">{!! $item->name !!}</div>
                            <div class="wmo-tombstone-plus"><i class="fa fa-plus"></i></div>
                        </a>
                        <div class="hide">
                            <div class="wmo-tombstone-popup" id="logo_{{ $item->id }}">{!! $item->desc !!}</div>
                        </div>

                    @endif
                </div>
            </div>

        @endif


        @if($class == "row-empty")

            <div class="wmo-tombstone-row-small pos-{{ $pos }} {{ $colors[$i+2] }}">
                <div class="wmo-tombstone-wrapper">
                    <div class="wmo-tombstone-block {{ $colors[$i++] }}">
                        <div class="wmo-tombstone-block__empty {{ $colors[$i++] }}"></div>
                    </div>
                    <div class="wmo-tombstone-block {{ $colors[$i++] }}">
                        <div class="wmo-tombstone-block__empty {{ $colors[$i++] }}"></div>
                    </div>
                </div>
            </div>

        @endif

    @endforeach
</div>
