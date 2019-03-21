<div class="morris-presentation-slide-title">
    <h4 class="serif">{{ $slide->name }}</h4>
    @include('presentations.slides.edit_slide_name')
</div>



<?php $editSlide = isset($slide->images[0]) ? $slide->images[0] : null; ?>
{{--{{ dd($editSlide) }}--}}

<hr/>
<div class="row">
    @if(!empty($editSlide))
        {!! Form::open(['route' => ['images.update', $editSlide->id], 'method' => 'PUT', 'files'=>true,
        'class'=>'morris-ajax-form submit-subslide']) !!}
    @else
        {!! Form::open(['route' => ['images.store'], 'method' => 'POST', 'files'=>true,
        'class'=>'morris-ajax-form submit-subslide']) !!}
        {!! Form::hidden('slide_id', $slide->id) !!}
        {!! Form::hidden('presentationId', $presentation->id) !!}
    @endif

        <input type="hidden" name="name" value="Image">


    <div id="validation-errors"></div>

    <div class="col-xs-6">
        <div class="form-group">
            <div class="morris-uploader format-16_9_wide {{ isset($editSlide) ? "uploaded" : ""}}"
                 style="background-image: {{ isset($editSlide) ? 'url('.asset('img/images/'.$editSlide->image).')' : "none" }}">
                <span>Click to select image from disk <br>
                    Please upload images with a 16:9 ratio <br>
                    The optimum size is 2048 x 1152 pixels
                </span>
                <img src="{{ asset('images/16_9_transparent.png') }}"/>
                {!! Form::file('image', ['accept'=>'image/*']) !!}
            </div>
        </div>
    </div>
</div>

<hr/>

<div class="row">
    <div class="col-xs-3 col-xs-offset-9">
        {!! Form::submit('Save - return to presentation', ['class'=>'btn btn-primary btn-block morris-ajax-form-submit',
        'name'=>'return']) !!}
    </div>
</div>
{!! Form::close() !!}

<hr/>