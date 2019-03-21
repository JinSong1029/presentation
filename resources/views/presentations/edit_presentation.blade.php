@extends('admin')
@section('content')
    <div class="row manage-model">
        <div id="validation-errors"></div>
        <h2 class="morris-page-title">Overall Presentation editor</h2>
        <div class="presentation-show-title">
            <div class="row">
                <div class="col-sm-12">
                    <div class="morris-presentation-block overflow-hidden">
                        <div class="morris-presentation-block-delete">
                            <!-- <a href="#" class="morris-presentation-icons delete_presentation"><i
                                        class="fa fa-times"></i></a> -->
                        </div>
                        <div class="morris-presentation-block-edit">
                            <a class="morris-presentation-icons edit_presentation"><i class="fa fa-pencil"></i></a>
                        </div>
                        <div class="presentation-title">
                            <h3 style="margin: 0px">{!! $presentation->client !!} - {!! $presentation->title !!}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="meta" data-presentation-id="{{$presentation->id}}"></div>
        <div class="presentation-edit-form">

            {!! Form::open(['url' => 'presentations/'. $presentation->id,'class'=>'morris-ajax-form', 'method' => 'put','id'=>'edit_presentation','files'=>true]) !!}
            {!! Form::hidden('sectionsCount',count($presentation->sections)) !!}

            <div class="row">
                
                <div class="col-lg-3 col-md-3 col-sm-5 col-xs-12">
                    <h2 class="morris-page-sub-title">Client name </h2>
                    {!! Form::text('client', Input::old('client', $presentation->client), ['class' => 'form-control input-lg', 'placeholder' => 'Client name']) !!}
                    {!! $errors->first('client', '<div class="alert alert-danger">:message</div>') !!}
                </div>
                <div class="col-lg-3 col-md-3 col-sm-5 col-xs-12">
                    <h2 class="morris-page-sub-title">Presentation name </h2>
                    {!! Form::text('title', Input::old('name', $presentation->title), ['class' => 'form-control input-lg', 'placeholder' => 'Title']) !!}
                    {!! $errors->first('title', '<div class="alert alert-danger">:message</div>') !!}
                </div>
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                    <h2 class="morris-page-sub-title">@if($presentation->image)Edit @else Add @endif client logo </h2>
                    <div class="morris-presentation-slide-logo">
                        <div class="morris-uploader format-16_9_wide @if($presentation->image) uploaded @endif" data-type="unselectable" data-id="1" data-image-id="1"
                             style="background-image: url('{{ asset('img/presentations/'.$presentation->image) }}')">
                            <span class="logo-text">click here to add logo <br>
                                please upload images with a 4:1 ratio <br>
                                the optimum size is 200 x 100 pixels
                            </span>
                            <img src="{{ asset('images/16_9_transparent.png') }}"/>
                            {!! Form::file( 'image' , ['accept'=>'image/*']) !!}
                            {!! Form::hidden('new-image', 'false',['class'=>'onchange']) !!}
                            {!! Form::hidden('attachedLogoId', '', [ 'class'=> 'attached-logo'] ) !!}
                            {!! Form::hidden('detachedLogoId', '', [ 'class'=> 'detached-logo'] ) !!}
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

                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                    <h2 class="morris-page-sub-title">Background overlay color </h2>
                    <div>
                        <div class="form-group overlay-color-picker">
                            <label>Color:
                                <a href="#" id="overlay_color_box">&nbsp;</a>
                            </label>
                            <input type="hidden" name="color" id="txtOverlayColor"  value="{{$presentation->color}}"/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" style="margin-top: 20px;">
                <div class="hidden-xs col-lg-3 col-md-3  col-sm-2 col-xs-12 pull-right">
                    {!! Form::submit('Update presentation', ['class' => 'btn btn-lg btn-primary btn-block morris-ajax-form-submit','name'=>'return']) !!}
                </div>
                <div class="hidden-xs col-lg-3 col-md-3  col-sm-2 col-xs-12 pull-right">
                    <a class="btn btn-cancel btn-lg btn-block btn-default edit_cancel">Cancel</a>
                </div>
            </div>

            <div class="row" style="  position: relative; top: -45px;">
                <div class="col-md-3 col-sm-12 col-xs-12">
                    {!! $errors->first('image', '<div class="alert alert-danger">:message</div>') !!}
                </div>
            </div>
            <div class="row">
                <div class="visible-xs-block">
                    {!! Form::submit('Update presentation', ['class' => 'btn btn-lg btn-primary btn-block morris-ajax-form-submit','name'=>'return']) !!}
                </div>
                <div class="visible-xs-block">
                    <a class="btn btn-cancel btn-lg btn-block edit_cancel">Cancel</a>
                </div>
            </div>

            {!! Form::close() !!}
        </div>
    </div>

    <div id="presentation-sections" data-id="{{ $presentation->id }}">
        @foreach($presentation->sections as $section)
            @include('presentations.partials.section')
        @endforeach
    </div>


    <div class="row">
        <div class="col-lg-3 col-md-3  col-sm-3 col-xs-12">
            <h3>Add new section</h3>
        </div>
    </div>
    <div class="row morris-presentation-add-section">
        <div class="col-lg-3 col-md-3  col-sm-3 col-xs-12">
            {!! Form::text('newSection',Input::old('newSection'),['class'=>'form-control input-sm']) !!}
        </div>

        <div class="col-lg-3 col-md-3  col-sm-3 col-xs-12 col-lg-offset-6">
            <a class="btn btn-primary btn-block add_section" data-presentation="{!! $presentation->id !!}">Add new
                section</a>
        </div>
    </div>


@stop
@section('admin_scripts')
    <script type="application/javascript" src="{{asset('js/lib/select2.full.min.js')}}"></script>
    <script type="application/javascript" src="{{asset('js/lib/sonic.js')}}"></script>
    <script type="application/javascript" src="{{asset('js/lib/vanilla-picker.min.js')}}"></script>
    <script type="application/javascript" src="{{asset('js/presentation.js')}}"></script>
    <script type="application/javascript" src="{{asset('js/color-picker.js')}}"></script>
@stop