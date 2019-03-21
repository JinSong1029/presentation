<div class="morris-presentation-slide-title">
    <h4 class="serif">{{ $slide->name }}</h4>
    @include('presentations.slides.edit_slide_name')
</div>
<hr/>
<!-- 
<div class="row">
    @foreach($slide->gallarys as $item)
        @include('presentations.slides.gallary.block')

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


<hr/> -->


@foreach($slide->gallarys as $item)
    <?php $editSlide = $item; ?>
@endforeach
<div class="row">
    <!-- @if(isset($subslide))
        {!! Form::open(['route' => ['gallarys.update', $subslide], 'method' => 'PUT', 'files'=>true,
        'class'=>'morris-ajax-form submit-subslide','id'=>'update_gallary']) !!}
    @else
        {!! Form::open(['route' => ['gallarys.store'], 'method' => 'POST', 'files'=>true,
        'class'=>'morris-ajax-form submit-subslide','id'=>'create_gallary']) !!}
        {!! Form::hidden('slide_id', $slide->id) !!}
    @endif -->
    @if(isset($editSlide))
        {!! Form::open(['route' => ['gallarys.update', $editSlide->id], 'method' => 'PUT', 'files'=>true,
        'class'=>'morris-ajax-form submit-subslide','id'=>'update_gallary']) !!}
    @else
        {!! Form::open(['route' => ['gallarys.store'], 'method' => 'POST', 'files'=>true,
        'class'=>'morris-ajax-form submit-subslide','id'=>'create_gallary']) !!}
        {!! Form::hidden('slide_id', $slide->id) !!}
    @endif

        
    {!! Form::hidden('position', 0) !!}

    <div id="validation-errors"></div>
    <div class="col-xs-12" style="margin-bottom: 20px;">
        <div class="form-group" style="margin-bottom: 0px">
            <label>
                <input type="radio" class="chooseImagesTemplete" data-slide="{{isset($editSlide) ? $editSlide->double : ''}}" name="double" value="1"  @if(isset($editSlide) && $editSlide->double) checked @else checked @endif>
                4 Images Templete</label>
        </div>
        <div class="form-group">
            <label>
                <input type="radio" class="chooseImagesTemplete" data-slide="{{isset($editSlide) ? $editSlide->double : ''}}" name="double" value="0"  @if(isset($editSlide) && !$editSlide->double) checked @endif>
                2 Images Templete</label>
        </div>
    </div>
    <div class="col-xs-12" style="margin-bottom: 20px;">
        <div class="form-group">
            <label class="col-xs-6" style="padding: 0;">Heading
                {!! Form::text('label', isset($editSlide->label) ? $editSlide->label : "",
                ['class'=>'form-control input-sm', 'placeholder'=>'heading', 'style'=>'width: 100%;']) !!}
            </label>
        </div>
    </div>
    <div class="col-xs-6">
        
        <div class="form-group">
            <div class="morris-uploader format-16_9_wide {{ isset($editSlide) ? 'uploaded' : '' }}" data-image-id = "{{ isset($editSlide) ? $editSlide->id : '' }}"
                 style="background-image: {{ isset($editSlide) ? 'url('.asset('img/gallarys/'.$editSlide->image).')' : 'none' }}">
                <span>Click to select image from disk <br>
                    Please upload images with a 2:1 ratio <br>
                    The optimum size is 1920 x 920 pixels
                </span>
                <img src="{{ asset('images/16_9_transparent.png') }}"/>
                {!! Form::file('image', ['accept'=>'image/*']) !!}
            </div>
        </div>


    </div>
    <div class="col-xs-6">
        <div class="form-group">
            <div class="morris-uploader format-16_9_wide {{ isset($editSlide) ? 'uploaded' : '' }}" data-image-id = "{{ isset($editSlide) ? $editSlide->id : '' }}"
                 style="background-image: {{ isset($editSlide) ? 'url('.asset('img/gallarys/'.$editSlide->image2).')' : 'none' }}">
                <span>Click to select image from disk <br>
                    Please upload images with a 2:1 ratio <br>
                    The optimum size is 1920 x 920 pixels
                </span>
                <img src="{{ asset('images/16_9_transparent.png') }}"/>
                {!! Form::file('image2', ['accept'=>'image/*']) !!}
            </div>
        </div>
    </div>
    <div class="col-xs-6 templete-3 {{isset($editSlide) && !$editSlide->double? 'hidden': ''}}">
        <div class="form-group">
            <div class="morris-uploader format-16_9_wide {{ isset($editSlide) &&  $editSlide->image3 ? 'uploaded' : '' }}" data-image-id = "{{ isset($editSlide) ? $editSlide->id : '' }}"
                 style="background-image: {{ isset($editSlide) ? 'url('.asset('img/gallarys/'.$editSlide->image3).')' : 'none' }}">
                <span>Click to select image from disk <br>
                    Please upload images with a 2:1 ratio <br>
                    The optimum size is 1920 x 920 pixels
                </span>
                <img src="{{ asset('images/16_9_transparent.png') }}"/>
                @if(isset($editSlide))
                    @if($editSlide->double)
                    {!! Form::file('image3', ['accept'=>'image/*']) !!}
                    {!! Form::hidden('text3', '') !!}
                    @else
                    {!! Form::file('text3', ['accept'=>'image/*']) !!}
                    {!! Form::hidden('image3', '') !!}
                    @endif
                @else
                    {!! Form::file('image3', ['accept'=>'image/*']) !!}
                    {!! Form::hidden('text3', '') !!}
                @endif

            </div>
        </div>
    </div>
    <div class="col-xs-6 templete-4 {{isset($editSlide) && !$editSlide->double? 'hidden': ''}}">
        <div class="form-group">
            <div class="morris-uploader format-16_9_wide {{ isset($editSlide) && $editSlide->image3 ? 'uploaded' : '' }}" data-image-id = "{{ isset($editSlide) ? $editSlide->id : '' }}"
                 style="background-image: {{ !isset($editSlide) ? 'none': 'url('.asset('img/gallarys/'.$editSlide->image4).')'  }}">
                <span>Click to select image from disk <br>
                    Please upload images with a 2:1 ratio <br>
                    The optimum size is 1920 x 920 pixels
                </span>
                <img src="{{ asset('images/16_9_transparent.png') }}"/>
                @if(isset($editSlide))
                    @if($editSlide->double)
                    {!! Form::file('image4', ['accept'=>'image/*']) !!}
                    {!! Form::hidden('text4', '') !!}
                    @else
                    {!! Form::file('text4', ['accept'=>'image/*']) !!}
                    {!! Form::hidden('image4', '') !!}
                    @endif
                @else
                    {!! Form::file('image4', ['accept'=>'image/*']) !!}
                    {!! Form::hidden('text4', '') !!}
                @endif
            </div>
        </div>
    </div>
    <div class="col-xs-6 col-xs-offset-6">

        {!! Form::hidden('desc', '') !!}
        {!! Form::hidden('presentationId', $presentation->id) !!}
        <div class="row">
            <!-- <div class="col-xs-6">
                {!! Form::submit('Save - add another images', ['class'=>'btn btn-primary btn-block morris-ajax-form-submit',
                'name'=>'addmore']) !!}
            </div> -->
            <div class="col-xs-6 col-xs-offset-6">
                {!! Form::submit('Save - return to presentation', ['class'=>'btn btn-primary btn-block morris-ajax-form-submit',
                'name'=>'return']) !!}
            </div>
        </div>
    </div>
    {!! Form::close() !!}


</div>

<hr/>