{{--{{ dd($slide->quotes) }}--}}
<?php
$cols = 2; $i = 0;

$quotes = $slide->quotes;
$pass = 0;
?>


<div class="wmo-quotes">


    {{-- ROW 1 --}}

    <div class="wmo-quotes-row pos-1">
        <div class="wmo-quotes-wrapper">

            @if(isset($quotes[0]))
                @include('frontend.partials.quotes._block', ['quote'=>$quotes[0]])
                <?php $i++; ?>
            @endif


            @if(isset($quotes[0]) && isset($quotes[1]) && isset($quotes[2]) && $quotes[1]->double == 1)

                @if(isset($quotes[2]) && $quotes[2]->double != 1)
                    @include('frontend.partials.quotes._block', ['quote'=>$quotes[2]])
                    <?php $i++; ?>
                @endif

            @else

                @if(isset($quotes[1]) && $quotes[1]->double != 1)
                    @include('frontend.partials.quotes._block', ['quote'=>$quotes[1]])
                    <?php $i++; ?>
                @endif

            @endif

        </div>
    </div>

    <div class="wmo-quotes-row pos-2">
        <div class="wmo-quotes-wrapper">


            @if(isset($quotes[1]) && $quotes[1]->double == 1)

                @include('frontend.partials.quotes._block', ['quote'=>$quotes[1]])
                <?php $i++; ?>

            @else

                @if(isset($quotes[0]) && $quotes[0]->double == 1 && isset($quotes[1]))
                    @include('frontend.partials.quotes._block', ['quote'=>$quotes[1]])
                    <?php $i++; ?>
                @endif


                @if(isset($quotes[2]))
                    @include('frontend.partials.quotes._block', ['quote'=>$quotes[2]])
                    <?php $i++; ?>
                @endif
                @if(isset($quotes[3]))
                    @include('frontend.partials.quotes._block', ['quote'=>$quotes[3]])
                    <?php $i++; ?>
                @endif

            @endif

        </div>
    </div>

</div>