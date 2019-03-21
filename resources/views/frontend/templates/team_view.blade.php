@extends('frontend.presentation_template')

@section('main')
    <div class="main-content">
        <div class="template-content content-view-content">
            <div class="main-view-content">
                <div class="plain-part">
                    <h1 class="title-rule">Standard content page</h1>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean nec tincidunt leo.</p>
                    <h2>Sub-Heading</h2>
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean nec tincidunt leo. Aliquam laoreet posuere diam, ac suscipit est pharetra. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean nec tincidunt leo. Aliquam laoreet posuere diam, ac suscipit est pharetra. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean nec tincidunt leo. Aliquam laoreet posuere diam, ac suscipit est pharetra.
                    </p>
                </div>
                <div class="members-part withinfo">
                    <div class="six-box" style="background-image:url({{ asset('images/members/oliver-duke.jpg') }})">
                        <div class="info-overlay">
                            <h3>Oliver Duke</h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                            <a href="">Find out more</a>
                        </div>
                    </div>
                    <div class="six-box" style="background-image:url({{ asset('images/members/debbie-jackson.jpg') }})">
                        <div class="info-overlay">
                            <h3>Debbie Jackson</h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                            <a href="">Find out more</a>
                        </div>
                    </div>
                    <div class="six-box" style="background-image:url({{ asset('images/members/richard-sanford.jpg') }})">
                        <div class="info-overlay">
                            <h3>Richard Sanford</h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                            <a href="">Find out more</a>
                        </div>
                    </div>
                    <div class="six-box" style="background-image:url({{ asset('images/members/oliver-duke.jpg') }})">
                        <div class="info-overlay">
                            <h3>Oliver Duke</h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                            <a href="">Find out more</a>
                        </div>
                    </div>
                    <div class="six-box" style="background-image:url({{ asset('images/members/debbie-jackson.jpg') }})">
                        <div class="info-overlay">
                            <h3>Debbie Jackson</h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                            <a href="">Find out more</a>
                        </div>
                    </div>
                    <div class="six-box" style="background-image:url({{ asset('images/members/michael-taylor.jpg') }})">
                        <div class="info-overlay">
                            <h3>Michael Taylor</h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                            <a href="">Find out more</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop