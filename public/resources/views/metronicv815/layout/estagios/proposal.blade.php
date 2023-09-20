<!DOCTYPE html>

@extends('metronicv815.base.default')
@section('styles')

    <link href="{{ asset('metronicv815/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet"
        type="text/css" />

    <style>
        .container.container-no-sides {
            margin-left: 0;
            margin-right: 0;
            padding-left: 0;
            padding-right: 0;
        }

        .container.container-full-width {
            max-width: 100%;
        }

        .ui-datepicker-calendar {
            display: none;
        }

        .is-valid {
            border-color: #50cd89 !important;
        }

        .is-invalid {
            border-color: #f1416c !important;
        }
    </style>
@stop
@section('content')

    <!--begin::Modal dialog-->
    <div class="modal-dialog pt-10" style="min-width:90%">
        <!--begin::Modal content-->
        <div class="modal-content modal-rounded p-5">
            <!--begin::Modal header-->
            <div class="modal-header row p-5">
                <!--begin::Modal title-->
                <h2 class="col">Criar Proposta</h2>
                <!--end::Modal title-->
                <div class="input-group col" style="max-width: 200px">
                    <span class="input-group-text flex-right" for="codigoEstagio">
                        Codigo
                        <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip"
                            title="Codigo atribuido a sua proposta. Apenas aparece apos preencher os campos."></i>
                    </span>
                    <input type="text" id="codigoEstagio" class="form-control flex-right"
                        value="{{ old('idestagio', $estagio->idestagio) == '' ? '000000' : old('idestagio', $estagio->idestagio) }}"
                        aria-label="Codigo da proposta" aria-describedby="basic-addon1" readonly>
                </div>
            </div>

            <!--end::Modal header-->
            <!--begin::Modal body-->
            <div class="modal-body m-5">

                <!--begin::Stepper-->
                <div class="stepper stepper-pills stepper-column d-flex flex-column flex-xl-row end"
                    id="kt_stepper_example_clickable">
                    <!--begin::Aside-->
                    <div class="d-flex flex-row-auto  " style="padding-right: 20px">
                        <!--w-300 w-lg-300px-->
                        <!--begin::Nav-->
                        <div class="stepper-nav mb-5">
                            <!--begin::Step 1-->
                            <div class="stepper-item me-5 current" data-kt-stepper-element="nav"
                                data-kt-stepper-action="step">
                                <!--begin::Wrapper-->
                                <div class="stepper-wrapper d-flex align-items-center">
                                    <!--begin::Icon-->
                                    <div class="stepper-icon w-40px h-40px">
                                        <i class="stepper-check fas fa-check"></i>
                                        <span class="stepper-number">1</span>
                                    </div>
                                    <!--end::Icon-->

                                    <!--begin::Label-->
                                    <div class="stepper-label">
                                        <h3 class="stepper-title">
                                            Dados da proposta
                                        </h3>

                                        <!-- <div class="stepper-desc">
                                            Description
                                        </div> -->
                                    </div>

                                    <!--end::Label-->
                                </div>
                                <!--end::Wrapper-->

                                <!--begin::Line-->
                                <div class="stepper-line h-40px"></div>
                                <!--end::Line-->
                            </div>
                            <!--end::Step 1-->

                            <!--begin::Step 2-->
                            <div class="stepper-item me-5" data-kt-stepper-element="nav" data-kt-stepper-action="step">
                                <!--begin::Wrapper-->
                                <div class="stepper-wrapper d-flex align-items-center">
                                    <!--begin::Icon-->
                                    <div class="stepper-icon w-40px h-40px">
                                        <i class="stepper-check fas fa-check"></i>
                                        <span class="stepper-number">2</span>
                                    </div>
                                    <!--begin::Icon-->

                                    <!--begin::Label-->
                                    <div class="stepper-label">
                                        <h3 class="stepper-title">
                                            Orientação
                                        </h3>

                                        <!-- <div class="stepper-desc">
                                            Description
                                        </div> -->
                                    </div>
                                    <!--end::Label-->
                                </div>
                                <!--end::Wrapper-->

                                <!--begin::Line-->
                                {{--                                    <div class="stepper-line h-40px"></div> --}}
                                <!--end::Line-->
                            </div>
                            <!--end::Step 2-->

                        </div>
                        <!--end::Nav-->
                    </div>

                    <!--begin::Content-->
                    <div class="flex-row-fluid">
                        <!--begin::Form-->
                        <form enctype="multipart/form-data" id="kt_stepper_example_form" class="form mx-auto" 
                            @if(!(isset($viewMode) && $viewMode == true))  action="{{ action('EstagioController@sumbitEstagio') }}" @else novalidate="true" @endif method="POST">
                            <!--w-lg-500px-->
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                            @if(!(isset($viewMode)))  {{ csrf_field() }} @endif
                            <!--begin::Group-->
                            <div class="mb-5">
                                <!--begin::Step 1-->
                                <div class="flex-column current" data-kt-stepper-element="content">
                                    <!--begin::Input group-->
                                    <div class="container-fluid container-no-sides mb-7 p-0">
                                        <div class="row">
                                            <div class="col">
                                                <div class="form-floating fv-row "  >

                                                    <select id="floatingSelectPE"  @if((isset($viewMode))) disabled="" @endif class="form-select "
                                                        name="periodo_estagios" aria-label="Selecionar periodo de estagio" >
                                                        <option value="">Escolha o periodo de estagio</option>

                                                        @foreach ($periodosEstagio as $periodo)
                                                            <option value="{{ $periodo['idperiodo_estagio'] }}"
                                                                data-date-inicio-entrevistas="{{ $periodo['data_inicio_entrevistas'] }}"
                                                                data-date-fim-entrevistas="{{ $periodo['data_fim_entrevistas'] }}"
                                                                hidden-curso="{{ $periodo['curso'] }}"
                                                                {{ old('periodo_estagios', $estagio->periodo_estagio_idperiodo_estagio) == $periodo['idperiodo_estagio'] ? 'selected' : '' }}>
                                                                {{ $periodo['descricao'] }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    
                                                    <label for="floatingSelectPE" class="form-label required">Periodo de
                                                        Estágio</label>
                                                </div>
                                            </div>
                                            <div class="col" style="max-width: 25%">
                                                <div class="form-floating fv-row">
                                                    <input type="text" class="form-control form-control-solid"
                                                        id="floatingInputCurso" name="floatingInputCurso"
                                                        value="{!! old('floatingInputCurso', optional($estagio->periodoEstagio)->curso) !!}" readonly />

                                                    <label for="floatingInputCurso" class="form-label">Curso</label>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="container-fluid container-no-sides mb-7 p-0">
                                        <div class="row">
                                            <div id="floatingSelectAETP" class="col">
                                                <div class="form-floating fv-row ">
                                                    {{-- --}}
                                                    <select class="form-select " id="floatingSelectAE"
                                                        name="floatingSelectAE" aria-label="Selecionar Area Especialidade" @if((isset($viewMode))) disabled="" @endif>
                                                        <option value="">Selecionar Area Especialidade
                                                        </option>
                                                    </select>
                                                    <label for="floatingSelectAE" class="form-label required">Area de
                                                        Especialidade
                                                    </label>
                                                    <div id="tooltip_container"></div>
                                                </div>

                                            </div>

                                            <div id="floatingSelectAETP2" class="col">
                                                <div class="form-floating fv-row ">

                                                    <select class="form-select " id="floatingSelectAE2"
                                                        name="floatingSelectAE2" value="" placeholder=""
                                                        aria-label="Selecionar Area Especialidade secundaria" @if((isset($viewMode))) disabled="" @endif>
                                                        <option value="">Selecionar Area Especialidade
                                                        </option>
                                                    </select>
                                                    <label for="floatingSelectAE2" class="form-label">Area de
                                                        Especialidade</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="fv-row mb-7" id="TextareaOpcaoTematicaTP" style="display: none;"
                                        is-hidden="true">
                                        <label class="form-label" for="TextareaOpcaoTematica">Area de
                                            especialidade</label>
                                        <textarea maxlength="5000" class="form-control  kt_docs_maxlength_basic" id="TextareaOpcaoTematica"
                                            name="TextareaOpcaoTematica" style="height: 100px" @if((isset($viewMode))) disabled="" @endif>{{ old('TextareaOpcaoTematica', $opcoeTematicaDesc) }}</textarea>

                                    </div>
                                    <!--begin::Input group-->
                                    <div class="form-floating fv-row mb-7 ">
                                        <input for="floatingInputTitle2" type="text" class="form-control"
                                            name="titEstagio" placeholder="Titulo" required
                                            value="{{ old('titEstagio', $estagio->tituloestagio) }}" @if((isset($viewMode))) disabled="" @endif/>
                                        <label id="floatingInputTitle" class="form-label required">Titulo do
                                            Estagio</label>
                                    </div>
                                    <!--end::Input group-->

                                    <!--begin::Input group-->
                                    @if ($empresa->idempresa != 1)
                                        <div class="form-floating fv-row mb-7">

                                            <select class="form-select " name="legal_rep" value="" placeholder=""
                                                aria-label="Selecionar Representante Legal" @if((isset($viewMode))) disabled="" @endif>
                                                <option value="">Selecionar Representante Legal</option>
                                                >
                                                @foreach ($empresaRepresentantes as $rep)
                                                    <option value="{{ $rep['id'] }}"
                                                        {{ old('legal_rep', $estagio->empresa_representantelegal) == $rep['id'] ? 'selected' : '' }}>
                                                        {{ $rep['nome'] }}
                                                    </option>
                                                @endforeach

                                            </select>
                                            <label class="form-label  required">Representante
                                                Legal</label>
                                        </div>
                                    @endif
                                    <!--end::Input group-->

                                    <!--begin::Input group-->
                                    <div class="container-fluid container-no-sides mb-7 p-0">
                                        <div class="row">
                                            <div class="col">
                                                <div class="form-floating fv-row">
                                                    <input type="text" class="form-control " id="floatingInputLocal"
                                                        name="floatingInputLocal" placeholder=" "
                                                        value="{{ old('floatingInputLocal', $estagio->localestagio != "" ? $estagio->localestagio : $empresa->moradaempresa) }}" @if((isset($viewMode))) disabled="" @endif />
                                                    <label for="floatingInputLocal"
                                                        class="form-label required">Local</label>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="fv-row mb-7">
                                        <label class="form-label  required"
                                            for="TextareaEnquandramento">Enquadramento</label>
                                        <textarea maxlength="5000" class="form-control kt_docs_maxlength_basic" id="TextareaEnquandramento"
                                            name="TextareaEnquandramento" style="height: 100px" @if((isset($viewMode))) disabled="" @endif>{{ old('TextareaEnquandramento', $estagio->enquadramento) }}</textarea>

                                    </div>
                                    <!--begin::Input group-->
                                    <div class="fv-row mb-7">
                                        <label class="form-label required" for="TextareaObjetivos">Objetivos</label>
                                        <textarea maxlength="5000" class="form-control kt_docs_maxlength_basic" id="TextareaObjetivos"
                                            name="TextareaObjetivos" style="height: 100px" @if((isset($viewMode))) disabled="" @endif>{{ old('TextareaObjetivos', $estagio->objectivoestagio) }}</textarea>

                                    </div>
                                    <!--end::Input group-->

                                    <!--begin::Input group-->
                                    <div class="fv-row mb-7">
                                        <label class="form-label required" for="TextareaPlano1Semestre">Plano de
                                            trabalho (1º semestre)</label>
                                        <textarea maxlength="5000" class="form-control kt_docs_maxlength_basic" id="TextareaPlano1Semestre"
                                            name="TextareaPlano1Semestre" style="height: 100px" @if((isset($viewMode))) disabled="" @endif>{{ old('TextareaPlano1Semestre', $estagio->ptrabalhosestagio) }}</textarea>

                                    </div>
                                    <!--end::Input group-->

                                    <!--begin::Input group-->
                                    <div class="fv-row mb-7">
                                        <label class="form-label required" for="TextareaPlano2Semestre">Plano de
                                            trabalho (2º semestre)</label>
                                        <textarea maxlength="5000" class="form-control kt_docs_maxlength_basic" id="TextareaPlano2Semestre"
                                            name="TextareaPlano2Semestre" style="height: 100px" @if((isset($viewMode))) disabled="" @endif>{{ old('TextareaPlano2Semestre', $estagio->ptrabalhosestagio2) }}</textarea>

                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="fv-row mb-7">
                                        <label class="form-label" for="TextareaCondicoes">Condições</label>
                                        <textarea maxlength="5000" class="form-control kt_docs_maxlength_basic" id="TextareaCondicoes"
                                            name="TextareaCondicoes" style="height: 100px" @if((isset($viewMode))) disabled="" @endif>{{ old('TextareaCondicoes', $estagio->condicoesestagios) }}</textarea>

                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="fv-row mb-7">
                                        <label class="form-label" for="TextareaElementosAdicionais">Observações e
                                            elementos
                                            adicionais</label>
                                        <textarea maxlength="5000" class="form-control  kt_docs_maxlength_basic" id="TextareaElementosAdicionais"
                                            name="TextareaElementosAdicionais" style="height: 100px" @if((isset($viewMode))) disabled="" @endif>{{ old('TextareaElementosAdicionais', $estagio->observacoesestagio) }}</textarea>

                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class=" fv-row rounded border p-5 ">
                                        <label class="form-label" for="">Deseja realizar entrevistas?</label>

                                        <div class="row mt-7 mb-7">

                                            <div class="col-4 form-group">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" value="1"
                                                        id="radioCheckEntrevistas" name="radioCheckEntrevistas"
                                                        {{ old('radioCheckEntrevistas', $estagio->desejaentrevistas + 1) == 1 ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="flexCheckDefault1">Sim</label>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" value="2"
                                                        id="radioCheckEntrevistas" name="radioCheckEntrevistas"
                                                        {{ old('radioCheckEntrevistas', $estagio->desejaentrevistas + 1) == 2 ? 'checked' : '' }} @if((isset($viewMode))) disabled="" @endif>
                                                    <label class="form-check-label" for="flexCheckChecked1">Não</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="container-fluid container-no-sides mb-7 p-0" id="dataEntrevistas" style="display: none">
                                            <div class="row">
                                                <div class="col">
                                                    <div class="form-floating fv-row">
                                                        <input type="" class="form-control " id="floatingInputDataInicioEntrevistas"
                                                        placeholder="" value="" disabled readonly/>
                                                    <label for="floatingInputDataInicioEntrevistas"
                                                        class="form-label">Data de incio de entrevistas</label>
                                                    </div>
                                                </div>
    
                                                <div class="col">
                                                    <div class="form-floating fv-row ">
                                                        <input type="" class="form-control " id="floatingInputDataFimEntrevistas"
                                                        placeholder=" " value="" disabled readonly/>
                                                    <label for="floatingInputDataFimEntrevistas"
                                                        class="form-label">Data de fim de entrevistas</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Input group-->
                                </div>
                                <!--end::Step 1/2-->

                                <!--begin::Step 3-->
                                @php
                                    // dd($self);
                                @endphp
                                <div class="flex-column" data-kt-stepper-element="content">
                                    @if(!(isset($viewMode)))
                                        @if (isset($self) and !is_null($self))
                                            <div class="form-floating fv-row mb-7 ">
                                                <input type="text" class="form-control form-control-solid" placeholder=" "
                                                    disabled value="{{ $self }}" />
                                                <label class="form-label ">Orientador</label>
                                            </div>
                                        @endif
                                    @endif
                                    @php
                                    $colaboradoresEstagio = $estagio->colaboradores()->allColab()->get();
                                    $docentesEstagio = $estagio->docentes->toArray();
                                    // dd($docentesEstagio);
                                    $profile = session()->get('profile');
                                    $select = 'Selecionar Orientador';
                                    $required = 'required';
                                    if ($profile == \App\Role::EmpresaColaborador || $profile == \App\Role::Docente) {
                                        $select = 'Selecionar co-orientador';
                                        $required = '';
                                    }
                                    
                                @endphp
                                
                                @if((isset($viewMode))) 
                                    @if ($estagio->empresa_idempresa > 1)
                                        @foreach ($colaboradoresEstagio as $key=>$rep)
                                            <div class="form-floating fv-row mb-7">
                                                <input type="text" class="form-control"
                                                    placeholder=" "
                                                    value="{{ $rep['nome']. ' - ' . $rep->getEmail() }}" disabled/>
                                                <label class="form-label">Colaborador</label>
                                            </div>
                                        @endforeach
                                    @else
                                        @foreach ($docentesEstagio as $key=>$rep)
                                            <div class="form-floating fv-row mb-7">
                                                <input type="text" class="form-control "
                                                    placeholder=" "
                                                    value="{{ $rep['nomedocente'] . ' - ' . $rep->getEmail() }}" disabled/>
                                                <label class="form-label">{{$key > 0 ? "Co-orientador" : "Orientador"}}</label>
                                            </div>
                                        @endforeach
                                    @endif
                                <!--end::Input group-->
                                @endif
                                    <!--Begin::Input group-->
                                    @if(!(isset($viewMode))) 
                                        <div class="form-floating fv-row mb-7" name="1stbeforeSel">



                                            <select class="form-select exclusive-sel" id="colab1" name="colab1"
                                                aria-label="Selecionar Orientador" data-control="select2"
                                                {{ $required }} @if((isset($viewMode))) disabled="" @endif>
                                                <option value="-1">{{ $select }}</option>

                                                @if ($estagio->empresa_idempresa > 1)
                                                    @foreach ($empresaColaboradores as $rep)
                                                        <option value="{{ $rep['id'] }}"
                                                            {{-- {{ old('colab1', optional($colaboradoresEstagio)[0]['id']) == $rep['id'] ? 'selected' : '' }}
                                                            {{ old('colab2', optional($colaboradoresEstagio)[1]['id']) == $rep['id'] ? 'hidden' : '' }}
                                                            {{ old('colab3', optional($colaboradoresEstagio)[2]['id']) == $rep['id'] ? 'hidden' : '' }} --}}
                                                            >
                                                            {{ $rep['nome'] . ' - ' . $rep->getEmail() }}
                                                        </option>
                                                    @endforeach
                                                @elseif($estagio->empresa_idempresa == 1)
                                                    @foreach ($empresaColaboradores as $rep)
                                                        <option value="{{ $rep['logindocente'] }}"
                                                            {{-- {{ old('colab1', optional($docentesEstagio)[1]['logindocente']) == $rep['logindocente'] ? 'selected' : '' }}
                                                            {{ old('colab2', optional($docentesEstagio)[2]['logindocente']) == $rep['logindocente'] ? 'hidden' : '' }}
                                                            {{ old('colab3', optional($docentesEstagio)[0]['logindocente']) == $rep['logindocente'] ? 'hidden' : '' }} --}}
                                                            >
                                                            {{ $rep['nomedocente'] . ' - ' . $rep->getEmail() }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            <label class="form-label {{ $required }}">{{ $select }} 1</label>
                                        </div>
                                    @endif

                                    <!--begin::Input group-->
                                    <!--end::Input group-->
                                    @if(!(isset($viewMode))) 
                                        @if (isset($displayColab2) and $displayColab2)
                                            <div class="form-floating fv-row mb-7" name="2ndbeforeSel" hidden>
                                                <select class="form-select exclusive-sel is-valid" id="colab2"
                                                    name="colab2" data-control="select2" aria-label="Selecionar Orientador" @if((isset($viewMode))) disabled="" @endif>
                                                    <option value="-2">{{ $select }}</option>
                                                    <option>Nenhum</option>
                                                    @if ($estagio->empresa_idempresa > 1)
                                                        @foreach ($empresaColaboradores as $rep)
                                                            <option value="{{ $rep['id'] }}"
                                                                {{ old('colab2',  optional(optional($colaboradoresEstagio)[1])['id']) == $rep['id'] ? 'selected' : '' }}
                                                                {{ old('colab1',  optional(optional($colaboradoresEstagio)[0])['id']) == $rep['id'] ? 'hidden' : '' }}
                                                                {{ old('colab3',  optional(optional($colaboradoresEstagio)[2])['id']) == $rep['id'] ? 'hidden' : '' }}
                                                                >
                                                                {{ $rep['nome'] . ' - ' . $rep->getEmail() }}
                                                            </option>
                                                        @endforeach
                                                    @elseif($estagio->empresa_idempresa == 1)
                                                            
                                                        @foreach ($empresaColaboradores as $rep)
                                                            <option value="{{ $rep['logindocente'] }}"
                                                                {{ old('colab1',  optional(optional($docentesEstagio)[1])['logindocente']) == $rep['logindocente'] ? '' : '' }}
                                                                {{ old('colab2',  optional(optional($docentesEstagio)[2])['logindocente']) == $rep['logindocente'] ? 'selected' : '' }}
                                                                {{ old('colab3',  optional(optional($docentesEstagio)[0])['logindocente']) == $rep['logindocente'] ? 'hidden' : '' }}
                                                                >
                                                                {{ $rep['nomedocente'] . ' - ' . $rep->getEmail() }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                                <label class="form-label">{{ $select }} 2</label>
                                            </div>
                                        @endif
                                    @endif

                                    <!--begin::Input group-->
                                    @if(!(isset($viewMode))) 
                                        @if (isset($displayColab3) and $displayColab3)
                                            <!--end::Input group-->
                                            <div class="form-floating fv-row mb-7" name="3rdbeforeSel" hidden>

                                                <select class="form-select exclusive-sel" id="colab3" name="colab3"
                                                    value="" placeholder="" aria-label="Selecionar Orientador" @if((isset($viewMode))) disabled="" @endif>
                                                    <option>Selecionar Orientador</option>
                                                    <option>Nenhum</option>
                                                    @if ($estagio->empresa_idempresa > 1)
                                                        @foreach ($empresaColaboradores as $rep)
                                                            <option value="{{ $rep['id'] }}"
                                                                {{ old('colab1',  optional(optional($colaboradoresEstagio)[2])['id']) == $rep['id'] ? 'selected' : '' }}
                                                                {{ old('colab2',  optional(optional($colaboradoresEstagio)[1])['id']) == $rep['id'] ? 'hidden' : '' }}
                                                                {{ old('colab3',  optional(optional($colaboradoresEstagio)[0])['id']) == $rep['id'] ? 'hidden' : '' }}
                                                                >
                                                                {{ $rep['nome'] }}
                                                            </option>
                                                        @endforeach
                                                    @elseif($estagio->empresa_idempresa == 1)
                                                        @foreach ($empresaColaboradores as $rep)
                                                            <option value="{{ $rep['logindocente'] }}"
                                                                {{ old('colab1',  optional(optional($docentesEstagio)[2])['logindocente']) == $rep['logindocente'] ? 'selected' : '' }}
                                                                {{ old('colab2',  optional(optional($docentesEstagio)[1])['logindocente']) == $rep['logindocente'] ? 'hidden' : '' }}
                                                                {{ old('colab3',  optional(optional($docentesEstagio)[0])['logindocente']) == $rep['logindocente'] ? 'hidden' : '' }}
                                                                >
                                                                {{ $rep['nomedocente'] }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                                <label class="form-label">Orientador 3</label>
                                            </div>
                                        @endif
                                    @endif
                                    @if ($estagio->empresa_idempresa > 1)
                                        
                                    <!--begin::Input group-->
                                        @if(!(isset($viewMode)))
                                            <div class="fv-row mb-7">
                                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                    data-bs-target="#modal_colaborador_externo">
                                                    <span class="svg-icon svg-icon-2">
                                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1" transform="rotate(-90 11.364 20.364)" fill="currentColor"></rect>
                                                                    <rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="currentColor"></rect>
                                                                </svg>
                                                            </span>
                                                    Novo Colaborador Externo
                                                </button>
                                            </div>
                                        @endif
                                    <!--end::Input group-->
                                    @endif

                                    <!--begin::Input group-->


                                    <div class="modal-header row mb-7">
                                        <!--begin::Modal title-->
                                        <h3 class="col">Aluno</h3>
                                        <!--end::Modal title-->
                                    </div>
                                    <!--begin::Input group-->
                                    <div class="form-floating fv-row mb-7">
                                        <input id="inputEmailAluno" type="text" class="form-control  email_mask_dei"
                                            name="inputEmailAluno" placeholder=" "
                                            value="{{ old('inputEmailAluno', $estagio->emailaluno) }}" @if((isset($viewMode))) disabled="" @endif />
                                        <label id="inputEmailAluno" class="form-label">Email</label>
                                    </div>
                                    <!--end::Input group-->

                                    <div
                                        class="form-check form-check-custom form-check-success form-check-solid form-check-lg mb-7">
                                        <input class="form-check-input" type="checkbox" value="1"
                                            id="flexCheckDefault" onclick="return false;" checked />
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Declaro que todos os dados associados a esta proposta são verdadeiros.
                                        </label>
                                    </div>

                                </div>
                                <!--begin::Step 4-->
                            </div>
                            <!--end::Group-->

                            <!--begin::Actions-->
                            <div class="d-flex flex-stack">
                                <!--begin::Wrapper-->
                                <div class="me-2">
                                    <button type="button" class="btn btn-light btn-active-light-primary"
                                        data-kt-stepper-action="previous">
                                        Anterior
                                    </button>
                                </div>
                                <!--end::Wrapper-->
                                <!--begin::Wrapper-->
                                <div>
                                    
                                    <button type="button" class="btn btn-primary" data-kt-stepper-action="submit"
                                        action="submit"  @if((isset($viewMode))) disabled style="display: none !important" @endif)  >
                                        <span class="indicator-label">
                                            Submeter
                                        </span>
                                        <span class="indicator-progress">
                                            Por favor aguarde... <span
                                                class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                        </span>
                                    </button>

                                    <button type="button" class="btn btn-primary" data-kt-stepper-action="next">
                                        Proximo
                                    </button>
                                </div>
                                <!--end::Wrapper-->
                            </div>
                            <!--end::Actions-->
                            <input type="hidden" id="estagioID" name="estagioID" value="{{ $estagio->idestagio }}">
                        </form>
                        <!--end::Form-->
                    </div>
                </div>
                <!--end::Stepper-->


            </div>
            <!--end::Modal body-->
        </div>
        <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
    @if ($estagio->empresa_idempresa > 1)
        @include('metronicv815.layout.partials.modals.modalColaboradorExterno')
    @endif

@stop
@section('scripts')
    <script src="{{ asset('js/novoestagio.js') }}" charset="utf-8"></script>
    <script src="{{ asset('metronicv815/plugins/custom/jinputmask/jquery.inputmask.js') }}"></script>
    <script src="{{ asset('js/bootstrap-maxlength.js') }}"></script>
    <script>
        let previousVal = "abc";
        let oldAE1 =
            "{{ old('floatingSelectAE', optional(optional($estagio->opcaoTematica)[0])->opcaotematica_idopcaotematica) }}";
        let oldAE2 =
            "{{ old('floatingSelectAE2', optional(optional($estagio->opcaoTematica)[1])->opcaotematica_idopcaotematica) }}";
        let local = '{{ $empresa->moradaempresa }}';

        $(document).ready(function(){

            //write code to reset form with id 'novoColaboradorExternoForm' on event 'hidden.bs.modal'
            $('#modal_colaborador_externo').on('hide.bs.modal', function (event) {
                $(this).find('#novoColaboradorExternoForm').trigger('reset');
            });
             
            
            $('#btnNovoColaboradorExternoSave').click(function(event){
                
                if(!$("#novoColaboradorExternoForm").get(0).reportValidity())
                    return null;
                var x = $("#novoColaboradorExternoForm").serializeArray();
                var myData = new Object();

                $.each(x, function(index, field){
                    myData[field.name] = field.value;
                });

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $('#btnNovoColaboradorExternoSave').prop("disabled", true);

                            $.ajax({
                type: "POST",
                url: "/empresa/novocolaboradorexterno",
                data: JSON.stringify(myData),
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                success: function(data) {
                    if(data.result) {
                        toastr.success(
                            data.message,
                            'Colaborador externo adicionado'
                        );
                        $('#btnNovoColaboradorExternoSave').prop("disabled", false);
                        data = data['colabExt'];
                        var newOption = new Option(data.nome+" - "+data.email, data.id, true, true);
                        $('#colab1').append(newOption).trigger('change');
                        newOption = new Option(data.nome+" - "+data.email, data.id, false, false);
                        $('#colab2').append(newOption).trigger('change');
                        $('#modal_colaborador_externo').modal('toggle');
                        $('#modal_colaborador_externo').find('form').trigger('reset');
                        
                    } else {
                        $('#btnNovoColaboradorExternoSave').prop("disabled", false);

                        toastr.error(
                            data.message,
                            'Erro ao adicionar colaborador externo'
                        );
                    }

                },
                error: function(errMsg) {
                    $('#btnNovoColaboradorExternoSave').prop("disabled", false);

                    toastr.error(
                        'Ocorreu erro desconhecido, verifique campos ou contacte helpdesk@dei.uc.pt',
                        'Erro',
                    );
                }
            });

            });


        });

        $( "#floatingSelectPE" ).change(function() {
            if($("#floatingSelectPE").find(":selected").val()){
                $("#dataEntrevistas").show();
            }else{
                $("#dataEntrevistas").hide();
            }
        });

    </script>

@stop
