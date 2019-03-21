

@if(isset($slide->images[0]))
    @if ($presentation->present()->backgroundFor($slide->images[0]))
        <style>body.template #layer_{{$slide->id}} { background-color: {{ $presentation->present()->backgroundFor($slide->images[0]) }}!important; }</style>
    @endif
    <div class="main-content" >
        <div  class="template-content screen-full-image" style="z-index:1;background-image: url({{asset('img/images/'. $slide->images[0]->image)}})">
            <div class="image-layer" id="layer_{{$slide->id}}"></div>
        </div>
    </div>
@endif