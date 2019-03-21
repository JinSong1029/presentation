<div class="morris-presentation-slide-title">
    <h4 class="serif">{{ $slide->name }}</h4>
    @include('presentations.slides.edit_slide_name')
</div>
<hr/>
<?php $split = $slide->splits[0]; ?>
{!! Form::open(['route' => ['splits.update', $split->id], 'method' => 'PUT', 'class'=>'morris-ajax-form submit-subslide','files'=>true]) !!}
{!! Form::hidden('type', 'image,text') !!}
<div class="row">
    <div class="col-xs-3">
        <div class="form-group">
            <Label>Background image</Label>
            <div class="morris-presentation-slide-logo">
                <div class="morris-uploader format-16_9_wide @if($split->image) uploaded @endif" data-type="unselectable" data-id="1" data-image-id="1"
                 style="background-image: url('{{ asset('img/splits/'.$split->image) }}')">
                            <span class="logo-text">click here to add logo <br>
                                please upload images with a 4:1 ratio <br>
                                the optimum size is 200 x 100 pixels
                            </span>
                <img src="{{ asset('images/16_9_transparent.png') }}"/>
                {!! Form::file( 'image' , ['accept'=>'image/*']) !!}
                {!! Form::hidden('new-image', 'false',['class'=>'onchange']) !!}
                {!! Form::hidden('attachedImageId', '', [ 'class'=> 'attached-logo'] ) !!}
                {!! Form::hidden('detachedImageId', '', [ 'class'=> 'detached-logo'] ) !!}
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
    </div>
    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
        <Label>Use highlight colour over image</Label>
        <div class="form-group">
            <div class="checkbox">
                <label>
                    {!! Form::hidden('presentationId', $presentation->id) !!}
                    <input name="use_presentation_color" type="checkbox" {{ $split->use_presentation_color == 1 ? "checked" : "" }}>
                </label>
            </div>
        </div>
    </div>
    <div class="col-xs-6">
        <Label>Text</Label>
        {!! Form::hidden('presentationId', $presentation->id) !!}
        {!! Form::textarea('text', $split->text, [
            'class'=>'redactor-for-text',
            'data-redactor-height'=>'200',
            'data-remove-controls'=>'all'
        ]) !!}

    </div>
</div>

<div class="row">
    <div class="col-xs-3 col-xs-offset-6">
        {!! Form::submit('Save - return to presentation', ['class'=>'btn btn-primary btn-block morris-ajax-form-submit',
        'name'=>'return']) !!}
    </div>
    <div class="col-xs-3">
        {!! Form::submit('Save', ['class'=>'btn btn-primary btn-block morris-ajax-form-submit',
'name'=>'return']) !!}

    </div>
</div>
<hr/>

{!! Form::close() !!}