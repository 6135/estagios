@extends('base.default')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/calendar.css') }}">
@stop

@section('content')

    <div class="main-page row ">
        <div class="col-md-6 px-0" style="margin-bottom: 5rem">
            <p class="home_page">
                {{ __('static.home.welcome') }}
            </p>
        </div>
        <div class="col-sm-3"></div>
        <div class="col-sm px-0 " style="margin-bottom: 5rem">
            @include('layouts.home.contacts')
        </div>
    </div>

@stop
