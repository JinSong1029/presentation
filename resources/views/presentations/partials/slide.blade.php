<div class="morris-presentation-slide" data-position="{{ $index }}" data-id="{{ $slide->id }}"
     data-section="{{$slide->section->ordering}}">
    <small>{{ $slide->type }}</small>
    <br/>
    {{ $slide->name }}

    <div class="morris-presentation-slide-icons">
        @if($slide->type != 'placeholder')
            <a class="edit"
               href="{!! URL::to('presentations/'. $presentation->id .'/slides/' . $slide->id . '/edit') !!}"><i
                        class="fa fa-pencil"></i></a>
        @endif
        <a class="move" href="#"><i class="fa fa-arrows"></i></a>
        <a data-slideId="{{$slide->id}}" class="morris-presentation-slide-moveToSection"><i class="fa fa-folder"></i></a>
        <a class="remove" href="/slides/{{$slide->id}}/delete"><i class="fa fa-times"></i></a>

    </div>
</div>