<div class="offcanvas offcanvas-end " tabindex="-1" id="offcanvasNovaPropostaDocente" aria-labelledby="offcanvasLabel"
    style="width: 70%">
    <div class="offcanvas-header">
        {{-- <h5 class="offcanvas-title" id="offcanvasLabel">Offcanvas</h5> --}}
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="card border-0 " style="width: 100%">
            <div class="card-body">
                <h5 class="card-title header-text-1">{{ __('proposal.proposal_new') }}</h5>
                <br>
                <form id="docentePropostaForm" method="POST" action="{{ route('docente.proposta.post') }}"
                    class="needs-validation">
                    <!-- periodos de estagio -->
                    <div class="mb-4 fv-row">
                        <label for="nome"
                            class="sub-header-text-5 mb-1 text-primary ">{{ trans_choice('proposal.fields.period', 2) }}</label>
                        <select class="form-select--dei form-select-lg  full-border "
                            aria-label="Default select example" id="edicao_estagio_id" name="edicao_estagio_id" required
                            data-target-location="{{ route('areasEspecializacaoCurso') }}">
                            <!-- Empty option -->
                            <option class="body-text-2" value="" selected disabled hidden>
                                {{ trans_choice('proposal.fields.select.period', 2) }}</option>
                            @php
                                //get all specialties from active courses
                                
                                //get all specialties from active courses
                                $periodos = \App\Models\EdicaoEstagio::active()->get();
                                
                            @endphp
                            @foreach ($periodos as $periodo)
                                <option class="body-text-2" value="{{ $periodo->id }}"
                                    data-curso="{{ $periodo->curso_id }}" {{-- {{ old('especializacao_nome',optional(session()->get('user')->docente())->especializacao_nome) == $especialidade->nome? 'selected': '' }} --}}>
                                    {{ $periodo->titulo() }}</option>
                            @endforeach

                        </select>
                    </div>
                    <!-- Area especialidade select-->
                    <label for="especializacao_nome"
                        class="sub-header-text-5 mb-1 text-primary">{{ trans_choice('proposal.fields.specialty_area', 2) }}</label>
                    <div class="row">
                        <div class="col-sm-5 mx-1 px-1">
                            <select class="form-select--dei form-select-lg full-border mb-4"
                                aria-label="Default select example" id="especializacao_nome1"
                                name="especializacao_nome1" required>
                                <!-- Empty option -->

                                <option class="body-text-2" value="" selected disabled hidden>
                                    {{ trans_choice('proposal.fields.select.period_first', 1) }}</option>
                                <option class="body-text-2" value="" disabled disabled hidden>
                                    {{ trans_choice('proposal.fields.select.specialty_area', 1) }}</option>
                                {{-- @foreach (\App\Models\Especializacao::getActiveEspecializacoes() as $especialidade)
                                <option class="body-text-2" value="{{ $especialidade->nome }}"
                                    {{-- {{ old('especializacao_nome1',optional(session()->get('user')->docente())->especializacao_nome) == $especialidade->nome ? 'selected': '' }} 
                                    >
                                    {{ $especialidade->nome }}</option>
                            @endforeach --}}

                            </select>
                        </div>
                        <div class="col-sm-5 mx-1 px-0">
                            <select class="form-select--dei form-select-lg full-border mb-4 "
                                aria-label="Default select example" id="especializacao_nome2"
                                name="especializacao_nome2">
                                <!-- Empty option -->

                                <option class="body-text-2" value="" selected disabled hidden>
                                    {{ trans_choice('proposal.fields.select.period_first', 1) }}</option>
                                <option class="body-text-2" value="" disabled disabled hidden>
                                    {{ trans_choice('proposal.fields.select.specialty_area', 1) }}</option>
                                {{-- @php
                                    //get all specialties from active courses
                                    
                                    //get all specialties from active courses
                                    $especialidades = \App\Models\Especializacao::getActiveEspecializacoes();
                                    
                                @endphp
                                @foreach ($especialidades as $especialidade)
                                    <option class="body-text-2" value="{{ $especialidade->nome }}"
                                        
                                        >
                                        {{ $especialidade->nome }}</option>
                                @endforeach --}}

                            </select>
                        </div>
                    </div>
                    <!-- Titulo -->
                    <div class="mb-4 fv-row">
                        <label for="titulo"
                            class="sub-header-text-5 mb-1 text-primary">{{ __('proposal.fields.title') }}</label>
                        <input type="text" class="form-control--dei form-control-lg full-border" id="titulo"
                            name="titulo" placeholder="" value="{{ old('titulo') }}" required minlength="16"
                            maxlength="256">
                    </div>
                    <!-- Enquandramento -->
                    <div class="mb-4 fv-row">
                        <label for="enquadramento"
                            class="sub-header-text-5 mb-1 text-primary">{{ __('proposal.fields.context') }}</label>
                        <textarea type="text" class="form-control--dei form-control-lg full-border" id="enquadramento"
                            name="enquadramento" placeholder="" value="{{ old('enquadramento') }}" required rows="5"
                            style="resize: none;" maxlength="5000" minlength="256"> </textarea>
                    </div>
                    <!-- Objetivos -->
                    <div class="mb-4 fv-row">
                        <label for="objetivos"
                            class="sub-header-text-5 mb-1 text-primary">{{ __('proposal.fields.objectives') }}</label>
                        <textarea type="text" class="form-control--dei form-control-lg full-border " id="objetivos" name="objetivos"
                            placeholder="" value="{{ old('objetivos') }}" required rows="5" style="resize: none;" maxlength="5000"
                            minlength="256"> </textarea>
                    </div>

                    <!-- Plan Trab 1 sem -->
                    <div class="mb-4 fv-row">
                        <label for="plano1"
                            class="sub-header-text-5 mb-1 text-primary">{{ __('proposal.fields.workplan1') }}</label>
                        <textarea type="text" class="form-control--dei form-control-lg full-border" id="plano1" name="plano1"
                            placeholder="" value="{{ old('plano1') }}" required rows="5" style="resize: none;" maxlength="5000"
                            minlength="256"> </textarea>
                    </div>
                    <!-- Plan trab 2 sem -->
                    <div class="mb-4 fv-row">
                        <label for="plano2"
                            class="sub-header-text-5 mb-1 text-primary">{{ __('proposal.fields.workplan2') }}</label>
                        <textarea type="text" class="form-control--dei form-control-lg full-border" id="plano2" name="plano2"
                            placeholder="" value="{{ old('plano2') }}" required rows="5" style="resize: none;" maxlength="5000"
                            minlength="256"> </textarea>
                    </div>
                    <!-- Condicoes -->
                    <div class="mb-4 fv-row">
                        <label for="condicoes"
                            class="sub-header-text-5 mb-1 text-primary">{{ __('proposal.fields.conditions') }}</label>
                        <textarea type="text" class="form-control--dei form-control-lg full-border mb-3" id="condicoes" name="condicoes"
                            placeholder="" value="{{ old('condicoes') }}" rows="5" style="resize: none;" maxlength="5000"
                            minlength="256"> </textarea>
                    </div>
                    <!-- Observacoes -->
                    <div class="mb-4 fv-row">
                        <label for="observacoes"
                            class="sub-header-text-5 mb-1 text-primary">{{ __('proposal.fields.observations') }}</label>
                        <textarea type="text" class="form-control--dei form-control-lg full-border mb-3" id="observacoes" name="observacoes"
                            placeholder="" value="{{ old('observacoes') }}" rows="5" style="resize: none;" maxlength="5000"
                            minlength="256"> </textarea>
                    </div>
                    <!-- Orientadores -->
                    <label for="orientador_principal"
                        class="sub-header-text-5 mb-1 text-primary">{{ trans_choice('proposal.fields.supervisor', 2) }}</label>
                    <p type="text" class="form-control--dei form-control-lg mb-0 border-0"
                        id="orientador_principal" name="orientador_principal" disabled>
                        <i class="text-primary mx-2"
                            style="text-transform: uppercase">{{ __('proposal.fields.supervisor_main') }}</i>

                        {{ session()->get('user')->nome_curto }}

                        <u class="mx-2"
                            style="text-transform: uppercase">{{ session()->get('user')->email }}@dei.uc.pt</u>
                    </p>
                    <!-- Orientadores 2 -->
                    <div class="mb-3 fv-row">
                        <div class="input-group input-group-lg dei-full-border px-0 py-0 mx-0 my-0">
                            
                                <div class="input-group-prepend">
                                    <i class="form-control--dei form-control-lg border-0 text-primary mx-2"
                                        style="text-transform: uppercase">{{ __('proposal.fields.supervisor_secondary') }}</i>
                                </div>
                                <select class="custom-select form-select--dei form-select-lg border-0"
                                    aria-label="Default select example" id="orientador_secundario"
                                    name="orientador_secundario">
                                    <!-- Empty option -->

                                    <option class="body-text-2" value="" selected>
                                        {{ trans_choice('proposal.fields.select.supervisor', 1) }}</option>
                                    @foreach (\App\Models\Docente::getActiveDocentesExeptCurrent() as $docente)
                                        <option class="body-text-2" value="{{ $docente->utilizador->email }}"
                                            {{-- {{ old('especializacao_nome1',optional(session()->get('user')->docente())->especializacao_nome) == $especialidade->nome ? 'selected': '' }} --}}>

                                            {{ $docente->utilizador->nome_curto }} -

                                            <u class="mx-2" style="text-transform: uppercase">
                                                {{ $docente->utilizador->email }}@dei.uc.pt</u>
                                        </option>
                                    @endforeach

                                </select>
                        </div>
                    </div>
                    <!-- Orientadores 3 -->
                    <div class="mb-3 fv-row">
                        <div class="input-group input-group-lg dei-full-border px-0 py-0 mx-0 my-0">

                            <div class="input-group-prepend">
                                <i class="form-control--dei form-control-lg border-0 text-primary mx-2"
                                    style="text-transform: uppercase">{{ __('proposal.fields.supervisor_terciary') }}</i>
                            </div>
                            <select class="custom-select form-select--dei form-select-lg border-0"
                                aria-label="Default select example" id="orientador_terciario"
                                name="orientador_terciario">
                                <!-- Empty option -->

                                <option class="body-text-2" value="" selected>
                                    {{ trans_choice('proposal.fields.select.supervisor', 1) }}</option>
                                @foreach (\App\Models\Docente::getActiveDocentesExeptCurrent() as $docente)
                                    <option class="body-text-2" value="{{ $docente->utilizador->email }}"
                                        {{-- {{ old('especializacao_nome1',optional(session()->get('user')->docente())->especializacao_nome) == $especialidade->nome ? 'selected': '' }} --}}>

                                        {{ $docente->utilizador->nome_curto }} -

                                        <u class="mx-2" style="text-transform: uppercase">
                                            {{ $docente->utilizador->email }}@dei.uc.pt</u>
                                    </option>
                                @endforeach

                            </select>
                        </div>
                    </div>
                    <!-- Aluno -->
                    <div class="mb-4 fv-row">
                        <label for="utilizador_email"
                            class="sub-header-text-5 mb-1 text-primary">{{ __('proposal.fields.identified_student') }}</label>
                        <input type="text" class="form-control--dei form-control-lg full-border"
                            id="utilizador_email" name="utilizador_email" placeholder=""
                            value="{{ old('utilizador_email') }}" maxlength="256">
                    </div>
                    <div class="row gx-2">
                        <div class="d-grid col-md-5">
                            <button class="btn btn-outline-primary form-btn-dei mb-3" type="submit"
                                id="submitButton">
                                <span class="spaced-uppertext-dei-bigger">{{ __('words.save') }}</span><span
                                    class="spinner-border spinner-border-sm d-none" id="loginSpinner" role="status"
                                    aria-hidden="true" style="margin-left: 5px"></span>

                            </button>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
