<div class="col-xs-3">
    <div class="morris-presentation-slide-tombstone" data-id="{{ $item->id }}"
         style="background-image: url('{{ asset('img/teams/'.$item->image) }}')">
        <img src="{{ asset('images/16_9_transparent.png') }}" alt=""/>
        <div class="overlay">
            {!! $item->label !!}
        </div>
        <div class="icons">
            <a class="edit {{ $item->id == $subslide ? "active" : "" }}" href="{!! URL::to('presentations/'. $presentation->id .'/slides/'. $slide->id .'/edit?subslide='. $item->id) !!}"><i class="fa fa-pencil"></i></a>
            <a class="remove" href="#"><i class="fa fa-times"></i></a>
        </div>
    </div>
</div>