<div class="row manage-model">

    <h2>Edit client key</h2>

    <div>
        {!! Form::open(['url' => 'presentations/'. $presentation->id.'/editKey', 'method' => 'post', 'id'=>'refresh_key']) !!}

        <div class="col-lg-3 col-md-3 col-sm-5 col-xs-12" style="padding: 0px">
            {!! Form::text('key', Input::old('key', $presentation->key), ['class' => 'form-control input-lg', 'placeholder' => 'Client name']) !!}
            {!! $errors->first('key', '<div class="alert alert-danger">:message</div>') !!}
        </div>
        <div class="hidden-xs col-lg-2 col-md-2  col-sm-2 col-xs-12">
            <a class="btn btn-cancel btn-lg btn-block edit_cancel" href="{!! URL::previous() !!}">Cancel</a>
        </div>
        <div class="hidden-xs col-lg-3 col-md-3  col-sm-2 col-xs-12">
            {!! Form::submit('Update key', ['class' => 'btn btn-lg btn-primary btn-block']) !!}
        </div>
        <div class="visible-xs-block">
            {!! Form::submit('Update key', ['class' => 'btn btn-lg btn-primary btn-block']) !!}
        </div>
        <div class="visible-xs-block">
            <a class="btn btn-cancel btn-lg btn-block edit_cancel" href="{!! URL::previous() !!}">Cancel</a>
        </div>
        {!! Form::close() !!}
    </div>
</div>
<hr>