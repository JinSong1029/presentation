<div class="morris-presentation-slide-title">
    <h4 class="serif">{{ $slide->name }}</h4>
    @include('presentations.slides.edit_slide_name')
</div>
<hr/>

<div class="row">
    <!-- @foreach($slide->teams as $item)
        @include('presentations.slides.team.block')

        @if(isset($subslide) && $item->id == $subslide)
            <?php $editSlide = $item; ?>
        @endif
    @endforeach -->

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
<div class="row">
    @if(isset($subslide))
        {!! Form::open(['route' => ['teams.update', $subslide], 'method' => 'PUT', 'files'=>true,
        'class'=>'morris-ajax-form submit-subslide','id'=>'update_team']) !!}
    @else
        {!! Form::open(['route' => ['teams.store'], 'method' => 'POST', 'files'=>true,
        'class'=>'morris-ajax-form submit-subslide','id'=>'create_team']) !!}
        {!! Form::hidden('slide_id', $slide->id) !!}
    @endif

        {!! Form::hidden('double', 0) !!}
        {!! Form::hidden('position', 0) !!}

    <div id="validation-errors"></div>
    <div class="col-xs-12">
        <h2 class="morris-page-sub-title">Introduction</h2>
    </div>
    <div class="col-xs-6">
        <div class="form-group">
            <label class="col-xs-12">Heading
                {!! Form::text('heading', isset($subslide->label) ? $subslide->label : "",
                ['class'=>'form-control input-sm', 'placeholder'=>'Subheading', 'style'=>'width: 100%;']) !!}
            </label>
        </div>
    </div>
    <div class="col-xs-6">

        <div class="form-group">
            <div class="morris-redactor-label-logo">Text</div>
            {!! Form::textarea('text', isset($subslide) ? $subslide->desc : "", ['class'=>'redactor-for-text small','data-redactor-height'=>'200','data-enter-key'=>'false']) !!}
        </div>
    </div>
    <div class="clearfix"></div>
    <hr/>
    <div class="col-xs-12">
        <div class="col-xs-12 morris-presentation-slide-title">
            <h4 class="serif">Team</h4>
            <!-- @include('presentations.slides.edit_slide_name') -->
        </div>
    </div>
    <div class="clearfix"></div>





    <div class="col-xs-12">
        @foreach($slide->teams as $item)
            @include('presentations.slides.team.block')

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
    <div class="clearfix"></div>
    <hr/>
    <div class="col-xs-6">
        <div class="form-group">
            <label class="col-xs-12">Heading
                {!! Form::text('label', isset($editSlide->label) ? $editSlide->label : "",
                ['class'=>'form-control input-sm', 'placeholder'=>'Heading', 'style'=>'width: 100%;']) !!}
            </label>
        </div>
        
        <div class="col-xs-8 col-md-6" style="margin-top: 20px;">
            <div class="morris-presentation-slide-team">

                @if ( isset($editSlide) )

                    <div class="morris-uploader format-16_9_wide uploaded" data-id="{{1}}"  data-image-id = "{{ $editSlide->id }}"
                            style="background-image: url('{{ asset('img/teams/'.$editSlide->image) }}')">
                        <span class="logo-text">Click here to add SVG <br>
                        please upload images with a 1:1 ratio
                        </span>
                        <img src="{{ asset('images/16_9_transparent.png') }}"/>
                        {!! Form::file( 'image' , ['accept'=>'image/*']) !!}
                        {!! Form::hidden('new-image', 'false',['class'=>'onchange']) !!}
                        {!! Form::hidden('id', @($editSlide->id) ) !!}
                        {!! Form::hidden('attachedLogoId', '', [ 'class'=> 'attached-logo'] ) !!}
                        {!! Form::hidden('detachedLogoId', '', [ 'class'=> 'detached-logo'] ) !!}
                        <a href="#popup_1" class="morris-presentation-slide-logo-popup-link js__fancybox">
                            <i class="fa fa-paragraph"></i> TEAM CONTENT
                        </a>
                        <div class="hide">
                            <div id="popup_1" class="morris-presentation-slide-logo-popup">
                                <div class="morris-redactor-label">Team description</div>
                                {!! Form::textarea('teams[desc]', $editSlide->desc,
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
                                    teams
                                </option>
                            </select>
                            <i></i>
                        </label>
                        {!! Form::text('logos[logo]', $editSlide->image, ['class' => 'morris-presentation-slide-logo-name']) !!}
                        {!! Form::hidden('logos[new-title]', 'false',['class'=>'onchange']) !!}
                    </div>
                @else
                    <div class="morris-uploader format-16_9_wide" data-id="{{1}}">
                        <span class="logo-text">Click here to add SVG <br>
                        please upload images with a 1:1 ratio
                        </span>
                        <img src="{{ asset('images/16_9_transparent.png') }}"/>
                        {!! Form::file( 'image' , ['accept'=>'image/*']) !!}
                        {!! Form::hidden('new-image', 'false',['class'=>'onchange']) !!}
                        {!! Form::hidden('attachedLogoId', '', [ 'class'=> 'attached-logo'] ) !!}
                        {!! Form::hidden('detachedLogoId', '', [ 'class'=> 'detached-logo'] ) !!}
                        <a href="#popup_1" class="morris-presentation-slide-logo-popup-link js__fancybox">
                            <i class="fa fa-paragraph"></i> TEAM CONTENT
                        </a>
                        <div class="hide">
                            <div id="popup_1" class="morris-presentation-slide-logo-popup">
                                <div class="morris-redactor-label">Team description</div>
                                {!! Form::textarea('logos[desc]', "",
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
                                    previous teams
                                </option>
                            </select>
                            <i></i>
                        </label>
                        {!! Form::text('logos[logo]', '', ['class' => 'morris-presentation-slide-logo-name']) !!}
                        {!! Form::hidden('logos[new-title]', 'false',['class'=>'onchange']) !!}
                    </div>
                @endif

            </div>
        </div>
    </div>
    <div class="col-xs-6">

        <div class="form-group">
            <div class="morris-redactor-label-logo">Biography</div>
            {!! Form::textarea('desc', isset($editSlide) ? $editSlide->desc : "", ['class'=>'redactor-for-text small','data-redactor-height'=>'200','data-enter-key'=>'false']) !!}
        </div>

    </div>

    <div class="col-xs-offset-6 col-xs-6" style="margin-top: 30px;">
        <div class="row">
            <div class="col-xs-6">
                {!! Form::submit('Save - add another item', ['class'=>'btn btn-primary btn-block morris-ajax-form-submit',
                'name'=>'addmore']) !!}
            </div>
            <div class="col-xs-6">
                {!! Form::submit('Save - return to presentation', ['class'=>'btn btn-primary btn-block morris-ajax-form-submit',
                'name'=>'return']) !!}
            </div>
        </div>
    </div>
    {!! Form::close() !!}


</div>

<hr/>