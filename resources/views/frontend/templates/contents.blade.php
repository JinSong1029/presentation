@extends('frontend.presentation_template')

@section('main')
    <div class="main-content">
        <div class="template-content contents-content">
            <div class="screen-content">
                <h1>{{ $presentation->title }}</h1>
                <div class="contents-view">
                <a href="javascript:void(0)" class="overlay-blue" style="background-image:url({{ asset('images/bg-placeholder.jpg') }})">
                        <span>Understanding your needs</span>
                    </a>
                    <a href="javascript:void(0)" class="overlay-blue" style="background-image:url({{ asset('images/bg-placeholder.jpg') }})">
                        <span>How we can support you</span>
                    </a>
                </div>
                <div class="slider-view">
                    <div style="width: 416px;">
                        <a href="javascript:void(0)" class="overlay-blue" style="background-image:url({{ asset('images/bg-placeholder.jpg') }})">
                            <span>Case Studies</span>
                        </a>
                    </div>
                    
                    <div style="width: 416px;">
                        <a href="javascript:void(0)" class="overlay-blue" style="background-image:url({{ asset('images/bg-placeholder.jpg') }})">
                            <span>CSR</span>
                        </a>
                    </div>

                    <div style="width: 416px;">
                        <a href="javascript:void(0)" class="overlay-blue" style="background-image:url({{ asset('images/bg-placeholder.jpg') }})">
                            <span>International approach</span>
                        </a>
                    </div>

                    <div style="width: 416px;">
                        <a href="javascript:void(0)" class="overlay-blue" style="background-image:url({{ asset('images/bg-placeholder.jpg') }})">
                            <span>Brexit support</span>
                        </a>
                    </div>

                    <div style="width: 416px;">
                        <a href="javascript:void(0)" class="overlay-blue" style="background-image:url({{ asset('images/bg-placeholder.jpg') }})">
                            <span>Case Studies</span>
                        </a>
                    </div>
                    
                    <div style="width: 416px;">
                        <a href="javascript:void(0)" class="overlay-blue" style="background-image:url({{ asset('images/bg-placeholder.jpg') }})">
                            <span>CSR</span>
                        </a>
                    </div>

                    <div style="width: 416px;">
                        <a href="javascript:void(0)" class="overlay-blue" style="background-image:url({{ asset('images/bg-placeholder.jpg') }})">
                            <span>International approach</span>
                        </a>
                    </div>

                    <div style="width: 416px;">
                        <a href="javascript:void(0)" class="overlay-blue" style="background-image:url({{ asset('images/bg-placeholder.jpg') }})">
                            <span>Brexit support</span>
                        </a>
                    </div>
                </div>
                @if(!$hide_noti_flag)
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
    </div>
@stop