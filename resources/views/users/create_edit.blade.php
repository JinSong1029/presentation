<div class = "row manage-model">
    @if( isset($user) )
        <div class = "col-lg-12">
            <div class="row">
                <h2>Edit user</h2>
            </div>
        </div>
        {!! Form::open(['route' => ['users.update', $user->id] , 'method' => 'put', 'id'=>'update_user', 'class'=>'update-row-form' , 'data-id'=> $user->id])!!}
    @else
        <div class = "col-lg-12">
            <div class="row">
                <h2>Create new user</h2>
            </div>
        </div>
        {!! Form::open(['url' => 'users', 'method' => 'post', 'id'=>'create_user']) !!}
    @endif
    <div class="row">
        <div class = "col-lg-3 col-md-3 col-sm-4 col-xs-12">
            {!! Form::text('name', Input::old('name', isset($user) ? $user->name : Input::old('name')), ['class' => 'form-control input-lg appellative', 'placeholder' => 'Name']) !!}
            {!! $errors->first('name', '<div class="alert alert-danger">:message</div>') !!}
        </div>
        <div class = "col-lg-3 col-md-3 col-sm-4 col-xs-12">
            {!! Form::text('password',isset($user) ? $user->password_open : Input::old('password'), ['class' => 'form-control input-lg', 'placeholder' => 'Password']) !!}
            {!! $errors->first('password', '<div class="alert alert-danger">:message</div>') !!}
        </div>

        <div class = "hidden-xs col-lg-3 col-md-3 col-sm-2 col-xs-12">
            <a href = "{{ url('/users') }}" class = "btn btn-cancel btn-lg btn-block btn-default">Cancel</a>
        </div>
        <div class = "visible-xs-block col-xs-12">
            @if( isset($user) )
                {!! Form::submit('Create', ['class' => 'btn btn-lg btn-primary btn-block']) !!}
            @else
                {!! Form::submit('Update', ['class' => 'btn btn-lg btn-primary btn-block']) !!}
            @endif
        </div>
        <div class = "visible-xs-block col-xs-12">
            <a href = "{{ url('/users') }}" class = "btn btn-cancel btn-lg btn-block btn-default">Cancel</a>
        </div>

        <div class = "hidden-xs col-lg-3 col-md-3 col-sm-2 col-xs-12">
            @if( isset($user) )
                {!! Form::submit('Update', ['class' => 'btn btn-lg btn-primary btn-block']) !!}
            @else
                {!! Form::submit('Create', ['class' => 'btn btn-lg btn-primary btn-block']) !!}
            @endif
        </div>
    </div>
    
    {!! Form::close() !!}
</div>