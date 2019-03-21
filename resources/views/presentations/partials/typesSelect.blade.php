<label class="morris-presentation-select-label">
    <select name="slideType" class="form-control morris-presentation-select">

        @foreach($typesSelect as $name=>$value)
            @if($section->name == intro_page_name())
                <option value="{!! $name !!}">{!! $value !!}</option>
            @else
                @if($name !=='intro' && $name !=='welcome')
                    <option value="{!! $name !!}">{!! $value !!}</option>
                @endif
            @endif
        @endforeach
    </select>
    <i></i>
</label>


