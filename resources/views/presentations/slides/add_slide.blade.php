@extends('admin')
@section('content')
    <h4>Add slide</h4>
    {!! Form::open(['url' => 'slides', 'method' => 'post']) !!}
    {!! Form::hidden('sectionId',1) !!}
    {!! Form::text('name') !!}
    @include('presentations.partials.typesSelect')
    {!! Form::submit('Add slide') !!}
    {!! Form::close() !!}

    <hr>
    <h4>Add tomb</h4>
    {!! Form::open(['route' => ['tombstones.store', 1], 'method' => 'POST','files'=>true]) !!}
    {!! Form::hidden('slide_id',1) !!}
    {!! Form::text('label') !!}
    {!! Form::textarea('desc') !!}
    {!! Form::file('image') !!}

    {!! Form::submit('Add tombstone') !!}
    {!! Form::close() !!}
    <hr>
    <h4>Update tomb</h4>
    {!! Form::open(['route' => ['tombstones.update', 1], 'method' => 'PUT','files'=>true]) !!}

    {!! Form::text('label') !!}
    {!! Form::textarea('desc') !!}
    {!! Form::file('image') !!}

    {!! Form::submit('Add tombstone') !!}
    {!! Form::close() !!}


    <hr>
    <h4>Delete tomb</h4>
    {!! Form::open(['route' => ['tombstones.destroy', 1], 'method' => 'DELETE']) !!}
    {!! Form::submit('Del tombstone') !!}
    {!! Form::close() !!}

    <hr>
    <h4>Add image</h4>
    {!! Form::open(['route' => ['images.store', 1], 'method' => 'POST','files'=>true]) !!}

    {!! Form::text('name') !!}
    {!! Form::hidden('slide_id',1) !!}
    {!! Form::file('image') !!}

    {!! Form::submit('Add image') !!}
    {!! Form::close() !!}

    <hr>
    <h4>Update image</h4>
    {!! Form::open(['route' => ['images.update', 1], 'method' => 'PUT','files'=>true]) !!}

    {!! Form::text('name') !!}
    {!! Form::text('logo') !!}

    {!! Form::file('image') !!}

    {!! Form::submit('Add image') !!}
    {!! Form::close() !!}

    <hr>
    <h4>texts update</h4>
    {!! Form::open(['route' => ['texts.update', 1], 'method' => 'PUT']) !!}

    {!! Form::textarea('text') !!}

    {!! Form::submit('Add image') !!}
    {!! Form::close() !!}

    <hr>
    <h4>Update videos</h4>
    {!! Form::open(['route' => ['videos.update', 1], 'method' => 'PUT','files'=>true]) !!}

    {!! Form::text('title') !!}
    {!! Form::text('url') !!}
    {!! Form::file('image') !!}

    {!! Form::submit('Add video') !!}
    {!! Form::close() !!}

@stop