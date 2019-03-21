<div class="wmo-slide-welcome">
    <div class="welcome_content">
        <div class="welcome_first">
            <div class="img-container logo" style="background-image: url('{{ asset('images/wm-logo.jpg') }}')"></div>
        </div>
        @if(isset($slide->images[0]))
            <div class="welcome_second">
                <div class="img-container"
                     style="background-image: url('{{ asset('img/images/'.$slide->images[0]->image) }}')"></div>
            </div>
        @endif
    </div>
</div>