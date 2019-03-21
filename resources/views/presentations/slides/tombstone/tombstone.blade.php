<div class="morris-presentation-slide-title">
    <h4 class="serif">{{ $slide->name }}</h4>
    @include('presentations.slides.edit_slide_name')
</div>
<hr/>

<div class="row">
    @foreach($slide->tombstones as $item)
        @include('presentations.slides.tombstone.block')

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
<div class="row">
    @if(isset($subslide))
        {!! Form::open(['route' => ['tombstones.update', $subslide], 'method' => 'PUT', 'files'=>true,
        'class'=>'morris-ajax-form submit-subslide','id'=>'update_tombstone']) !!}
    @else
        {!! Form::open(['route' => ['tombstones.store'], 'method' => 'POST', 'files'=>true,
        'class'=>'morris-ajax-form submit-subslide','id'=>'create_tombstone']) !!}
        {!! Form::hidden('slide_id', $slide->id) !!}
    @endif

        {!! Form::hidden('double', 0) !!}
        {!! Form::hidden('position', 0) !!}

    <div id="validation-errors"></div>

    <div class="col-xs-6">
        <label class="col-xs-12">Image</label>
        <div class="col-xs-8 col-md-6">
            <div class="morris-presentation-slide-tomb">
                @if ( isset($editSlide) )

                    <div class="morris-uploader format-16_9_wide uploaded" data-id="{{1}}"  data-image-id = "{{ $editSlide->id }}"
                            style="background-image: url('{{ asset('img/tombstones/'.$editSlide->image) }}')">
                        <span class="logo-text">Click here to add image <br>
                        please upload images with a 1:1 ratio <br>
                        The optimun size is 563 x 563
                        </span>
                        <img src="{{ asset('images/16_9_transparent.png') }}"/>                        
                        {!! Form::file( 'image' , ['accept'=>'image/*']) !!}
                        {!! Form::hidden('new-image', 'false',['class'=>'onchange']) !!}
                        {!! Form::hidden('id', @($editSlide->id) ) !!}
                        {!! Form::hidden('attachedLogoId', '', [ 'class'=> 'attached-logo'] ) !!}
                        {!! Form::hidden('detachedLogoId', '', [ 'class'=> 'detached-logo'] ) !!}
                        <a href="#popup_1" class="morris-presentation-slide-logo-popup-link js__fancybox">
                            <i class="fa fa-paragraph"></i> TOMBSTONE CONTENT
                        </a>
                        <div class="hide">
                            <div id="popup_1" class="morris-presentation-slide-logo-popup">
                                <div class="morris-redactor-label">Tombstone description</div>
                                <!-- {!! Form::textarea('desc', $editSlide->desc,
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
                                    images
                                </option>
                            </select>
                            <i></i>
                        </label>
                        <!-- {!! Form::text('logo', $editSlide->image, ['class' => 'morris-presentation-slide-logo-name']) !!} -->
                        {!! Form::hidden('new-title', 'false',['class'=>'onchange']) !!}
                    </div>
                @else
                    <div class="morris-uploader format-16_9_wide" data-id="{{1}}">
                        <span class="logo-text">Click here to add image <br>
                        please upload images with a 1:1 ratio <br>
                        The optimun size is 563 x 563
                        </span>
                        <img src="{{ asset('images/16_9_transparent.png') }}"/>
                        {!! Form::file( 'image' , ['accept'=>'image/*']) !!}
                        {!! Form::hidden('new-image', 'false',['class'=>'onchange']) !!}
                        {!! Form::hidden('attachedLogoId', '', [ 'class'=> 'attached-logo'] ) !!}
                        {!! Form::hidden('detachedLogoId', '', [ 'class'=> 'detached-logo'] ) !!}
                        <a href="#popup_1" class="morris-presentation-slide-logo-popup-link js__fancybox">
                            <i class="fa fa-paragraph"></i> TOMBSTONE CONTENT
                        </a>
                        <div class="hide">
                            <div id="popup_1" class="morris-presentation-slide-logo-popup">
                                <div class="morris-redactor-label">Tombstone description</div>
                                <!-- {!! Form::textarea('desc', "",
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
                                    previous images
                                </option>
                            </select>
                            <i></i>
                        </label>
                        <!-- {!! Form::text('logo', '', ['class' => 'morris-presentation-slide-logo-name']) !!} -->
                        {!! Form::hidden('new-title', 'false',['class'=>'onchange']) !!}
                    </div>
                @endif

            </div>
        </div>

    </div>
    <div class="col-xs-6">
        <div class="form-group">
            <div class="morris-redactor-label-icon">Text</div>
            {!! Form::textarea('label', isset($editSlide) ? $editSlide->label : "", ['class'=>'redactor-for-text small','data-redactor-height'=>'150','data-enter-key'=>'false']) !!}            
        </div>
        {!! Form::hidden('desc', '') !!}
        {!! Form::hidden('presentationId', $presentation->id) !!}
        <div class="row">
            <div class="col-xs-6">
                {!! Form::submit('Save - add another tombstone', ['class'=>'btn btn-primary btn-block morris-ajax-form-submit',
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