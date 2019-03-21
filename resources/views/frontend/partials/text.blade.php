<div class="main-content">
    <div class="template-content content-view-content">
        <h1 class="title-rule">{{ $slide->name }}</h1>
        <div class="main-view-content full-width">    
            <div class="plain-part">
                {!! isset($slide->texts[0]) ? $slide->texts[0]->text : "" !!}
            </div>
        </div>
    </div>
</div>
