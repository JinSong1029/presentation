<div class="morris-presentation-slide-title">
    <h4 class="serif">{{ $slide->name }}</h4>
    <hr/>
    <div class="form-group" style="margin-bottom: 0px">
        <label>
            <input type="radio" class="chooseColor" data-slide="{{$slide->id}}" name="color" value="1" @if($slide->color) checked @endif>
            Green</label>
    </div>
    <div class="form-group">
        <label>
            <input type="radio" class="chooseColor" data-slide="{{$slide->id}}" name="color" value="0" @if(!$slide->color) checked @endif>
            White</label>
    </div>
    @include('presentations.slides.edit_slide_name')
</div>

<hr/>

@if(isset($subslide))
    {!! Form::open(['route' => ['images.updateLogos', $subslide], 'method' => 'PUT', 'files'=>true,
    'class'=>'morris-ajax-form submit-subslide']) !!}
@else
    {!! Form::open(['route' => ['images.storeLogos'], 'method' => 'POST', 'files'=>true,
    'class'=>'morris-ajax-form submit-subslide']) !!}
    {!! Form::hidden('slide_id', $slide->id) !!}
@endif

<div class="row">
    <div id="validation-errors"></div>

    @for($i=1; $i < 17; $i++)

        {{--​*/ $k = array_search($i, $engagedPositions) /*​--}}

        <div class="col-xs-4 col-md-3">
            <div class="morris-presentation-slide-logo">

                @if ( $k !== false )

                    <div class="morris-uploader format-16_9_wide uploaded" data-id="{{$i}}"  data-image-id = {{ $slide->slideables()[$k]->id }}
                         style="background-image: url('{{ asset('img/images/'.$slide->slideables()[$k]->image) }}')">
                        <span class="logo-text">click here to add logo <br>
                            please upload images with a 4:3 ratio <br>
                            the optimum size is 1920 x 1440 pixels
                        </span>
                        <img src="{{ asset('images/16_9_transparent.png') }}"/>
                        {!! Form::file( 'logos['.$i.'][image]' , ['accept'=>'image/*']) !!}
                        {!! Form::hidden('logos['.$i.'][new-image]', 'false',['class'=>'onchange']) !!}
                        {!! Form::hidden('logos['.$i.'][id]', @($slide->slideables()[$k]->id) ) !!}
                        {!! Form::hidden('logos['.$i.'][attachedLogoId]', '', [ 'class'=> 'attached-logo'] ) !!}
                        {!! Form::hidden('logos['.$i.'][detachedLogoId]', '', [ 'class'=> 'detached-logo'] ) !!}
                        <a href="#popup_{{ $i }}" class="morris-presentation-slide-logo-popup-link js__fancybox">
                            <i class="fa fa-paragraph"></i> LOGO CONTENT
                        </a>
                        <div class="hide">
                            <div id="popup_{{ $i }}" class="morris-presentation-slide-logo-popup">
                                <div class="morris-redactor-label">Logo description</div>
                                {!! Form::textarea('logos['.$i.'][desc]', $slide->slideables()[$k]->desc,
                                ['class'=>'redactor-for-long-description', 'data-redactor-height'=>'300']) !!}
                                <button class="btn btn-primary pull-right" onclick="$.fancybox.close();return false;">SAVE AND CLOSE</button>
                            </div>
                        </div>
                        <div class="icons">
                            <a class="edit" href="#">
                                <i class="fa fa-pencil"></i>
                            </a>
                            <a class="remove" href="#">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="morris-presentation-slide-logo-select">
                            <select name="" id="" class="select form-control">
                                <option class='select-placeholder' disabled selected style='display:none;' value="">previous
                                    logos
                                </option>
                            </select>
                            <i></i>
                        </label>
                        {!! Form::text('logos['.$i.'][logo]', $slide->slideables()[$k]->name, ['class' => 'morris-presentation-slide-logo-name']) !!}
                        {!! Form::hidden('logos['.$i.'][new-title]', 'false',['class'=>'onchange']) !!}
                    </div>
                @else
                    <div class="morris-uploader format-16_9_wide" data-id="{{$i}}">
                        <span class="logo-text">click here to add logo <br>
                        please upload images with a 4:3 ratio <br>
                    the optimum size is 1920 x 1440 pixels
                        </span>
                        <img src="{{ asset('images/16_9_transparent.png') }}"/>
                        {!! Form::file( 'logos['.$i.'][image]' , ['accept'=>'image/*']) !!}
                        {!! Form::hidden('logos['.$i.'][new-image]', 'false',['class'=>'onchange']) !!}
                        {!! Form::hidden('logos['.$i.'][attachedLogoId]', '', [ 'class'=> 'attached-logo'] ) !!}
                        {!! Form::hidden('logos['.$i.'][detachedLogoId]', '', [ 'class'=> 'detached-logo'] ) !!}
                        <a href="#popup_{{ $i }}" class="morris-presentation-slide-logo-popup-link js__fancybox">
                            <i class="fa fa-paragraph"></i> LOGO CONTENT
                        </a>
                        <div class="hide">
                            <div id="popup_{{ $i }}" class="morris-presentation-slide-logo-popup">
                                <div class="morris-redactor-label">Logo description</div>
                                {!! Form::textarea('logos['.$i.'][desc]', "",
                                ['class'=>'redactor-for-long-description', 'data-redactor-height'=>'300']) !!}
                                <button class="btn btn-primary pull-right" onclick="$.fancybox.close();return false;">SAVE AND CLOSE</button>
                            </div>
                        </div>
                        <div class="icons">
                            <a class="edit" href="#">
                                <i class="fa fa-pencil"></i>
                            </a>
                            <a class="remove" href="#">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="morris-presentation-slide-logo-select">
                            <select class="select form-control">
                                <option class='select-placeholder' disabled selected style='display:none;' value="">
                                    previous logos
                                </option>
                            </select>
                            <i></i>
                        </label>
                        {!! Form::text('logos['.$i.'][logo]', '', ['class' => 'morris-presentation-slide-logo-name']) !!}
                        {!! Form::hidden('logos['.$i.'][new-title]', 'false',['class'=>'onchange']) !!}
                    </div>
                @endif

            </div>
        </div>
    @endfor
</div>

<hr/>

<div class="row">
    <div class="col-xs-3 col-xs-offset-6">
        {!! Form::submit('Save - add another image', ['class'=>'btn btn-primary btn-block morris-ajax-form-submit',
        'name'=>'addmore']) !!}
    </div>
    <div class="col-xs-3">
        {!! Form::submit('Save - return to presentation', ['class'=>'btn btn-primary btn-block morris-ajax-form-submit',
        'name'=>'return']) !!}
    </div>
</div>
{!! Form::close() !!}

<hr/>

