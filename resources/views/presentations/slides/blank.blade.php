<div class="morris-presentation-slide-title">
    <h4 class="serif">{{ $slide->name }}</h4>
    @include('presentations.slides.edit_slide_name')
</div>
<div id="validation-errors"></div>
<?php $text = $slide->texts[0]; ?>

{!! Form::open(['route' => ['texts.update', $text->id], 'method' => 'PUT', 'class'=>'morris-ajax-form submit-subslide']) !!}

{!! Form::hidden('presentationId', $presentation->id) !!}
{!! Form::text('text', $text->text, ['class'=>'form-control']) !!}

<hr/>

<div class="row">
    <div class="col-xs-3 col-xs-offset-9">
        {!! Form::submit('Save & return to presentation', ['class'=>'btn btn-primary btn-block morris-ajax-form-submit',
        'name'=>'return']) !!}
    </div>
</div>

{!! Form::close() !!}