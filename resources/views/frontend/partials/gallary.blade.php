<div class="main-content">
    <div class="template-content ts-view-content ">
        <h1>Gallary page</h1>
        <div class="tombstones-contain">
            @foreach ($slide->gallarys as $gallary)
                <div>
                    <div class="img-contain">
                        <img src="{{ asset('img/gallarys/'.$gallary->image) }}" />
                    </div>
                    <p>{!! $gallary->label !!}</p>
                </div>
            @endforeach
        </div>
    </div>
</div>
