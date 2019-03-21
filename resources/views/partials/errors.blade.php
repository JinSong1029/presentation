@if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{$error}}</li>
            @endforeach
        </ul>
    </div>
@endif

@if(\Session::has('wrong_role'))
    <div class="alert alert-danger">
        {{ \Session::pull('wrong_role') }}
    </div>
@endif