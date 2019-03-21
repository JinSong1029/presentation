<div class="morris-presentation-slide-title">
    <h4 class="serif">{{ $slide->name }}</h4>
    @include('presentations.slides.edit_slide_name')
</div>
<hr/>
<div class="row">
    @foreach($slide->quotes as $item)
        @include('presentations.slides.quote.block')

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
    {!! Form::open(['route' => ['quotes.update', $subslide], 'method' => 'PUT', 'files'=>true,
    'class'=>'morris-ajax-form submit-subslide','id'=>'update_tombstone']) !!}
@else
    {!! Form::open(['route' => ['quotes.store'], 'method' => 'POST', 'files'=>true,
    'class'=>'morris-ajax-form submit-subslide','id'=>'create_tombstone']) !!}


    {!! Form::hidden('position', 0) !!}
@endif

<div id="validation-errors"></div>
<div class="row">
    <div class="col-xs-6">
        <div class="procedure-desc">
            <label>Description</label>
            {!! Form::textarea('quote', isset($editSlide->quote) ? $editSlide->quote : "",
            ['class'=>'redactor-for-text small','data-redactor-height'=>'110','data-enable-quote'=>true,'data-remove-controls'=>'all']) !!}
            <br/>
            <div class="form-group">
                <label>Author
                    {!! Form::text('author', isset($editSlide->author) ? $editSlide->author : "",
                    ['class'=>'form-control input-sm', 'placeholder'=>'Author name', 'style'=>'width: 300px;']) !!}
                </label>
            </div>
            <div class="form-group">
                <label>Role
                    {!! Form::text('role', isset($editSlide->role) ? $editSlide->role : "",
                    ['class'=>'form-control input-sm', 'placeholder'=>'Role', 'style'=>'width: 300px;']) !!}
                </label>
            </div>
        </div>
        <div class="procedure-image">
            <div class="form-group">
                <div class="morris-uploader format-16_9_wide {{ isset($editSlide) ? "uploaded" : "" }}"
                     style="background-image: {{ isset($editSlide) ? 'url('.asset('img/quotes/'.$editSlide->image).')' : "none" }}">
                     <span class="suggest_normal @if(isset($editSlide) && $editSlide->double) hidden @endif">Click to select image from disk <br>
                    Please upload images with a 2:1 ratio <br>
                    The optimum size is 1920 x 960 pixels
                </span>
                     <span class="suggest_double @if((isset($editSlide) && !$editSlide->double) || !isset($editSlide)) hidden @endif">Click to select image from disk <br>
                    Please upload images with a 4:1 ratio <br>
                    The optimum size is 1920 x 480 pixels
                </span>
                    <img src="{{ asset('images/16_9_transparent.png') }}"/>
                    {!! Form::file('image', ['accept'=>'image/*']) !!}
                </div>
            </div>
        </div>
    </div>

    <div class="col-xs-6">
        <div class="procedure-control">
            <div class="form-group">
                <label>
                    <input type="radio" name="type" value="quote" {{ isset($editSlide->type) && $editSlide->type == "quote" ? "checked" : "" }} /> Quote
                </label><br/>
                <label>
                    <input type="radio" name="type" value="image" {{ isset($editSlide->image) && $editSlide->image !== NULL ? "checked" : "" }} /> Image
                </label><br/><br/>
                <label>
                    {!! Form::hidden('slide_id', $slide->id) !!}
                    {!! Form::hidden('presentationId', $presentation->id) !!}
                    <input type="radio" name="double" class="suggest_normal_input" value="0" {{ isset($editSlide->double) && $editSlide->double == 0 ? "checked" : "" }} /> Normal 1/4
                </label><br/>
                <label>
                    <input type="radio" name="double" id="suggest_double" value="1" {{ isset($editSlide->double) && $editSlide->double == 1 ? "checked" : "" }} /> Double
                    {{--<input type="checkbox" name="double" {{ isset($editSlide->double) && $editSlide->double == 1 ? "checked" : "" }} /> Double--}}
                </label><br/>
            </div>
        </div>
    </div>
</div>

<hr/>

 <div class="row">
    <div class="col-xs-offset-6 col-xs-3">
        {!! Form::submit('Save - add another quote', ['class'=>'btn btn-primary btn-block morris-ajax-form-submit',
        'name'=>'addmore']) !!}
    </div>
    <div class="col-xs-3">
        {!! Form::submit('Save - return to presentation', ['class'=>'btn btn-primary btn-block morris-ajax-form-submit',
        'name'=>'return']) !!}
    </div>
</div>
{!! Form::close() !!}

<hr/>