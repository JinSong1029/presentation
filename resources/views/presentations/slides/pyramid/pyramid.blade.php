<div class="morris-presentation-slide-title">
    <h4 class="serif">{{ $slide->name }}</h4>
    @include('presentations.slides.edit_slide_name')
</div>
<hr/>
<div class="row">
    @foreach($slide->groups as $item)
        @include('presentations.slides.pyramid.block')

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
    {!! Form::open(['route' => ['pyramidGroups.update', $subslide], 'method' => 'PUT', 'files'=>true,
    'class'=>'morris-ajax-form submit-subslide','id'=>'update_tombstone']) !!}
@else
    {!! Form::open(['route' => ['pyramidGroups.store'], 'method' => 'POST', 'files'=>true,
    'class'=>'morris-ajax-form submit-subslide','id'=>'create_tombstone']) !!}
@endif

<div id="validation-errors"></div>
<div class="row">
    <div class="col-xs-6">
        <div class="form-group">
            <label>
                Headline
            </label><br/>
            {!! Form::text('title', isset($editSlide) ? $editSlide->title : "", ['class'=>'form-control']) !!}
        </div>
        <div class="form-group">
            <label>
                Comment
            </label><br/>
            {!! Form::textarea('content', isset($editSlide) ? $editSlide->content : "", ['class'=>'form-control', 'rows'=>'4']) !!}
        </div>
    </div>
    <div class="col-xs-6">
        <div class="form-group">
            <label>
                Position
            </label><br/>
            <label><input type="radio" name="position" value="1"{{ isset($editSlide) && $editSlide->pivot->position == 1 ? " checked" : "" }}> 1</label> &nbsp;
            <label><input type="radio" name="position" value="2"{{ isset($editSlide) && $editSlide->pivot->position == 2 ? " checked" : "" }}> 2</label><br>
            <label><input type="radio" name="position" value="3"{{ isset($editSlide) && $editSlide->pivot->position == 3 ? " checked" : "" }}> 3</label> &nbsp;
            <label><input type="radio" name="position" value="4"{{ isset($editSlide) && $editSlide->pivot->position == 4 ? " checked" : "" }}> 4</label><br>
            <label><input type="radio" name="position" value="5"{{ isset($editSlide) && $editSlide->pivot->position == 5 ? " checked" : "" }}> 5</label> &nbsp;
            <label><input type="radio" name="position" value="6"{{ isset($editSlide) && $editSlide->pivot->position == 6 ? " checked" : "" }}> 6</label>
        </div>
        <div class="form-group">
            <label>
            </label>
            <input type="hidden" name="inside_triangle" value="0">
        </div>
    </div>
</div>

{!! Form::hidden('slide_id', $slide->id) !!}
{!! Form::hidden('presentationId', $presentation->id) !!}
{!! Form::hidden('engagedPositions', implode(',',$engagedPositions)) !!}

<hr/>

<div class="row">
    <div class="col-xs-offset-6 col-xs-3">
        {!! Form::submit('Save - add another comment', ['class'=>'btn btn-primary btn-block morris-ajax-form-submit',
        'name'=>'addmore']) !!}
    </div>
    <div class="col-xs-3">
        {!! Form::submit('Save - return to presentation', ['class'=>'btn btn-primary btn-block morris-ajax-form-submit',
        'name'=>'return']) !!}
    </div>
</div>
{!! Form::close() !!}

<hr/>