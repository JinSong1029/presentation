<div class="col-xs-3">
    <div class="morris-presentation-slide-quote" data-id="{{ $item->id }}">
        <img src="{{ asset('images/16_9_transparent.png') }}" alt=""/>
        <div class="overlay">
            <div class="pull-right">{{ $item->pivot->position }}</div>
            <b>{!! $item->title !!}</b><br>
            {!! nl2br($item->content) !!}
        </div>
        <div class="icons">
            <a class="edit {{ $item->id == $subslide ? "active" : "" }}" href="{!! URL::to('presentations/'. $presentation->id .'/slides/'. $slide->id .'/edit?subslide='. $item->id) !!}"><i class="fa fa-pencil"></i></a>
            <a class="remove" href="#"><i class="fa fa-times"></i></a>
        </div>
    </div>
</div>