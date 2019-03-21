<div class="main-content">
    <div class="template-content ts-view-content ">
        <h1>Tombstone page</h1>
        <div class="tombstones-contain">
            @foreach ($slide->tombstones as $tombstone)
                <div>
                    <div class="img-contain">
                        <img src="{{ asset('img/tombstones/'.$tombstone->image) }}" />
                    </div>
                    <p>{!! $tombstone->label !!}</p>
                </div>
            @endforeach
        </div>
    </div>
</div>
