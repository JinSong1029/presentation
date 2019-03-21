@if($quote->double == 1)

    @if($quote->image !== NULL)
        <div class="wmo-quotes-image-double">
            <div class="wmo-quotes-image__image js__preload"
                 style="background-image: url('{{ asset('img/quotes/'.$quote->image) }}')">
            </div>
        </div>
    @else
        <div class="wmo-quotes-double" style="padding-left: 100px;padding-right: 100px">
            <div class="quote-content">{!! $quote->quote !!}</div>

            <div class="wmo-quotes-author">{{ $quote->author }}</div>
            <div class="wmo-quotes-role">{{ $quote->role }}</div>
        </div>
    @endif

@else

    @if($quote->image !== NULL)
        <div class="wmo-quotes-image">
            <div class="wmo-quotes-image__image js__preload"
                 style="background-image: url('{{ asset('img/quotes/'.$quote->image) }}')">
            </div>
        </div>
    @else
        <div class="wmo-quotes-normal">
            <div class="quote-content">{!! $quote->quote !!}</div>

            <div class="wmo-quotes-author">{{ $quote->author }}</div>
            <div class="wmo-quotes-role">{{ $quote->role }}</div>
        </div>
    @endif

@endif