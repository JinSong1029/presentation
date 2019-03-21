@if($slide)
    <section class="splash-section">
        <article class="splash-slide @if($slide->color) colored_green @endif" >
            @include('frontend.partials.'.$slide->type, ['slide'=>$slide])
        </article>
    </section>
@endif
