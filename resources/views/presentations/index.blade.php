@extends('admin')

@section('content')
    @if($request->is('presentations') || $request->is('presentations/archived'))
        <div class="row">
             <div class="hidden-xs col-lg-offset-9 col-lg-3 col-md-offset-9 col-md-3  col-sm-offset-8 col-sm-4 col-xs-12">
                <a href="/presentations/create" class="btn btn-lg btn-primary btn-block">Create new presentation</a>
            </div>
        </div>

        <hr/>
    @endif

    <div class="row">
        <div class="col-md-12">
            <table class="table table-hover table-data-index sortable">
                <thead>
                <tr>
                    <th class="row-data-index-name">
                        {!! sort_by('client','Client',$request) !!}
                    </th>
                    <th class="row-data-index-name">
                        {!! sort_by('title','title',$request) !!}
                    </th>
                    <th class="row-data-index-name">
                        {!! sort_by('created_at','Created',$request) !!}
                    </th>
                    <th class="row-data-index-name">
                        {!! sort_by('updated_at','Updated',$request) !!}
                    </th>
                    <th></th>
                    <th></th>
                    <th></th>

                </tr>
                </thead>
                <tbody>
                @foreach($presentations as $presentation)

                    <tr class="odd gradeX {!! checkActive($currentUser,$presentation, $request) !!}"
                        data-presentation="{!! $presentation->id !!}">
                        <td><strong>{!! $presentation->client !!}</strong></td>
                        <td><strong>{{$presentation->title}}</strong></td>
                        <td><strong>{!! $presentation->present()->created !!}</strong></td>
                        <td><strong>{!! $presentation->present()->updated !!}</strong></td>
                        @if(!$request->is('presentations/select'))
                            @if($request->is('presentations'))
                                <td class="edit-row-action text-right">
                                    <a class="icon-link"  title="Edit"
                                       href={!! URL::to('presentations/' . $presentation->id . '/edit') !!}>
                                        <i class="fa fa-pencil fa-2x"></i></a>
                                </td>
                            @endif
                            <td class="view-row-action text-right">
                                <a class="icon-link" href="/presentations/{{$presentation->id}}/preview" title="Preview">
                                    <i class="fa @if($presentation->hidden)fa-eye-slash @else fa-eye @endif fa-2x"></i></a>
                            </td>

                            @if($request->is('presentations'))
                                <td class="lock-row-action">
                                    <a class="icon-link" href="#" title="Archive">
                                        <i class="fa fa-unlock-alt fa-2x"></i>
                                    </a>
                                </td>
                                <td class="pdf-row-action">
                                    <a class="icon-link" href="#" title="Save to PDF">
                                        <i class="fa fa-file-pdf-o fa-2x"></i>
                                    </a>
                                </td>
                                {!! Form::open(['url' => 'presentations/'. $presentation->id.'/duplicate', 'method' => 'post','id'=>'duplicate'.$presentation->id]) !!}
                                <td class="duplicate-row-action">
                                    <a class="icon-link" href="#" data-presentation ="{!! $presentation->id !!}" title="Duplicate">
                                        <i class="fa fa-share-square-o fa-2x"></i>
                                    </a>
                                </td>
                                {!! Form::close() !!}
                            @else
                                <td class="lock-row-action">
                                    <a class="icon-link" href="#" title="Activate">
                                        <i class="fa fa-unlock fa-2x"></i>
                                    </a>
                                </td>
                                <td class="delete-row-action">
                                    <a class="icon-link" href="#" title="Delete">
                                        <i class="fa fa-times fa-2x"></i>
                                    </a>
                                </td>
                            @endif
                        @else
                            <td class="check-row-action">
                                <a class="icon-link" href="#">
                                    <i class="fa fa-check fa-2x"></i>
                                </a>
                            </td>
                        @endif
                    </tr>
                    <tr rowspan="2" class="row-confirm">
                        <td colspan="2">
                            <h4 class="text-danger">Are you sure you want to remove</h4>

                            <h3>{{$presentation->title or NULL}}</h3>
                        </td>
                        <td>
                            {!! Form::open(['route'=>['presentations.destroy', $presentation->id],'method'=>'DELETE']) !!}

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
    {!! $presentations->render() !!}
@stop
@section('admin_scripts')
    <script type="application/javascript" src="{{ asset('js/presentation.js') }}"></script>
@stop