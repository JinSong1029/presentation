<div class="morris-presentation-slide-title">
    <h4 class="serif">{{ $slide->name }}</h4>
    @include('presentations.slides.edit_slide_name')
</div>
<hr/>

<div class="row">
    @foreach($slide->icons as $item)
        @include('presentations.slides.icon.block')

        @if(isset($subslide) && $item->id == $subslide)
            <?php $editSlide = $item; ?>
        @endif
    @endforeach

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
</div>
<hr/>

@if(isset($subslide))
    {!! Form::open(['route' => ['icons.updateLogos', $subslide], 'method' => 'PUT', 'files'=>true,
    'class'=>'morris-ajax-form submit-subslide']) !!}
@else
    {!! Form::open(['route' => ['icons.storeLogos'], 'method' => 'POST', 'files'=>true,
    'class'=>'morris-ajax-form submit-subslide']) !!}
    {!! Form::hidden('slide_id', $slide->id) !!}
@endif

        {!! Form::hidden('double', 0) !!}
        {!! Form::hidden('position', 0) !!}

<div class="row">
    <div id="validation-errors"></div>

    <div class="col-xs-6" style="padding: 0;">
        <div class="form-group">
            <label class="col-xs-12">Subheading
                {!! Form::text('logos[1][logo]', isset($editSlide->name) ? $editSlide->name : "",
                ['class'=>'form-control input-sm', 'placeholder'=>'Subheading', 'style'=>'width: 100%;']) !!}
            </label>
        </div>
        <!-- <div class="clearfix"></div> -->
        <div class="col-xs-8 col-md-6" style="margin-top: 20px;">
            <div class="morris-presentation-slide-icon">

                @if ( isset($editSlide) )                    

                    <div class="morris-uploader format-16_9_wide uploaded" data-id="{{1}}"  data-image-id = "{{ $editSlide->id }}"
                        style="background-image: url('{{ asset('img/icons/'.$editSlide->image) }}')">
                        <span class="logo-text">click here to add SVG <br>
                            please upload images with a 1:1 ratio
                        </span>
                        <img src="{{ asset('images/16_9_transparent.png') }}"/>
                        {!! Form::file( 'logos[1][image]' , ['accept'=>'image/svg+xml']) !!}
                        {!! Form::hidden('logos[1][new-image]', 'false',['class'=>'onchange']) !!}
                        {!! Form::hidden('logos[1][id]', @($editSlide->id) ) !!}
                        {!! Form::hidden('logos[1][attachedLogoId]', '', [ 'class'=> 'attached-logo'] ) !!}
                        {!! Form::hidden('logos[1][detachedLogoId]', '', [ 'class'=> 'detached-logo'] ) !!}
                        <a href="#popup_1" class="morris-presentation-slide-icon-popup-link js__fancybox">
                            <i class="fa fa-paragraph"></i> ICON CONTENT
                        </a>
                        <div class="hide">
                            <div id="popup_1" class="morris-presentation-slide-logo-popup">
                                <div class="morris-redactor-label">Icon description</div>
                                <!-- {!! Form::textarea('logos[1][desc]', $editSlide->desc,
                                ['class'=>'redactor-for-long-description', 'data-redactor-height'=>'300']) !!} -->
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
                                    icons
                                </option>
                            </select>
                            <i></i>
                        </label>
                        <!-- {!! Form::text('logos[1][logo]', $editSlide->name, ['class' => 'morris-presentation-slide-logo-name']) !!} -->
                        {!! Form::hidden('logos[1][new-title]', 'false',['class'=>'onchange']) !!}
                    </div>
                @else
                    <div class="morris-uploader format-16_9_wide" data-id="{{1}}">
                        <span class="logo-text">click here to add SVG <br>
                            please upload images with a 1:1 ratio
                        </span>
                        <img src="{{ asset('images/16_9_transparent.png') }}"/>
                        {!! Form::file( 'logos[1][image]' , ['accept'=>'image/svg+xml']) !!}
                        {!! Form::hidden('logos[1][new-image]', 'false',['class'=>'onchange']) !!}
                        {!! Form::hidden('logos[1][attachedLogoId]', '', [ 'class'=> 'attached-logo'] ) !!}
                        {!! Form::hidden('logos[1][detachedLogoId]', '', [ 'class'=> 'detached-logo'] ) !!}
                        <a href="#popup_1" class="morris-presentation-slide-logo-popup-link js__fancybox">
                            <i class="fa fa-paragraph"></i> ICON CONTENT
                        </a>
                        <div class="hide">
                            <div id="popup_1" class="morris-presentation-slide-logo-popup">
                                <div class="morris-redactor-label">Icon description</div>
                                <!-- {!! Form::textarea('logos[1][desc]', "",
                                ['class'=>'redactor-for-long-description', 'data-redactor-height'=>'300']) !!} -->
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
                                    previous icons
                                </option>
                            </select>
                            <i></i>
                        </label>
                        <!-- {!! Form::text('logos[1][logo]', '', ['class' => 'morris-presentation-slide-logo-name']) !!} -->
                        {!! Form::hidden('logos[1][new-title]', 'false',['class'=>'onchange']) !!}
                    </div>
                @endif

            </div>
        </div>
    </div>
    <div class="col-xs-6" style="padding: 0;">
        <div class="form-group">
            <div class="morris-redactor-label-icon">Text</div>
            {!! Form::textarea('logos[1][desc]', isset($editSlide) ? $editSlide->desc : "", ['class'=>'redactor-for-text small','data-redactor-height'=>'200','data-enter-key'=>'false']) !!}
        </div>
    </div>
</div>

<hr/>

<div class="row">
    <div class="col-xs-3 col-xs-offset-6">
        {!! Form::submit('Save - add another icon', ['class'=>'btn btn-primary btn-block morris-ajax-form-submit',
        'name'=>'addmore']) !!}
    </div>
    <div class="col-xs-3">
        {!! Form::submit('Save - return to presentation', ['class'=>'btn btn-primary btn-block morris-ajax-form-submit',
        'name'=>'return']) !!}
    </div>
</div>
{!! Form::close() !!}

<hr/>