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
            <div class="img-part overlay-blue" style="background-image: url({{ asset('images/bg-placeholder.jpg') }})">
                </div>
            </div>
        </div>
    </div>
@stop