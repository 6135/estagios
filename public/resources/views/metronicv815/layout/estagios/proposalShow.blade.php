<!DOCTYPE html>
<!--
NOTAS:
{{--{{env('APP_URL')}}/js/data-ajax-estagiosPropostasNova.js-->--}}
{{--@extends('metronicv510.layouts.default')--}}
@extends('metronicv815.base.default')
@section("styles")

    <link href="{{asset('metronicv815/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css" />

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
    .wrap-force{
      white-space: wrap;
      word-wrap: break-word;
      word-break: break-all;
    }

    .no-resize {
        resize: none;
     }
</style>
@stop
    @section('content')

<!--begin::Main-->
<div class="app-main flex-column flex-row-fluid " id="kt_app_main">
    <!--begin::Card dialog-->
    <div class="card mt-10">
        <!--begin::Card content-->
        <div class="card-content card-rounded p-5">
            <!--begin::Card header-->
            <div class="card-header row p-5">
                <!--begin::Card title-->
                <h2 class="col">Rever Proposta</h2>
                <!--end::Card title-->
                <div class="input-group col" style="max-width: 200px">
                        <span class="input-group-text flex-right" for="codigoEstagio">
                            Codigo
                            <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip"
                               title="Codigo atribuido a sua proposta. Apenas aparece apos preencher os campos."></i>
                        </span>
                    <input type="text" id="codigoEstagio" class="form-control flex-right" value="{{old('idestagio',$newVersion->idestagio) == '' ? '000000' : old('idestagio',$newVersion->idestagio)}}"
                           aria-label="Codigo da proposta" aria-describedby="basic-addon1" readonly>
                </div>
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body m-5">

                <!--begin::wrapper-->
                <div class="container">
                    <!--begin::row-->
                    <div class="row mb-3">
                        <!--begin::col-->

                        <div class="col">
                            <label for="titEstagioNew" class="form-label ">Titulo do Estagio Novo</label>
                            <div
                                    class="no-resize wrap-force form-control"
                                    type="text"
                                    name="titEstagioNew"
                                    id="titEstagioNew"
                                    value=""
                                    placeholder=""
                                    readonly>{{$newVersion->tituloestagio}}
                            </div>
                        </div>
                        <!--end::col-->
                        <!--begin::col-->
                        <div class="col" hidden>
                            <label for="titEstagioOld" class="form-label ">Titulo do Estagio antigo</label>
                            <div
                                    class="no-resize wrap-force form-control"
                                    type="text"
                                    name="titEstagioOld"
                                    id="titEstagioOld"
                                    readonly>{{$oldVersion->tituloestagio}}
                            </div>
                        </div>
                        <!--end::col-->
                    </div>
                    <!--end::row-->
                    <!--begin::row-->
                    <div class="row mb-3">
                        <!--begin::col-->
                        @php
                            $newOpcaoTematica = $newVersion->opcaoTematica()->with('opcaoTematica')->get();
                            $oldOpcaoTematica = $oldVersion->opcaoTematica()->with('opcaoTematica')->get();
//                            dd($newOpcaoTematica,$oldOpcaoTematica);
                        @endphp
                        <div class="col">
                            <label for="opcaoTematicaPrincipalNew" class="form-label ">Opção Tematica nova</label>
                            <div
                                    class="no-resize wrap-force form-control"
                                    type="text"
                                    name="opcaoTematicaPrincipalNew"
                                    id="opcaoTematicaPrincipalNew"
                                    readonly>{{$newOpcaoTematica[0]->opcaoTematica->nomeopcao}}
                            </div>
                        </div>
                        <!--end::col-->
                        <!--begin::col-->
                        <div class="col" hidden>
                            <label for="opcaoTematicaPrincipalOld" class="form-label ">Opção Tematica antiga</label>
                            <div
                                    class="no-resize wrap-force form-control"
                                    type="text"
                                    name="opcaoTematicaPrincipalOld"
                                    id="opcaoTematicaPrincipalOld"
                                    readonly>{{$oldOpcaoTematica[0]->opcaoTematica->nomeopcao}}
                            </div>
                        </div>
                        <!--end::col-->
                    </div>
                    <!--end::row-->
                    <!--begin::row-->
                    <div class="row mb-3">
                        <!--begin::col-->
                        <div class="col">
                            <label for="opcaoTematicaSecNew" class="form-label ">Opção Tematica nova</label>
                            <div
                                    class="no-resize wrap-force form-control"
                                    type="text"
                                    name="opcaoTematicaSecNew"
                                    id="opcaoTematicaSecNew"
                                    readonly>@if(isset($newOpcaoTematica[1])){{$newOpcaoTematica[1]->opcaoTematica->nomeopcao}}@endif
                            </div>
                        </div>
                        <!--end::col-->
                        <!--begin::col-->
                        <div class="col" hidden>
                            <label for="opcaoTematicaSecOld" class="form-label ">Opção Tematica antiga</label>
                            <div
                                    class="no-resize wrap-force form-control"
                                    type="text"
                                    name="opcaoTematicaSecOld"
                                    id="opcaoTematicaSecOld"
                                    readonly>@if(isset($oldOpcaoTematica[1])){{$oldOpcaoTematica[1]->opcaoTematica->nomeopcao}}@endif
                            </div>
                        </div>
                        <!--end::col-->
                    </div>
                    <!--end::row-->
                    <!--begin::row-->
                    <div class="row mb-3">
                        <!--begin::col-->
                        <div class="col">
                            <label for="representanteLegalNew" class="form-label ">Representante legal</label>
                            <div
                                    class="no-resize wrap-force form-control"
                                    type="text"
                                    name="representanteLegalNew"
                                    id="representanteLegalNew"
                                    readonly>{{$newVersion->repLegal->nome}}

                            </div>
                        </div>
                        <!--end::col-->
                        <!--begin::col-->
                        <div class="col" hidden>
                            <label for="representanteLegalOld" class="form-label ">Representante legal antigo</label>
                            <div

                                    class="no-resize wrap-force form-control"
                                    type="text"
                                    name="representanteLegalOld"
                                    id="representanteLegalOld"
                                    readonly>{{$oldVersion->repLegal->nome}}
                            </div>
                        </div>
                        <!--end::col-->
                    </div>
                    <!--end::row-->
                    <!--begin::row-->
                    <div class="row mb-3">
                        <!--begin::col-->
                        <div class="col">
                            <label for="localEstagioNew" class="form-label ">Local</label>
                            <div
                                    class="no-resize wrap-force form-control"
                                    type="text"
                                    name="localEstagioNew"
                                    id="localEstagioNew"
                                    readonly>{{$newVersion->localestagio}}

                            </div>
                        </div>
                        <!--end::col-->
                        <!--begin::col-->
                        <div class="col" hidden>
                            <label for="localEstagioOld" class="form-label ">Local antigo</label>
                            <div

                                    class="no-resize wrap-force form-control"
                                    type="text"
                                    name="localEstagioOld"
                                    id="localEstagioOld"
                                    readonly>{{$oldVersion->localestagio}}

                            </div>
                        </div>
                        <!--end::col-->
                    </div>
                    <!--end::row-->
                    <!--begin::row-->
                    <div class="row mb-3">
                        <!--begin::col-->
                        <div class="col">
                            <label for="enquadramentoNew" class="form-label ">Enquadramento</label>
                            <div
                                    class="no-resize wrap-force form-control"
                                    type="text"
                                    name="enquadramentoNew"
                                    id="enquadramentoNew"
                                    readonly>{{$newVersion->enquadramento}}

                            </div>
                        </div>
                        <!--end::col-->
                        <!--begin::col-->
                        <div class="col" hidden>
                            <label for="enquadramentoOld" class="form-label ">Enquandramento antigo</label>
                            <div

                                    class="no-resize wrap-force form-control"
                                    type="text"
                                    name="enquadramentoOld"
                                    id="enquadramentoOld"
                                    readonly>{{$oldVersion->enquadramento}}

                            </div>
                        </div>
                        <!--end::col-->
                    </div>
                    <!--end::row-->
                    <!--begin::row-->
                    <div class="row mb-3">
                        <!--begin::col-->
                        <div class="col">
                            <label for="objectivoestagioNew" class="form-label ">Objetivos</label>
                            <div
                                    class="no-resize wrap-force form-control"
                                    type="text"
                                    name="objectivoestagioNew"
                                    id="objectivoestagioNew"
                                    readonly>{{$newVersion->objectivoestagio}}

                            </div>
                        </div>
                        <!--end::col-->
                        <!--begin::col-->
                        <div class="col" hidden>
                            <label for="objectivoestagioOld" class="form-label ">Objetivos antigos</label>
                            <div

                                    class="no-resize wrap-force form-control"
                                    type="text"
                                    name="objectivoestagioOld"
                                    id="objectivoestagioOld"
                                    readonly>{{$oldVersion->objectivoestagio}}

                            </div>
                        </div>
                        <!--end::col-->
                    </div>
                    <!--end::row-->
                    <!--begin::row-->
                    <div class="row mb-3">
                        <!--begin::col-->
                        <div class="col">
                            <label for="ptrabalhosestagioNew" class="form-label ">Plano de trabalho (1º semestre)</label>
                            <div
                                    class="no-resize wrap-force form-control"
                                    type="text"
                                    name="ptrabalhosestagioNew"
                                    id="ptrabalhosestagioNew"
                                    readonly>{{$newVersion->ptrabalhosestagio}}

                            </div>
                        </div>
                        <!--end::col-->
                        <!--begin::col-->
                        <div class="col" hidden>
                            <label for="ptrabalhosestagioOld" class="form-label ">Plano de trabalho (1º semestre) antigo</label>
                            <div

                                    class="no-resize wrap-force form-control"
                                    type="text"
                                    name="ptrabalhosestagioOld"
                                    id="ptrabalhosestagioOld"
                                    readonly>{{$oldVersion->ptrabalhosestagio}}

                            </div>
                        </div>
                        <!--end::col-->
                    </div>
                    <!--end::row-->
                    <!--begin::row-->
                    <div class="row mb-3">
                        <!--begin::col-->
                        <div class="col">
                            <label for="ptrabalhosestagio2New" class="form-label ">Plano de trabalho (2º semestre)</label>
                            <div
                                    class="no-resize wrap-force form-control"
                                    type="text"
                                    name="ptrabalhosestagio2New"
                                    id="ptrabalhosestagio2New"
                                    readonly>{{$newVersion->ptrabalhosestagio2}}

                            </div>
                        </div>
                        <!--end::col-->
                        <!--begin::col-->
                        <div class="col" hidden>
                            <label for="ptrabalhosestagio2Old" class="form-label ">Plano de trabalho (2º semestre) antigo</label>
                            <div

                                    class="no-resize wrap-force form-control"
                                    type="text"
                                    name="ptrabalhosestagio2Old"
                                    id="ptrabalhosestagio2Old"
                                    readonly>{{$oldVersion->ptrabalhosestagio2}}

                            </div>
                        </div>
                        <!--end::col-->
                    </div>
                    <!--end::row-->
                    <!--begin::row-->
                    <div class="row mb-3">
                        <!--begin::col-->
                        <div class="col">
                            <label for="condicoesestagiosNew" class="form-label ">Condições</label>
                            <div
                                    class="no-resize wrap-force form-control"
                                    type="text"
                                    name="condicoesestagiosNew"
                                    id="condicoesestagiosNew"
                                    readonly>{{$newVersion->condicoesestagios}}

                            </div>
                        </div>
                        <!--end::col-->
                        <!--begin::col-->
                        <div class="col" hidden>
                            <label for="condicoesestagiosOld" class="form-label ">Condições antigas</label>
                            <div

                                    class="no-resize wrap-force form-control"
                                    type="text"
                                    name="condicoesestagiosOld"
                                    id="condicoesestagiosOld"
                                    readonly>{{$oldVersion->condicoesestagios}}

                            </div>
                        </div>
                        <!--end::col-->
                    </div>
                    <!--end::row-->
                    <!--begin::row-->
                    <div class="row mb-3">
                        <!--begin::col-->
                        <div class="col">
                            <label for="observacoesestagioNew" class="form-label ">Observações</label>
                            <div
                                    class="no-resize wrap-force form-control"
                                    type="text"
                                    name="observacoesestagioNew"
                                    id="observacoesestagioNew"
                                    readonly>{{$newVersion->observacoesestagio}}

                            </div>
                        </div>
                        <!--end::col-->
                        <!--begin::col-->
                        <div class="col" hidden>
                            <label for="observacoesestagioOld" class="form-label ">Observações antigas</label>
                            <div

                                    class="no-resize wrap-force form-control"
                                    type="text"
                                    name="observacoesestagioOld"
                                    id="observacoesestagioOld"
                                    readonly>{{$oldVersion->observacoesestagio}}

                            </div>
                        </div>
                        <!--end::col-->
                    </div>
                    <!--end::row-->
                </div>
                <!--end::wrapper-->
                <div class="">
                    <div class="">Legenda
                    </div>
                    <div class="footerItemText">
                        <div class="legend">
                            <ul>
                                <li><span class="wikEdDiffMarkRight" title="Bloco movido" id="wikEdDiffMark999" onmouseover="wikEdDiffBlockHandler(undefined, this, 'mouseover');"></span> Posicao Original do bloco</li>
                                <li><span title="+" class="wikEdDiffInsert">Inserido<span class="wikEdDiffSpace"><span class="wikEdDiffSpaceSymbol"></span> </span>texto<span class="wikEdDiffNewline"> </span></span></li>
                                <li><span title="−" class="wikEdDiffDelete">Removido<span class="wikEdDiffSpace"><span class="wikEdDiffSpaceSymbol"></span> </span>texto<span class="wikEdDiffNewline"> </span></span></li>
                                <li><span class="wikEdDiffBlockLeft" title="◀" id="wikEdDiffBlock999" onmouseover="wikEdDiffBlockHandler(undefined, this, 'mouseover');">Bloco<span class="wikEdDiffSpace"><span class="wikEdDiffSpaceSymbol"></span> </span>movido<span class="wikEdDiffNewline"> </span></span></li>
                                <li><span class="newlineSymbol">¶</span> Linha nova </li>
                                <li><span class="spaceSymbol">·</span> Espaço </li>
                                <li><span class="tabSymbol">→</span> Tab</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Card content-->
    </div>
    <!--end::Card dialog-->
</div>
<!--end:::Main-->
@stop
@section('scripts')

    <script src="{{asset('js/wikidiff.js')}}"></script>
    <script>

        const ids = [
            'titEstagio',
            'opcaoTematicaPrincipal',
            'opcaoTematicaSec',
            'representanteLegal',
            'localEstagio',
            'enquadramento',
            'objectivoestagio',
            'ptrabalhosestagio',
            'ptrabalhosestagio2',
            'condicoesestagios',
            'observacoesestagio',
        ];

        function diffFragment(newstring ,oldstring){
            let wikEdDiff = new WikEdDiff();
            let diff = wikEdDiff.diff(
                oldstring.trim(),
                newstring.trim()
            );
            diff = $(diff);
            // let result = $('.wikEdDiffFragment',diff).html();
            if($(diff).find('.wikEdDiffNoChange').length)
                return false;
            return $('.wikEdDiffFragment',diff).html();
        }
        function prepareDiff(id){
            let newId = id+"New";
            let oldId = id+'Old';
            let diff = diffFragment(
                $('#'+newId).text(),
                $('#'+oldId).text()
            );
            if(!diff)
                $('#'+newId).append(`<br><div class="wikEdDiffNoChange" title="=">(Sem diferenças)</div>`);
            else $('#'+newId).html(diff);
        }

        $(document).ready(function () {

            ids.forEach(function (element,index,array) {
                console.log(element);
                prepareDiff(element);
            })
        })


    </script>
@stop