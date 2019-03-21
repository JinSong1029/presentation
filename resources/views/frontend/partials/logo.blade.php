
<div class="main-content">
    <div class="template-content logos-view-content">
        <h1 class="title-rule">{{ $slide->name }}</h1>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean nec tincidunt leo. Aliquam laoreet posuere diam, ac suscipit est pharetra.</p>
        <div class="logos-content">
            @foreach ($slide->images->sortBy('pivot.position') as $logo)
                <div class="no-info">
                    <img src="{{ asset('img/images/'.$logo->image) }}" />
                    <div class="logos-text hide">
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                        <a href="#">Find out more</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

