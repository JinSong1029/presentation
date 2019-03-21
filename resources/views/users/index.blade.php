@extends('admin')

@section('content')
    @if (isset($title) && $title == 'Create new user')
        @include('users.create_edit')
    @elseif (isset($user))
        @include('users.create_edit')
    @else
        <div class="row manage-model">
            <div class="col-lg-6 col-md-6 col-sm-7">
            </div>
            <div class="clearfix vertical-margin visible-xs-block"></div>
            <div class="col-lg-3 col-lg-offset-3 col-md-3 col-md-offset-3 col-sm-3 col-sm-offset-2">
                <a href="{{ url('/users/create') }}" class="btn btn-lg btn-primary btn-block">Create new user</a>
            </div>
        </div>
    @endif
    <div class="row">
        <div class="col-md-12">
            <table class="table table-hover table-data-index sortable">
                <thead>
                <tr>
                    <th class="row-data-index-name">
                        {!! sort_by('name','Name',$request) !!}
                    </th>
                    <th class="row-data-index-email">
                        <strong><a> Password </a>
                        </strong>
                    </th>

                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)

                    <tr class="odd gradeX" data-row-index = {{$user->id}} >
                        <td class="table-name">{!! $user->name !!}</td>
                        <td class="table-password">{{$user->password_open}}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="edit-row-action text-right"><a class="icon-link"
                                                                  href={!! URL::to('users/' . $user->id . '/edit') !!}><i
                                        class="fa fa-pencil fa-2x"></i></a></td>
                        <td class="delete-row-action"><a class="icon-link" href="#"><i
                                        class="fa fa-times fa-2x"></i></a></td>
                    </tr>
                    <tr rowspan="2" class="row-confirm">
                        <td colspan="2">
                            <h4 class="text-danger">Are you sure you want to remove</h4>

                            <h3>{{$user->name or NULL}}</h3>
                        </td>
                        <td>
                            {!! Form::open(['route'=>['users.destroy', $user->id],'method'=>'DELETE']) !!}

                            {!! Form::submit('Remove', ['class' => 'btn btn-lg btn-danger btn-block']) !!}
                            {!! Form::close() !!}
                        </td>
                        <td colspan="4"><a href="#" class="btn btn-cancel btn-lg btn-block">Cancel</a></td>
                    </tr>

                @endforeach

                </tbody>
            </table>
        </div>
    </div>
    {!! $users->render() !!}
@stop
