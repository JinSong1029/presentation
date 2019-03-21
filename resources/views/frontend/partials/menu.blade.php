{{-- <section class="wmo-menu active" id="menu">
    <div class="wmo-menu__centrer">
        <div class="wmo-menu__wrap">
            <ul class="wmo-menu__list">
                @foreach($presentation->present()->secondarySections as $i => $section)
                    <li class="wmo-menu__item">
                        <a href="#" class="wmo-menu__link js__goto_section" data-target="section_{{ $i }}">
                            {{ $section->name }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</section> --}}


<div class="main-content active" id="menu">
    <div class="template-content contents-content">
        <div class="screen-content">
            <h1>{{ $presentation->title }}</h1>
            <?php
                $section_class = 'one-box';
                /* main section count */
                $countMainSections = 0;
                foreach($presentation->present()->secondarySections as $section){
                    if($section->additional == 0) {   
                        $countMainSections++;
                    }
                }
                if($countMainSections > 1){
                    if($countMainSections == 2){
                        $section_class = 'two-box';
                    }elseif ($countMainSections == 3) {
                        $section_class = 'three-box';
                    }elseif ($countMainSections == 4) {
                        $section_class = 'four-box';
                    }elseif ($countMainSections > 4 && $countMainSections < 7){
                        $section_class = 'six-box';
                    }elseif ($countMainSections > 6) {
                        $section_class = 'eight-box';
                    }
                }
            ?>
            <div class="contents-view {{ $section_class }}">
                <?php $mainCount = 0; ?>
                @foreach($presentation->present()->secondarySections as $i => $section)    
                    @if ($section->additional == 0)
                        @if($countMainSections > 8 && $mainCount == ($countMainSections - 1 ))
                            <a href="javascript:void(0)" class="overlay-blue wmo-menu__link js__goto_section" data-target="section_{{ $i }}" style="background-image:url({{ asset('images/bg-placeholder.jpg') }}); margin-bottom: 40px;">
                                <span>{{ $section->name }}</span>
                            </a>
                        @else
                            <a href="javascript:void(0)" class="overlay-blue wmo-menu__link js__goto_section" data-target="section_{{ $i }}" style="background-image:url({{ asset('images/bg-placeholder.jpg') }})">
                                <span>{{ $section->name }}</span>
                            </a>
                        @endif
                        <?php $mainCount++; ?>
                    @endif
                @endforeach
            </div>
            <div class="slider-view">
                @foreach($presentation->present()->secondarySections as $i => $section)
                    @if ($section->additional != 0)
                        <div style="width: 416px;">
                            <a href="javascript:void(0)" class="overlay-blue wmo-menu__link js__goto_section" data-target="section_{{ $i }}" style="background-image:url({{ asset('images/bg-placeholder.jpg') }})">
                                <span>{{ $section->name }}</span>
                            </a>
                        </div>
                    @endif
                @endforeach
            </div>
            
        </div>
        @if( !(Session::has('hide_noti') && Session::get('hide_noti') == 1) )
            <div class="noti-field">
                <div class="noti-content">
                    <div class="left-part">
                        <div class="img">
                            <img src="{{ asset('images/key-arrow.png') }}">
                            <img src="{{ asset('images/key-arrow.png') }}">
                        </div>
                        <span>Use keyboard arrows to navigate through presentation.</span>
                    </div>
                    <div class="right-part">
                        <div class="img">
                            <img src="{{ asset('images/devices.png') }}">
                        </div>
                        <span>Best viewed on desktop or tablet.</span>  
                    </div>
                </div>
                <div class="noti-action">
                    <a href="javascript:void(0)" class="noti-close-btn">Close</a>
                </div>
            </div>
        @endif
    </div>
</div>