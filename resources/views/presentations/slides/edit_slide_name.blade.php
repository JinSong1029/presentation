<div class="row">
    <div class="morris-presentation-slide-form">
        {!! Form::open(['url' => '/slides/'. $slide->id, 'method' => 'put','id'=>'edit_slide']) !!}
            <div class="col-md-3">
                {!! Form::text('slide-name', $slide->name, ['class' => 'form-control buttons_slide'] )!!}
                {!! Form::hidden('slide', '',['class'=>'onchange']) !!}
            </div>
            <div class="col-md-3">
                {!! Form::hidden('itemId',$slide->id) !!}
                {!! Form::submit('Cancel', ['class'=>'btn edit_cancel btn-block btn-default buttons_slide']) !!}
            </div>
            <div class="col-md-3">
                {!! Form::hidden('itemId',$slide->id) !!}
                {!! Form::submit('Update slide name', ['class'=>'btn btn-primary btn-block edit_update']) !!}
            </div>
        {!! Form::close() !!}
    </div>
    <div class="morris-delete-confirm-form">
        {!! Form::open(['url' =>'/slides/'.$slide->id.'/deleteItem', 'class'=>'morris-ajax-form']) !!}
        <div class="col-md-3">
            {!! Form::hidden('itemType', $slide->type ) !!}
            {!! Form::hidden('itemId', '', ['class'=>'image-id-holder']) !!}
            {!! Form::submit('Delete ' .$slide->type, ['class'=>'btn btn-danger btn-block morris-ajax-form-submit', 'name'=> 'delete-confirmed']) !!}
        </div>
        <div class="col-md-3">
            <a href="#" class="btn btn-default btn-block cancel">Cancel</a>
        </div>
        {!! Form::close() !!}

        {{--
        <div class="col-md-3">
            <button class="btn btn-danger btn-block delete_slide_confirmed">Delete {{ $slide->type }}</button>
        </div>
        <div class="col-md-3">
            <a href="#" class="btn btn-default btn-block cancel">Cancel</a>
        </div>
--}}
    </div>

    <div class="morris-slide-delete-confirm-form">
        <div class="col-md-3">
            <button class="btn btn-danger btn-block delete_slide_confirmed">Delete {{ $slide->type }} slide</button>
        </div>
        <div class="col-md-3">
            <a href="#" class="btn btn-default btn-block cancel">Cancel</a>
        </div>
    </div>
</div>
<div class="morris-presentation-slide-redactor">
    <div class="morris-presentation-slide-view">
        <a data-action="preview" data-slide="{{$slide->id}}" class="morris-presentation-icons edit_slide morris-ajax-form-submit">
            <i class="fa fa-eye" style="color: #ddd;"></i>
        </a>
    </div>
    <div class="morris-presentation-slide-edit">
        <a href="#" class="morris-presentation-icons edit_slide buttons_slide">
            <i class="fa fa-pencil"></i>
        </a>
    </div>
    <div class="morris-presentation-slide-delete">
        <a href="#" class="morris-presentation-icons delete_slide buttons_slide">
            <i class="fa fa-times"></i>
        </a>
    </div>
</div>