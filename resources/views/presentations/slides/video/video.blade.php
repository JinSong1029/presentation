<div class="morris-presentation-slide-title">
    <h4 class="serif">{{ $slide->name }}</h4>
    @include('presentations.slides.edit_slide_name')
</div>
<hr/>
<?php $video = $slide->videos[0]; ?>

{{--{{ dd($video) }}--}}

{!! Form::open(['route' => ['videos.update', $video->id], 'method' => 'PUT', 'class'=>'morris-ajax-form submit-subslide']) !!}


<div class="row">

    <div id="validation-errors"></div>
    
    <div class="col-xs-6">

        <div class="form-group">
            <div class="morris-uploader format-16_9_wide{{ strlen($video->image) > 0 ? " uploaded" : "" }}"
                 style="background-image: {{ 'url('.asset('img/videos/'.$video->image).')' }}">
                 <span>Click to select image from disk <br>
                    Please upload images with a 2.5:1 ratio <br>
                    The optimum size is 1920 x 768 pixels
                </span>
                <img src="{{ asset('images/16_9_transparent.png') }}"/>
                {!! Form::file('image', ['accept'=>'image/*']) !!}
                {!! Form::hidden('presentationId', $presentation->id) !!}
            </div>
        </div>
    </div>

    <div class="col-xs-6">
        <div class="form-group">
            <label for="">Video title</label>
            {!! Form::text('title', $video->title, ['class'=>'form-control', 'placeholder'=>'Video title']) !!}
        </div>
        <div class="form-group">
            <label for="">Video URL</label>
            {!! Form::text('url', $video->url, ['class'=>'form-control', 'placeholder'=>'http://']) !!}
        </div>
    </div>
</div>


<hr/>

<div class="row">
    <div class="col-xs-3 col-xs-offset-9">
        {!! Form::submit('Save - return to presentation', ['class'=>'btn btn-primary btn-block morris-ajax-form-submit morris-ajax-form-video',
        'name'=>'return']) !!}
    </div>
</div>

{!! Form::close() !!}