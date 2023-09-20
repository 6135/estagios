@extends('metronicv815.base.default')

@section('content')
{{-- @include('metronicv815.layout.partials.messageCard') --}}

    @include('metronicv815.layout.estagios.estagiosTable')
@stop

@section('scripts')
    <script>
        var tableActionURL = "{{$tableActionURL}}";
        var compareAction = "{{$compareAction}}";
        var tableEditAction = "{{route('editarProposta')}}";
        var profile = "{{session()->get('profile')}}";
        var tableCandidatosAction = "{{route('estagiosCandidates')}}";
        var actionName = "{{$actionName}}";

    </script>
    <script src="{{asset('js/data-ajax-estagios2.js')}}" type="text/javascript"></script>
@stop

@section('styles')
@stop