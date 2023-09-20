@extends('base.default')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/calendar.css') }}">
@stop

@section('content')

    <div class="main-page row ">
        <div class="col-md-4 px-0" style="margin-bottom: 5rem">
            {{-- <span class="home_page"> --}}
            <div class="card border-0">
                <div class="card-body">
                    <h5 class="card-title header-text-1">{{ __('student.curricular.data') }}</h5>
                    <br>
                    <form id="studentDataForm" method="POST" action="{{ route('aluno.dados.editar.post') }}" class="needs-validation">
                        <!-- Nome Completo -->
                        <label for="nome"
                            class="sub-header-text-5 mb-1 text-primary ">{{ __('student.full.name') }}</label>
                        <input type="text" class="form-control--dei full-border mb-3 " id="nome" name="nome"
                            placeholder=" " value="{{ old('nome', session()->get('user')->nome) }}" required>
                        <!-- Nome Curto -->
                        <label for="nome_curto"
                            class="sub-header-text-5 mb-1 text-primary">{{ __('student.short.name') }}</label>
                        <input type="text" class="form-control--dei full-border mb-3" id="nome_curto"
                            name="nome_curto" placeholder=" "
                            value="{{ old('nome_curto',session()->get('user')->getShortName()) }}" required>
                        <div class="row">
                            <div class="col-md">
                                <!-- Número -->
                                <label for="aluno_numaluno"
                                    class="sub-header-text-5 mb-1 text-primary">{{ __('student.number') }}</label>
                                <input type="number" min="0" class="form-control--dei full-border mb-3" id="aluno_numaluno"
                                    name="aluno_numaluno" placeholder=" " value="{{ old('aluno_numaluno', optional(session()->get('user')->aluno()->first())->aluno_numaluno) }}" required>
                            </div>
                            <div class="col-md">
                                <!-- Email -->
                                <label for="email" class="sub-header-text-5 mb-1 text-primary">{{ __('student.email') }}</label>
                                <input type="email" class="form-control--dei full-border mb-3" id="email" name="email"
                                    placeholder=" " value="{{ old('email', session()->get('user')->email . '@student.dei.uc.pt') }}"
                                    required disabled>
                            </div>
                        </div>
                        <!-- Country -->
                        <div class="row">
                            <div class="col-md">
                                <label for="pais_codigo_iso"
                                    class="sub-header-text-5 mb-1 text-primary">{{ __('student.country') }}</label>
                                <select class="form-select  form-control--dei full-border mb-3" aria-label="Default select example"
                                    id="pais_codigo_iso" name="pais_codigo_iso" required>
                                    <!-- Empty option -->
                                    <option class="body-text-2" value="" @if (old('pais_codigo_iso', optional(session()->get('user')->aluno()->first())->pais_codigo_iso) == "") selected @endif disabled hidden>{{ __('student.select.country') }}</option>
                                    @foreach (App\Models\Pais::getCountries() as $country)
                                        <option class="body-text-2" value="{{ $country['codigo_iso'] }}"
                                            data-phone-code="{{ $country['codigo_tel'] }}"
                                            {{old('pais_codigo_iso', optional(session()->get('user')->aluno()->first())->pais_codigo_iso) == $country['codigo_iso'] ? "selected" : "" }}>
                                            {{ $country['nome'] }}</option>
                                    @endforeach

                                </select>
                            </div>
                            <div class="col-md">
                                <!-- Phone -->
                                <label for="aluno_telefone"
                                    class="sub-header-text-5 mb-1 text-primary">{{ __('student.phone') }}</label>
                                <input type="tel" class="form-control--dei full-border mb-3" id="aluno_telefone"
                                    name="aluno_telefone" placeholder=" " value="{{ old('aluno_telefone', optional(session()->get('user')->aluno()->first())->aluno_telefone) }}" required>
                            </div>
                        </div>
                        <!-- identificacao -->
                        <label for="documento_tipo"
                            class="sub-header-text-5 mb-1 text-primary">{{ __('student.id') }}</label>
                        <select class="form-select  form-control--dei full-border mb-3" aria-label="Default select example"
                            id="documento_tipo" name="documento_tipo" required>
                            <!-- Empty option -->
                            <option class="body-text-2" value="" {{old('documento_tipo', optional(session()->get('user')->aluno()->first())->documento_tipo) == "" ? "selected" : "" }} disabled hidden>{{ __('student.select.id') }}</option>
                            @foreach (App\Models\Documento::all() as $doc)
                                <option class="body-text-2" value="{{ $doc->tipo }}"
                                    {{old('documento_tipo', optional(session()->get('user')->aluno()->first())->documento_tipo) == $doc->tipo ? "selected" : "" }}
                                    >{{ $doc->tipo }}</option>
                            @endforeach

                        </select>

                        <div class="row">
                            <div class="col-md">
                                <!-- ID number -->
                                <label for="documento_id"
                                    class="sub-header-text-5 mb-1 text-primary">{{ __('student.id') }}</label>
                                <input type="text" class="form-control--dei full-border mb-3" aria-label="Document ID"
                                    id="documento_id" name="documento_id" required
                                    value="{{ old('documento_id', optional(session()->get('user')->aluno()->first())->documento_id) }}"
                                    >
                            </div>
                            <div class="col-md">
                                <!-- ID Validity -->
                                <label for="validade"
                                    class="sub-header-text-5 mb-1 text-primary">{{ __('student.id_validity') }}</label>
                                <input type="date" class="form-control--dei full-border mb-3" id="validade"
                                    name="validade" placeholder="" required
                                    value="{{ old('validade', \Illuminate\Support\Carbon::parse(optional(session()->get('user')->aluno()->first())->validade))->toDateString() }}"
                                    >
                            </div>
                        </div>
                        <!-- Morada -->
                        <label for="aluno_morada"
                            class="sub-header-text-5 mb-1 text-primary">{{ __('student.address') }}</label>
                        <textarea class="form-control--dei full-border mb-3" id="aluno_morada" name="aluno_morada" required maxlength="1024" style="resize: none;">{{ old('aluno_morada', optional(session()->get('user')->aluno()->first())->aluno_morada) }}</textarea>
                        <!-- Curso -->
                        <label for="curso_id"
                            class="sub-header-text-5 mb-1 text-primary">{{ __('student.degree') }}</label>
                        <select class="form-select  form-control--dei full-border mb-3" aria-label="Default select example"
                            id="curso_id" name="curso_id" required>
                            <!-- Empty option -->
                            <option class="body-text-2" value="" 
                            {{old('curso_id', optional(session()->get('user')->aluno()->first())->curso_id) == "" ? "selected" : "" }} 
                            disabled hidden>{{ __('student.select.degree') }}</option>
                            @php
                                $cursos = App\Models\Curso::where(App\Models\Curso::ATIVO, true)->get();
                            @endphp
                            @foreach ($cursos as $curso)
                                <option class="body-text-2"
                                value="{{$curso->id}}" {{old('curso_id', optional(session()->get('user')->aluno()->first())->curso_id) == $curso->id ? "selected" : "" }}
                                >{{ $curso->nome }}</option>
                            @endforeach

                        </select>

                        <div class="row mb-3">
                            <div class="col-xl-6">
                                <label  for="aluno_medialicenciatura"
                                    class="sub-header-text-5 mb-1 text-primary">{{ __('student.average.batchelor') }}</label>
                                <input type="number" step="1" min="0" max="20" class="form-control--dei full-border mb-3" id="aluno_medialicenciatura" name="aluno_medialicenciatura"
                                    value="{{ old('aluno_medialicenciatura', optional(session()->get('user')->aluno()->first())->aluno_medialicenciatura) }}"
                                >
                            </div>
                            <div class="col-xl-6">
                                <label for="aluno_mediamestrado"
                                    class="sub-header-text-5 mb-1 text-primary">{{ __('student.average.master') }}</label>
                                <input type="number" step="0.001" min="0" max="20" class="form-control--dei full-border mb-3" id="aluno_mediamestrado" name="aluno_mediamestrado"
                                    value="{{ old('aluno_mediamestrado', optional(session()->get('user')->aluno()->first())->aluno_mediamestrado) }}"
                                >
                            </div>
                        </div>
                    
                        <!-- Cadeiras em Falta -->
                        <label for="curso_id"
                            class="sub-header-text-5 mb-1 text-primary">{{ __('student.missing.subjects') }}</label>
                        <div class="row mb-3">
                            <div class="col-xl-6"><input class="form-control--dei full-border mb-3" id="cadeirasEmFalta1" name="cadeirasEmFalta1"></div>
                            <div class="col-xl-6"><input class="form-control--dei full-border mb-3" id="cadeirasEmFalta2" name="cadeirasEmFalta2"></div>
                            <div class="col-xl-6"><input class="form-control--dei full-border mb-3" id="cadeirasEmFalta3" name="cadeirasEmFalta3"></div>
                            <div class="col-xl-6"><input class="form-control--dei full-border mb-3" id="cadeirasEmFalta4" name="cadeirasEmFalta4"></div>
                            <div class="col-xl-6"><input class="form-control--dei full-border mb-3" id="cadeirasEmFalta5" name="cadeirasEmFalta5"></div>
                            <div class="col-xl-6"><input class="form-control--dei full-border mb-3" id="cadeirasEmFalta6" name="cadeirasEmFalta6"></div>
                        </div>
                        <div class="row gx-2">
                            <div class="d-grid col-md-5">
                                <button class="btn btn-outline-primary form-btn-dei mb-3" type="submit" id="submitButton">
                                    <span class="spaced-uppertext-dei-bigger">{{ __('words.save')}}</span><span class="spinner-border spinner-border-sm d-none" id="loginSpinner" role="status" aria-hidden="true" style="margin-left: 5px"></span>

                                  </button>
                                  
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            {{-- </span> --}}
        </div>
        {{-- <div class="col-sm-3"></div> --}}
        <div class="col-sm px-0 " style="margin-bottom: 5rem">
            {{-- @include('layouts.home.contacts') --}}
        </div>
    </div>

    @section('scripts')
        <script src="{{ asset('js/pages/dadosAluno.js') }}" crossorigin="anonymous"></script>

        <script>
            toastr.options.closeButton = true;
            toastr.options.closeMethod = 'fadeOut';
            toastr.options.closeDuration = 3000;
            toastr.options.closeEasing = 'swing';
            toastr.options.newestOnTop = false;
            toastr.options.preventDuplicates = true;
            toastr.options.progressBar = true;
            toastr.options.showDuration = 10;
            toastr.options.hideDuration = 10;
        </script>
    @stop
@stop
