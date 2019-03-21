<div class="main-content">
    <div class="template-content icons-view-content">
        <h1>{{ $slide->name }}</h1>
        <div class="icons-content">
            @foreach ($slide->icons as $icon)
                <div>
                    <div class="icon-contain">
                        <img src="{{ asset('img/icons/'.$icon->image) }}" />
                    </div>
                    <h2>{{ $icon->name }}</h2>
                    <p>{!! $icon->desc !!}</p>
                </div>
            @endforeach
        </div>
    </div>
</div>

