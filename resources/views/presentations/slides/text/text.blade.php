<div class="morris-presentation-slide-title">
    <h4 class="serif">{{ $slide->name }}</h4>
    @include('presentations.slides.edit_slide_name')
</div>
<hr/>
<?php $text = $slide->texts[0]; ?>
{!! Form::open(['route' => ['texts.update', $text->id], 'method' => 'PUT', 'class'=>'morris-ajax-form submit-subslide']) !!}
<div class="row">
    <div class="col-xs-6">
        <div class="form-group">
            <div class="morris-uploader format-16_9_wide" data-image-id = "$text->id : '' }}"
                 style="background-image: {{ $text->image !== null ? 'url('.asset('img/texts/'.$text->image).')' : 'none' }}">
                <span>Click to select background image from disk <br>
                    Please upload images with a 2:1 ratio <br>
                    The optimum size is 1920 x 920 pixels {{$text->image}}
                </span>
                <img src="{{ asset('images/16_9_transparent.png') }}"/>
                {!! Form::file('image', ['accept'=>'image/*']) !!}
            </div>
        </div>
    </div>
    <div class="col-xs-6">
    {!! Form::hidden('presentationId', $presentation->id) !!}
    {!! Form::textarea('text', $text->text, [
        'class'=>'redactor-for-text',
        'data-redactor-height'=>'200',
        'data-remove-controls'=>'all'
    ]) !!}
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