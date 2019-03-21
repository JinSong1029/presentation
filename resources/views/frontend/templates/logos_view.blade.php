@extends('frontend.presentation_template')

@section('main')
    <div class="main-content">
        <div class="template-content logos-view-content">
            <h1 class="title-rule">Our clients</h1>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean nec tincidunt leo. Aliquam laoreet posuere diam, ac suscipit est pharetra.</p>
            <div class="logos-content">
                <div>
                    <img src="{{ asset('images/logos/bufab.jpg' ) }}" />
                    <div class="logos-text">
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                        <a href="#">Find out more</a>
                    </div>
                </div>
                <div>
                    <img src="{{ asset('images/logos/chipotle.png' ) }}" />
                    <div class="logos-text">
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                        <a href="#">Find out more</a>
                    </div>
                </div>
                <div>
                    <img src="{{ asset('images/logos/caterpiller.png' ) }}" />
                    <div class="logos-text">
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                        <a href="#">Find out more</a>
                    </div>
                </div>
                <div>
                    <img src="{{ asset('images/logos/petrobras.jpg' ) }}" />
                    <div class="logos-text">
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                        <a href="#">Find out more</a>
                    </div>
                </div>
                <div>
                    <img src="{{ asset('images/logos/sulzer.png' ) }}" />
                    <div class="logos-text">
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                        <a href="#">Find out more</a>
                    </div>
                </div>
                <div>
                    <img src="{{ asset('images/logos/starbucks.jpg' ) }}" />
                    <div class="logos-text">
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                        <a href="#">Find out more</a>
                    </div>
                </div>
                <div>
                    <img src="{{ asset('images/logos/toyota_mh.jpg' ) }}" />
                    <div class="logos-text">
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                        <a href="#">Find out more</a>
                    </div>
                </div>
                <div>
                    <img src="{{ asset('images/logos/covance.jpg' ) }}" />
                    <div class="logos-text">
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                        <a href="#">Find out more</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop