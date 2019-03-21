<div class="main-content">
    <div class="template-content ts-view-content ">
        <h1>Team page</h1>
        <div class="tombstones-contain">
            @foreach ($slide->teams as $team)
                <div>
                    <div class="img-contain">
                        <img src="{{ asset('img/teams/'.$team->image) }}" />
                    </div>
                    <p>{!! $team->label !!}</p>
                </div>
            @endforeach
        </div>
    </div>
</div>
