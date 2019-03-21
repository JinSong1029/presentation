<div class="morris-presentation-slide-title">
    <h4 class="serif">{{ $slide->name }}</h4>
    @include('presentations.slides.edit_slide_name')
</div>

<hr/>
<div class="row">
    @foreach($slide->images as $item)
        @include('presentations.slides.image.block')

        @if(isset($subslide) && $item->id == $subslide)
            <?php $editSlide = $item; ?>
        @endif
    @endforeach
    
    @if($slide->type != 'welcome' && $slide->type != 'picture')
        <div class="col-xs-3">
            <div class="morris-presentation-slide-tombstone">
                <img src="{{ asset('images/16_9_transparent.png') }}" alt=""/>

                <div class="icons-empty">
                    <a class="edit"
                       href="{!! URL::to('presentations/'. $presentation->id .'/slides/' . $slide->id . '/edit') !!}"><i
                                class="fa fa-pencil"></i></a>
                    {{--<a class="remove" href="#"><i class="fa fa-times"></i></a>--}}
                </div>
            </div>
        </div>
    @endif

</div>

<hr/>
{{--@if($slide->images->count()<1 || isset($subslide))--}}
<div class="row">
    @if(isset($subslide))
        {!! Form::open(['route' => ['images.update', $subslide], 'method' => 'PUT', 'files'=>true,
        'class'=>'morris-ajax-form submit-subslide']) !!}
    @else
        {!! Form::open(['route' => ['images.store'], 'method' => 'POST', 'files'=>true,
        'class'=>'morris-ajax-form submit-subslide']) !!}
        {!! Form::hidden('slide_id', $slide->id) !!}
    @endif


    <div id="validation-errors"></div>

    <div class="col-xs-6">
        <div class="form-group">
            <div class="morris-uploader format-16_9_wide"
                 style="background-image: {{ isset($editSlide) ? 'url('.asset('img/images/'.$item->image).')' : "none" }}">
                 <span>Click to select image from disk <br>
                    Please upload images with a 2.5:1 ratio <br>
                    The optimum size is 1920 x 768 pixels
                </span>
                <img src="{{ asset('images/16_9_transparent.png') }}"/>
                {!! Form::file('image', ['accept'=>'image/*']) !!}
            </div>
        </div>
    </div>
{{--    @if($slide->type != 'welcome')--}}
        <div class="col-xs-6">
            <div class="form-group">
                <label><input type="radio" name="name"
                              value="Image" {{ (isset($editSlide) && $editSlide->name == null) || !isset($editSlide) ? "checked" : "" }} />
                    Image</label>
            </div>
            <div class="form-group">
                <div class="checkbox">
                    <label>
                        {!! Form::hidden('presentationId', $presentation->id) !!}
                        <input name="use_presentation_color" type="checkbox" {{ ((isset($editSlide) && $editSlide->use_presentation_color == 1)) ? "checked" : "" }}> Use highlight colour over image
                    </label>
                </div>
            </div>
            <div class="form-group">
                <label><input type="radio" name="name"
                              value="Client logo" {{ isset($editSlide) && $editSlide->name != null ? "checked" : "" }} />
                    Client logo</label>
                {!! Form::text('logo', isset($editSlide) ? $editSlide->name : "", ['class'=>'form-control input-sm', 'placeholder'=>'Logo name', 'style'=>'width: 300px;']) !!}
                {!! Form::hidden('presentationId', $presentation->id) !!}
                {!! Form::hidden('singular', $slide->images->count()) !!}
            </div>
        </div>
    {{--@endif--}}
</div>

<hr/>

<div class="row">
    @if($slide->type != 'welcome' && $slide->type != 'picture')
        <div class="col-xs-3">
            {!! Form::submit('Save', ['class'=>'btn btn-primary btn-block morris-ajax-form-submit',
            'name'=>'addmore']) !!}
        </div>
    @endif
    <div class="col-xs-3">
        {!! Form::submit('Save - return to presentation', ['class'=>'btn btn-primary btn-block morris-ajax-form-submit',
        'name'=>'return']) !!}
    </div>
</div>
{!! Form::close() !!}

<hr/>
{{--@endif--}}