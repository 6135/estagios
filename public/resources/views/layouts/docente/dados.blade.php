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
                    <h5 class="card-title header-text-1">{{ trans_choice('professor.personal.data', 2) }} &nbsp; <a
                            href="#" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDadosDocente"
                            aria-controls="offcanvas"><i class="bi bi-pencil-square"></i></a></h5>
                    <br>
                    <p class="mb-0 sub-header-text-4">{{ __('professor.full.name') }}</p>
                    <p class="body-text-1" name="field_nome">
                        {{ session()->get('user')->nome }}
                    </p>
                    <p class="mb-0 sub-header-text-4">{{ __('professor.short.name') }}</p>
                    <p class="body-text-1" name="field_nome_curto">
                        {{ session()->get('user')->getShortName() }}
                    </p>
                    <p class="mb-0 sub-header-text-4">{{ __('professor.email') }}</p>
                    <p class="body-text-1" name="field_email">
                        {{ session()->get('user')->email . '@dei.uc.pt' }}
                    </p>
                    <p class="mb-0 sub-header-text-4">{{ trans_choice('professor.specialty', 1) }}</p>
                    <p class="body-text-1" name="field_especializacao_nome">
                        {{ session()->get('user')->docente()->especializacao_nome }}
                    </p>
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

@section('offcanvas')
    @include('layouts.docente.offcanvas-dados')
@stop

@section('scripts')

    <script>
        const locale = '{{ app()->getLocale() }}';
        const localizedMessages = {
            nome: {
                required: "{{ __('validation.required', ['attribute' => __('professor.full.name')]) }}",
                max: "{{ __('validation.max.string', ['attribute' => __('professor.full.name'), 'max' => 255]) }}",
                min: "{{ __('validation.min.string', ['attribute' => __('professor.full.name'), 'min' => 3]) }}",
                between: "{{ __('validation.between.string', ['attribute' => __('professor.full.name'), 'min' => 3, 'max' => 255]) }}",
            },
            nome_curto: {
                required: "{{ __('validation.required', ['attribute' => __('professor.short.name')]) }}",
                between: "{{ __('validation.between.string', ['attribute' => __('professor.short.name'), 'min' => 3, 'max' => 255]) }}",
            },
            especializacao_nome: {
                required: "{{ __('validation.required', ['attribute' => trans_choice('professor.specialty',1)]) }}",
                notexists: "{{ __('validation.exists', ['attribute' => trans_choice('professor.specialty',1)]) }}" 
            },
        };

        const areasEspecialidade = {!! json_encode(\App\Models\Especializacao::getActiveEspecializacoesNames()) !!};
    </script>
    <script src="{{ asset('js/pages/docente/dadosDocente.js') }}" crossorigin="anonymous"></script>

    <script>
        toastr.options.closeButton = true;
        toastr.options.closeMethod = 'fadeOut';
        toastr.options.closeDuration = 1000;
        toastr.options.closeEasing = 'swing';
        toastr.options.newestOnTop = false;
        toastr.options.preventDuplicates = true;
        toastr.options.progressBar = true;
        toastr.options.showDuration = 10;
        toastr.options.hideDuration = 10;
    </script>


@stop
