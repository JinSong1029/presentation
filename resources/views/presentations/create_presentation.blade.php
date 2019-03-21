@extends('admin')
@section('content')
    <div class="row manage-model">
        <div id="validation-errors"></div>
        <div class="col-lg-12">
            <h2 class="morris-page-title">Create new presentation</h2>
        </div>

        {!! Form::open(['url' => 'presentations', 'method' => 'post','class'=>'morris-ajax-form','id'=>'create_presentation','files'=>true]) !!}
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
                {!! Form::text('client', Input::old('client', Input::old('client')), ['class' => 'form-control input-lg', 'placeholder' => 'Client name']) !!}
                {!! $errors->first('client', '<div class="alert alert-danger">:message</div>') !!}
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                {!! Form::text('title', Input::old('name', Input::old('title')), ['class' => 'form-control input-lg', 'placeholder' => 'Title']) !!}
                {!! $errors->first('title', '<div class="alert alert-danger">:message</div>') !!}
            </div>

            <div class="hidden-xs col-lg-3 col-md-3 ">
                <a href="{{ url('/presentations') }}" class="btn btn-cancel btn-lg btn-block btn-default">Cancel</a>
            </div>
            <div class="hidden-xs col-lg-3 col-md-3  col-sm-3">
                {!! Form::submit('Create presentation', ['class' => 'btn btn-lg btn-primary btn-block morris-ajax-form-submit','name'=>'newPresentation']) !!}
            </div>
        </div>

        <div class="row">
            <div class="col-md-3 col-sm-12 col-xs-12">
                <h2 class="morris-page-title">Add client logo </h2>
                <div class="morris-presentation-slide-logo">
                    <div class="morris-uploader format-16_9_wide" data-id="1" data-image-id=1}
                         style="background-image: none">
                        <span class="logo-text">click here to add logo <br>
                            please upload images with a 4:1 ratio <br>
                            the optimum size is 200 x 50 pixels
                        </span>
                        <img src="{{ asset('images/16_9_transparent.png') }}"/>
                        {!! Form::file( 'image' , ['accept'=>'image/*']) !!}
                        {!! Form::hidden('new-image', 'false',['class'=>'onchange']) !!}

                        <div class="icons">
                            <a class="edit" href="#">
                                <i class="fa fa-pencil"></i>
                            </a>
                            <a class="remove" href="#">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-12 col-xs-12">
                <h2 class="morris-page-title">Add Background</h2>
                <div>
                    <div class="form-group overlay-color-picker">
                        <label>Color:
                            <a href="#" id="overlay_color_box">&nbsp;</a>
                        </label>
                        <input type="hidden" name="color" id="txtOverlayColor"/>
                    </div>
                </div>
            </div>
        </div>

        <div class="row" style="  position: relative; top: -45px;">
            <div class="col-md-3 col-sm-12 col-xs-12">
                {!! $errors->first('image', '<div class="alert alert-danger">:message</div>') !!}
            </div>
        </div>
        <div class="row">
            <div class="visible-xs-block col-xs-12">
                {!! Form::submit('Create presentation', ['class' => 'btn btn-lg btn-primary btn-block morris-ajax-form-submit','name'=>'newPresentation']) !!}
            </div>
            <div class="visible-xs-block col-xs-12">
                <a href="{{ url('/defaults') }}" class="btn btn-cancel btn-lg btn-block btn-default">Cancel</a>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
    <hr>
    @foreach($sections as $section)
        @include('presentations.partials.section')
    @endforeach
@stop
@section('admin_scripts')
    <script type="application/javascript" src="{{asset('js/lib/select2.full.min.js')}}"></script>
    <script type="application/javascript" src="{{asset('js/lib/sonic.js')}}"></script>
    <script type="application/javascript" src="{{ asset('js/presentation.js') }}"></script>
    <script type="application/javascript" src="{{asset('js/lib/vanilla-picker.min.js')}}"></script>
    <script type="application/javascript" src="{{asset('js/color-picker.js')}}"></script>
@stop