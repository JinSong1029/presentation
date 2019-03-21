@extends('default')
@section('main')

    <div id="wrapper" class="container-fluid">

        @include('_header')
        @if(Session::has('message'))
            <div class="alert alert-info">
                {{Session::get('message')}}
            </div>
        @endif

        @yield('content')

    </div>
@section('scripts')
    @yield('admin_scripts')
    {{--<script type="application/javascript" src="{{ asset('js/lib/redactor.plugins.js') }}"></script>--}}
    <script type="application/javascript" src="{{ asset('js/lib/redactor.plugins.js') }}"></script>
    <script type="application/javascript" src="{{ asset('js/lib/redactor.min.js') }}"></script>
    {{--<script type="application/javascript" src="{{ asset('js/lib/moment.js') }}"></script>--}}
    {{--<script type="application/javascript" src="{{ asset('js/lib/bootstrap-datepicker.js') }}"></script>--}}
    {{--<script type="application/javascript" src="{{ asset('js/lib/chosen.jquery.min.js') }}"></script>--}}
    {{--<script type="application/javascript" src="{{ asset('js/lib/jquery.maskedinput.min.js') }}"></script>--}}
    {{--<script type="application/javascript" src="{{ asset('js/lib/jquery.ui.widget.js') }}"></script>--}}
    {{--<script type="application/javascript" src="{{ asset('js/lib/jquery.fileupload.js') }}"></script>--}}
    {{--<script type="application/javascript" src="{{ asset('js/lib/bootstrap-datetimepicker.js') }}"></script>--}}
    <script type="application/javascript" src="{{ asset('js/lib/Sortable.min.js') }}"></script>
    {{--<script type="application/javascript" src="{{ asset('js/lib/jquery.guillotine.js') }}"></script>--}}
    {{--<script type="application/javascript" src="{{ asset('js/lib/underscore.js') }}"></script>--}}
    {{--<script type="application/javascript" src="{{ asset('js/lib/backbone.js') }}"></script>--}}
    <script type="application/javascript" src="{{ asset('js/scripts.js') }}"></script>
    {{--<script type="application/javascript" src="{{ asset('js/story.js') }}"></script>--}}
    {{--<script type="application/javascript" src="{{ asset('js/chosenCustom.js') }}"></script>--}}
    {{--<script type="application/javascript" src="{{ asset('js/mediaTypes.js') }}"></script>--}}
    {{--<script type="application/javascript" src="{{ asset('js/mediaLibrary.js') }}"></script>--}}
    {{--<script type="application/javascript" src="{{ asset('js/featured.js') }}"></script>--}}
    {{--<script type="application/javascript" src="{{ asset('js/redactor.js') }}"></script>--}}
    {{--<script type="application/javascript" src="{{ asset('js/highlighted.js') }}"></script>--}}
    {{--<script type="application/javascript" src="{{ asset('js/autosave.js') }}"></script>--}}
    {{--<script type="application/javascript" src="{{ asset('js/tags.js') }}"></script>--}}
    {{--<script type="application/javascript" src="{{ asset('js/ticker.js') }}"></script>--}}
    {{--<script type="application/javascript" src="{{ asset('js/thought.js') }}"></script>--}}
    {{--<script type="application/javascript" src="{{ asset('js/player.js') }}"></script>--}}
    {{--<script type="application/javascript" src="{{ asset('js/preview.js') }}"></script>--}}
    <script src="/js/editor/js/froala_editor.min.js"></script>
    <script src="/js/selection.js"></script>

    <script src="/js/editor/js/plugins/link.min.js"></script>
    <script src="/js/editor/js/plugins/lists.min.js"></script>
    <script src="/js/editor/js/plugins/paragraph_format.min.js"></script>
    <script src="/js/editor/js/plugins/paragraph_style.min.js"></script>
    <script src="/js/editor/js/plugins/code_beautifier.min.js"></script>
    <script src="/js/editor/js/plugins/colors.min.js"></script>
    @stop
@stop
