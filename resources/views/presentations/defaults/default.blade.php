@extends('admin')
@section('content')
    @if (isset($title) && $title == 'Create new default')
        @include('presentations.defaults.create_edit')
    @elseif (isset($section))
        @include('presentations.defaults.create_edit')
    @else
        <div class="row manage-model">
            <div class="col-lg-6 col-md-6 col-sm-7">
            </div>
            <div class="clearfix vertical-margin visible-xs-block"></div>
            <div class="col-lg-3 col-lg-offset-3 col-md-3 col-md-offset-3 col-sm-3 col-sm-offset-2">
                <a href="{{ url('/defaults/create') }}" class="btn btn-lg btn-primary btn-block">Create new default</a>
            </div>
        </div>
    @endif
    <div class="row">
        <div class="col-md-12">
            <table class="table table-hover table-data-index sortable">
                <tbody>
                @foreach($sections as $section)

                    <tr class="odd gradeX" data-row-index = {{$section->id}} >
                        <td class="table-name">{!! $section->name !!}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        @if($section->name != intro_page_name())
                        <td class="move-row-action text-right">
                            <a id="downlink{!! $section->id !!}" @if($section->ordering !=count($sections))href="/defaults/{!! $section->id !!}/increase" @endif class="icon-link">
                                <i class="fa fa-angle-down fa-3x @if($section->ordering==count($sections))half-transparent @endif"></i>
                            </a>
                            <a id="uplink{!! $section->id !!}" @if($section->ordering !=2)href="/defaults/{!! $section->id !!}/decrease" @endif class="icon-link">
                                <i class="fa fa-angle-up fa-3x @if($section->ordering==2)half-transparent @endif"></i>
                            </a>
                        </td>
                        <td class="edit-row-action text-right"><a class="icon-link" href="/defaults/{!! $section->id !!}/edit"><i class="fa fa-pencil fa-2x"></i></a></td>
                        <td class="delete-row-action"><a class="icon-link" href="#"><i class="fa fa-times fa-2x"></i></a></td>
                            @else
                            <td colspan="3"></td>
                            @endif
                    </tr>
                    <tr rowspan="2" class="row-confirm">
                        <td colspan="2">
                            <h4 class="text-danger">Are you sure you want to remove</h4>
                            <h3>{{$section->name or NULL}}</h3>
                        </td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>
                            {!! Form::open(['route'=>['defaults.destroy', $section->id],'method'=>'DELETE','id'=>'remove_default']) !!}

                            {!! Form::submit('Remove', ['class' => 'btn btn-lg btn-danger btn-block','id'=>'remove_default_btn']) !!}
                            {!! Form::close() !!}
                        </td>

                        <td colspan="4"><a href="#" class="btn btn-cancel btn-lg btn-block">Cancel</a></td>
                    </tr>

                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop