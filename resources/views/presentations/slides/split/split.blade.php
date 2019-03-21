<div class="morris-presentation-slide-title">
    <h4 class="serif">{{ $slide->name }}</h4>
    @include('presentations.slides.edit_slide_name')
</div>

<div id="validation-errors"></div>
<div class="row">
    @for($i=0;$i<$slide->splits->count();$i++)

        @if($i==0)
            <div class="col-xs-12 col-md-6">
                {!! Form::open(['route' => ['splits.update', $slide->splits[$i]->id], 'method' => 'PUT', 'files'=>true,
                    'class'=>'morris-ajax-form submit-subslide','id'=>'update_tombstone']) !!}

                {!! Form::hidden('type','text') !!}

                <label>Text</label>
                {!! Form::textarea('text', isset($slide->splits[$i]->text) ? $slide->splits[$i]->text : "",
                ['class'=>'form-control redactor-for-text','data-redactor-height'=>'282']) !!}

                {!! Form::close() !!}
            </div>

        @else
            <div class="col-xs-12 col-md-6">
                {!! Form::open(['route' => ['splits.update', $slide->splits[$i]->id], 'method' => 'PUT', 'files'=>true,
                'class'=>'morris-ajax-form submit-subslide','id'=>'update_tombstone']) !!}
                <div class="procedure-control">
                    <div style="margin-bottom: 5px">
                        <label class="radio-inline">
                            <input type="radio" name="type"
                                   value="text" {{ isset($slide->splits[$i]->image) && $slide->splits[$i]->image ===NULL ? "checked" : "" }} />
                            Text
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="type"
                                   value="image" {{ isset($slide->splits[$i]->image) && $slide->splits[$i]->image !== NULL ? "checked" : "" }} />
                            Image
                        </label>
                    </div>
                </div>
                <div class="procedure-desc">
                    {!! Form::textarea('text', isset($slide->splits[$i]->text) ? $slide->splits[$i]->text : "",
                    ['class'=>'form-control redactor-for-text','data-redactor-height'=>'282']) !!}
                    <br/>
                </div>
                <div class="procedure-image">
                    <div class="form-group">
                        <div class="morris-uploader format-16_9_wide {{ isset($slide->splits[$i]->image) ? "uploaded" : "" }}"
                             style="background-image: {{ isset($slide->splits[$i]) ? 'url('.asset('img/splits/'.$slide->splits[$i]->image).')' : "none" }}">
                     <span>Click to select image from disk <br>
                    Please upload images with a 16:9 ratio <br>
                    The optimum size is 2048 x 1152 pixels
                </span>
                            <img src="{{ asset('images/16_9_transparent.png') }}"/>
                            {!! Form::file('image', ['accept'=>'image/*']) !!}
                        </div>
                    </div>
                </div>
                <div class="procedure-control">
                    <div class="form-group">

                        <label class="radio-inline">
                            {!! Form::hidden('slide_id', $slide->id) !!}
                            {!! Form::hidden('presentationId', $presentation->id) !!}
                            <input type="radio" name="left"
                                   value="1" {{ (!isset($slide->splits[$i]) || (isset($slide->splits[$i]->left) && $slide->splits[$i]->left)) == 1 ? "checked" : "" }} />
                            Align Left
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="left"
                                   value="0" {{ isset($slide->splits[$i]->left) && $slide->splits[$i]->left == 0 ? "checked" : "" }} />
                            Align
                            Right
                        </label><br/>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        @endif

    @endfor
</div>

<hr/>

<div class="row">
    <div class="col-xs-offset-6 col-xs-3">
        <a href="{{ route('presentations.edit',['id'=>$presentation->id]) }}" class="btn btn-cancel btn-block btn-default">Cancel</a>
    </div>
    <div class="col-xs-3">
        {!! Form::submit('Save - return to presentation', ['class'=>'btn btn-primary btn-block morris-ajax-form-submit',
      'name'=>'submit_multiple']) !!}
    </div>
</div>


<hr/>