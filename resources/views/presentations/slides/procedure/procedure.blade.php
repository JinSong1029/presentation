<div class="morris-presentation-slide-title">
    <h4 class="serif">{{ $slide->name }}</h4>
    @include('presentations.slides.edit_slide_name')
</div>
<hr/>
<div class="row">
    @foreach($slide->procedures as $item)
        @include('presentations.slides.procedure.block')

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
        {!! Form::open(['route' => ['procedures.update', $subslide], 'method' => 'PUT', 'files'=>true,
        'class'=>'morris-ajax-form submit-subslide','id'=>'update_tombstone']) !!}
    @else
        {!! Form::open(['route' => ['procedures.store'], 'method' => 'POST', 'files'=>true,
        'class'=>'morris-ajax-form submit-subslide','id'=>'create_tombstone']) !!}
        {!! Form::hidden('slide_id', $slide->id) !!}
    @endif


    <div id="validation-errors"></div>

    <div class="col-xs-6">
        <div class="morris-redactor-label">Label</div>
        {!! Form::textarea('label', isset($editSlide) ? $editSlide->label : "", ['class'=>'redactor',
        'data-redactor-height'=>'540','data-minimal'=>true,'data-remove-controls'=>'all']) !!}

    </div>
    <div class="col-xs-6">
        <div class="morris-redactor-label">Long description</div>
        {!! Form::textarea('desc', isset($editSlide) ? $editSlide->desc : "", [
            'class'=>'redactor-for-long-description',
            'data-redactor-height'=>'540',
            'data-remove-controls'=>'all'
        ]) !!}
        {!! Form::hidden('presentationId', $presentation->id) !!}
        <div class="row">
            <div class="col-xs-6">
                {!! Form::submit('Save - add another procedure', ['class'=>'btn btn-primary btn-block morris-ajax-form-submit',
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