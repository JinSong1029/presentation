@extends('admin')
@section('content')

    @if($request->segment(3) == 'editKey')
        @include('presentations.edit_key')
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
                        {!! sort_by('key','Key',$request) !!}
                    </th>
                    <th class="row-data-index-name">
                        {!! sort_by('updated_at','Created',$request) !!}
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
                        <td><strong id="presentation_key">{!! $presentation->key !!}</strong></td>
                        <td><strong>{!! $presentation->present()->updated !!}</strong></td>
                        <td class="edit-row-action text-right">
                            <a class="icon-link"
                               href={!! URL::to('presentations/' . $presentation->id . '/editKey') !!}>
                                <i class="fa fa-pencil fa-2x"></i></a>
                        </td>
                        {!! Form::open(['url' => 'presentations/'. $presentation->id.'/editKey', 'method' => 'post','id'=>'random_refresh'.$presentation->id]) !!}
                        {!! Form::hidden('random','random') !!}
                        <td class="refresh-row-action">
                            <a class="icon-link" href="#" data-presentation ="{!! $presentation->id !!}">
                                <i class="fa fa-refresh fa-2x"></i>
                            </a>
                        </td>
                        {!! Form::close() !!}
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