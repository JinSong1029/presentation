<div class = "row manage-model">
    @if( isset($section) )
        <div class = "col-lg-12">
            <h2>Edit default </h2>
        </div>
        {!! Form::open(['route' => ['defaults.update', $section->id] , 'method' => 'put', 'id'=>'update_default_section' , 'class'=>'update-row-form' , 'data-id'=> $section->id]) !!}
    @else
        <div class = "col-lg-12">
            <h2>Create new default</h2>
        </div>
        {!! Form::open(['url' => 'defaults', 'method' => 'post', 'id'=>'create_default_section']) !!}
        {!! Form::hidden('position',count($sections)+1) !!}
    @endif
    <div class = "col-lg-4 col-md-4 col-sm-5 col-xs-12">
        {!! Form::text('name', Input::old('name', isset($section) ? $section->name : Input::old('name')), ['class' => 'form-control input-lg', 'placeholder' => 'Name']) !!}
        {!! $errors->first('name', '<div class="alert alert-danger">:message</div>') !!}
    </div>

        <div class = "hidden-xs col-lg-3 col-md-3 col-lg-offset-1 col-md-offset-1 col-sm-2 col-xs-12">
            <a href = "{{ url('/defaults') }}" class = "btn btn-cancel btn-lg btn-block btn-default">Cancel</a>
        </div>

        <div class = "hidden-xs col-lg-3 col-md-3 col-lg-offset-1 col-md-offset-1 col-sm-2 col-xs-12">
    @if( isset($section) )
            {!! Form::submit('Update', ['class' => 'btn btn-lg btn-primary btn-block']) !!}
        @else
            {!! Form::submit('Create default', ['class' => 'btn btn-lg btn-primary btn-block']) !!}
        @endif
    </div>

    <div class = "clearfix offset-height-20 visible-xs-*"></div>
    <div class = "visible-xs-block">
        @if(! isset($section) )
            {!! Form::submit('Create default', ['class' => 'btn btn-lg btn-primary btn-block']) !!}
        @else
            {!! Form::submit('Update', ['class' => 'btn btn-lg btn-primary btn-block']) !!}
        @endif
    </div>
    <div class = "visible-xs-block">
        <a href = "{{ url('/defaults') }}" class = "btn btn-cancel btn-lg btn-block">Cancel</a>
    </div>
    {!! Form::close() !!}
</div>