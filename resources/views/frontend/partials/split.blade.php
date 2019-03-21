
<div class="main-content">
    <div class="template-content content-view-content">
        <div class="main-view-content">
            @if(!$slide->splitsForfrontend->isEmpty())
                @foreach($slide->splitsForfrontend as $split)
                    @if($split->image !== NULL)
                        <div class="img-part overlay-blue" style="background-image: url({{ asset('img/splits/'.$split->image) }})"></div>
                    @else
                        <div class="plain-part">
                            {!! $split->text !!}
                        </div>
                    @endif
                @endforeach
            @endif
        </div>
    </div>
</div>