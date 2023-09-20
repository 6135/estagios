@extends('base.default')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/calendar.css') }}">
@stop

@section('content')
    <div class="main-page row ">
        <div class="col-md-6 px-0" style="margin-bottom: 5rem">
            <div class="home_page">

                <p class="line-height-geral mb-4 fwd-600">
                    {{ $curso->nome_completo }} ({{ $curso->titulo }})<br>

                <p class="line-height-geral mb-4">{{$curso->descricao}}</p>
            </div>
        </div>
        <div class="col-sm-3"></div>
        <div class="col-sm px-0 " style="margin-bottom: 5rem">
            @include('layouts.calendar.calendar')

        </div>
    </div>
@stop

@section('scripts')


@stop
