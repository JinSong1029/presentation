@extends('admin')
@section('content')

    <div id="meta" data-presentation-id="{{ $presentation->id }}" data-slide-id="{{ $slide->id }}"></div>

    <h3 class="morris-grey-title">Editing presentation: <span>{{ $presentation->title }} &mdash; {{ $slide->name }}</span></h3>

    <hr/>


    @if($slide->type == "tombstone")
        @include('presentations.slides.tombstone.tombstone')
    @endif

    @if($slide->type == "picture")
        @include('presentations.slides.image.image')
    @endif
{{--    @if($slide->type == "welcome")--}}
{{--        @include('presentations.slides.image.image')--}}
    {{--@endif--}}

    @if($slide->type == "logo")
        @include('presentations.slides.logo.logo')
    @endif

    @if($slide->type == "text")
        @include('presentations.slides.text.text')
    @endif
    @if($slide->type == "heading")
        @include('presentations.slides.blank')
    @endif
    @if($slide->type == "video")
        @include('presentations.slides.video.video')
    @endif

    @if($slide->type == "procedure")
        @include('presentations.slides.procedure.procedure')
    @endif

    @if($slide->type == "quote")
        @include('presentations.slides.quote.quote')
    @endif

    @if($slide->type == "pyramid")
        @include('presentations.slides.pyramid.pyramid')
    @endif

    @if($slide->type == "welcome")
        @include('presentations.slides.welcome.welcome')
    @endif
    @if($slide->type == "split")
        @include('presentations.slides.split.split')
    @endif
    @if($slide->type == "intro")
        @include('presentations.slides.intro.intro')
    @endif


    @if($slide->type == "icons")
        @include('presentations.slides.icon.icon')
    @endif
    @if($slide->type == "images")
        @include('presentations.slides.gallary.gallary')
    @endif
    @if($slide->type == "team")
        @include('presentations.slides.team.team')
    @endif

@stop

@section('admin_scripts')
    <script type="application/javascript" src="{{ asset('js/lib/select2.full.min.js') }}"></script>
    <script type="application/javascript" src="{{ asset('js/lib/sonic.js') }}"></script>
    <script type="application/javascript" src="{{ asset('js/presentation.js') }}"></script>
    <script type="application/javascript" src="{{asset('js/lib/vanilla-picker.min.js')}}"></script>
    <script type="application/javascript" src="{{asset('js/color-picker.js')}}"></script>
@stop