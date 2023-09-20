@extends('base.default')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/calendar.css') }}">
@stop

@section('content')

    <div class="main-page row ">
        <div class="col-md-5 px-0" style="margin-bottom: 5rem">
            {{-- <span class="home_page"> --}}
            <div class="card border-0">
                <div class="card-body">
                    <h5 class="card-title header-text-1">{{ __('student.curricular.data') }} &nbsp; <a
                            href={{ route('aluno.dados.editar.get') }}><i class="bi bi-pencil-square"></i></a></h5>
                    <br>
                    <p class="mb-0 sub-header-text-4" >{{__('student.full.name')}}</p>
                    <p class="body-text-1">
                        {{ session()->get('user')->nome }}
                    </p>
                    <p class="mb-0 sub-header-text-4" >{{__('student.number')}}</p>
                    <p class="body-text-1">
                        {{ optional(session()->get('user')->aluno()->first())->aluno_numaluno }}
                    </p>
                    <p class="mb-0 sub-header-text-4" >{{__('student.short.name')}}</p>
                    <p class="body-text-1">
                        {{ session()->get('user')->getShortName() }}
                    </p>
                    <p class="mb-0 sub-header-text-4" >{{__('student.email')}}</p>
                    <p class="body-text-1">
                        {{ session()->get('user')->email."@student.dei.uc.pt" }}
                    </p>

                    <a href="#" class="card-link">Card link</a>
                    <a href="#" class="card-link">Another link</a>
                </div>
            </div>
            {{-- </span> --}}
        </div>
        {{-- <div class="col-sm-3"></div> --}}
        <div class="col-sm px-0 " style="margin-bottom: 5rem">
            {{-- @include('layouts.home.contacts') --}}
        </div>
    </div>

@stop
