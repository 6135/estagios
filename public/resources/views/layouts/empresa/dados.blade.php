@extends('base.default')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/calendar.css') }}">
@stop

@section('content')

    <div class="main-page row ">
        <div class="col-md-5 px-0">
            {{-- <span class="home_page"> --}}
            <div class="card border-0 py-0 my-0">
                <div class="card-body py-0 my-0">
                    <h5 class="card-title header-text-1 mb-4">{{ __('company.data.data_full') }} &nbsp; <a href="#"
                            data-bs-toggle="offcanvas" data-bs-target="#offcanvasDadosEmpresa" aria-controls="offcanvas"><i
                                class="bi bi-pencil-square"></i></a></h5>
                    <p class="mb-0 sub-header-text-4">{{ __('company.data.name') }}</p>
                    <p class="body-text-1 mb-4" name="field_nomeempresa">
                        {{ $empresa->nomeempresa }} / {{ $empresa->acronimo }}
                    </p>
                    <p class="mb-0 sub-header-text-4">{{ __('company.data.address') }}</p>
                    <p class="body-text-1 mb-4" name="field_morada">
                        {{ $empresa->morada }}
                    </p>
                    <p class="mb-0 sub-header-text-4">{{ __('company.data.activity') }}</p>
                    <p class="body-text-1 mb-4" name="field_atividade">
                        {{ $empresa->atividade }}
                    </p>
                    <p class="mb-0 sub-header-text-4">{{ __('company.data.country') }}</p>
                    <p class="body-text-1 mb-4" name="field_pais_codigo_iso">
                        {{ $empresa->pais->nome }}
                    </p>
                    <p class="mb-0 sub-header-text-4">{{ __('company.data.phone') }}</p>
                    <p class="body-text-1 mb-4" name="field_telefone">
                        {{ $empresa->telefone }}
                    </p>
                    <p class="mb-0 sub-header-text-4">{{ __('company.data.website') }}</p>
                    <p class="body-text-2 mb-4" name="field_url" style="text-transform: uppercase">
                        <a href="//{{ $empresa->url }}" target="_blank" rel="noreferrer noopener"
                            class="text-black"><u>{{ $empresa->url }}</u></a>
                    </p>
                    <p class="mb-0 sub-header-text-4">{{ __('company.data.nif') }}</p>
                    <p class="body-text-1 mb-4" name="field_nif">
                        {{ $empresa->nif }}
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
    @include('layouts.empresa.offcanvas-dados')
@stop

@section('scripts')

    <script>
        const locale = "{{ app()->getLocale() }}";
        const localizedMessages = {
            empresa: {
                nomeempresa: {
                    required: "{{ __('validation.required', ['attribute' => __('company.data.name')]) }}",
                    between: "{{ __('validation.between.string', ['attribute' => __('company.data.name'), 'max' => 512, 'min' => 3]) }}",
                },
                acronimo: {
                    between: "{{ __('validation.between.string', ['attribute' => __('company.data.acronym'), 'max' => 16, 'min' => 1]) }}",
                },
                morada: {
                    required: "{{ __('validation.required', ['attribute' => __('company.data.address')]) }}",
                    between: "{{ __('validation.between.string', ['attribute' => __('company.data.address'), 'max' => 512, 'min' => 8]) }}",
                },
                pais_codigo_iso: {
                    required: "{{ __('validation.required', ['attribute' => __('company.data.country')]) }}",
                    notexists: "{{ __('validation.exists', ['attribute' => __('company.data.country')]) }}"

                },
                telefone: {
                    required: "{{ __('validation.required', ['attribute' => __('company.data.phone')]) }}",
                },
                nif: {
                    required: "{{ __('validation.required', ['attribute' => __('company.data.nif')]) }}",
                    unique: "{{ __('validation.unique', ['attribute' => __('company.data.nif')]) }}",
                },
                atividade: {
                    required: "{{ __('validation.required', ['attribute' => __('company.data.activity')]) }}",
                    between: "{{ __('validation.between.string', ['attribute' => __('company.data.activity'), 'max' => 1024, 'min' => 8]) }}",
                },
                url: {
                    url: "{{ __('validation.url', ['attribute' => __('company.data.website')]) }}",
                },

            }
        }

        const paises = @json(App\Models\Pais::getCountries());
    </script>
    <script src="{{ asset('js/pages/empresa/dadosEmpresa.js') }}" crossorigin="anonymous"></script>

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
