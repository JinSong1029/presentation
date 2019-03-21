<div class="col-xs-3">
    <div class="morris-presentation-slide-tombstone" data-id="{{ $item->id }}"
         style="background-image: url('{{ asset('img/images/'.$item->image) }}')">
        <img src="{{ asset('images/16_9_transparent.png') }}" alt=""/>
        <div class="icons">
            <a class="edit {{ $item->id == $subslide ? "active" : "" }}" href="{!! URL::to('presentations/'. $presentation->id .'/slides/'. $slide->id .'/edit?subslide='. $item->id) !!}"><i class="fa fa-pencil"></i></a>
            <a class="remove" href="#"><i class="fa fa-times"></i></a>
        </div>
    </div>
    <div class="morris-presentation-slide-remove">
        {!! Form::open(['url' =>'/slides/'.$slide->id.'/deleteItem', 'class'=>'morris-ajax-form']) !!}
        {!! Form::hidden('itemType','picture') !!}
        {!! Form::hidden('itemId',$item->id) !!}
        {!! Form::submit('Delete image', ['class'=>'btn btn-danger btn-block']) !!}
        <a href="#" class="btn btn-default btn-block cancel">Cancel</a>
        {!! Form::close() !!}
    </div>
</div>