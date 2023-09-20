@extends('metronicv815.base.default')

@section('styles')
    <style>
        body {
            overflow-wrap: break-word;
            hyphens: auto;
        }
    </style>
@endsection
@section('content')

    <!--begin::Card-->
    <div class="card mt-7" style="min-width: 90%">
        <div class="card-header p-5">
            <div class="card-title align-items-start col flex-column">
                <h3>
                    Dados da empresa
                    <i class="la la-gear"></i>
                </h3>
            </div>
            <div class="card-toolbar">
                <div class="input-group col-lg-2" style="max-width: 200px">
                            <span class="input-group-text flex-right" for="codigoEstagio">
                                Codigo
                                <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip"
                                   title="Codigo atribuido a sua empresa."></i>
                            </span>
                    <input type="text" id="codigoEstagio" class="form-control flex-right"
                           value="{{$empresa['idempresa']}}"
                           aria-label="Codigo da empresa" aria-describedby="basic-addon1" readonly>
                </div>
            </div>
        </div>
        <!--begin::Form-->

        <div class="card-body mx-auto">

            <div class="d-flex flex-column flex-xl-row end">

                <!--begin::Content-->
                <div class="flex-row-fluid">
                    <!--begin::Form-->
                    <form enctype="multipart/form-data" action="###" class="form" action="#" method="POST"
                          id="empresaForm">

                        <!--w-lg-500px-->

                        {{ csrf_field() }}
                        <!--begin::Group-->

                        <!--begin::Step 1-->
                        <div class="flex-column">
                            <!--begin::Input group-->
                            <div class="form-floating fv-row mb-7 ">
                                <input id="nome"
                                       name="nome"
                                       type="text"
                                       class="form-control"
                                       placeholder="Nome da entidade acolhedora por extenso"
                                       value="{{$empresa['nomeempresa']}}"
                                       required
                                />
                                <label for="nome"
                                       class="form-label">
                                    Nome da Empresa
                                </label>
                            </div>
                            <!--end::Input group-->
                            <div class="container-fluid container-no-sides mb-7 p-0">
                                <div class="row">
                                    <div class="col">
                                        <div class="form-floating fv-row">
                                            <input type="text"
                                                   class="form-control "
                                                   id="acronimo"
                                                   name="acronimo"
                                                   placeholder="Acrónimo"
                                                   value="{{$empresa['acronimoempresa']}}" required/>
                                            <label for="acronimo"
                                                   class="form-label required">Acrónimo</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--begin::Input group-->
                            <!--end::Input group-->
                            <div class="container-fluid container-no-sides mb-7 p-0">
                                <div class="row">
                                    <div class="col">
                                        <div class="form-floating fv-row">
                                            <input type="text"
                                                   class="form-control "
                                                   id="nif"
                                                   name="nif"
                                                   placeholder="Nº de pessoa coletiva"
                                                   value="{{$empresa['pcolectivaempresa']}}" required/>
                                            <label for="nif"
                                                   class="form-label">Nº de pessoa coletiva</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <label class="form-label"
                                       for="actividade">Atividade</label>
                                <textarea maxlength="5000" class="form-control"
                                          id="actividade" name="actividade"
                                          style="height: 100px" required></textarea>
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group-->
                            <div class="container-fluid container-no-sides mb-7 p-0">
                                <div class="row">
                                    <div class="col">
                                        <div class="form-floating fv-row">
                                            <input type="text"
                                                   class="form-control "
                                                   id="sede"
                                                   name="sede"
                                                   placeholder="Sede"
                                                   value="{{$empresa['moradaempresa']}}" required/>
                                            <label for="sede"
                                                   class="form-label">Sede</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group-->
                            <div class="container-fluid container-no-sides mb-7 p-0">
                                <div class="row">
                                    <div class="col">
                                        <div class="form-floating fv-row">
                                            <input type="text"
                                                   class="form-control "
                                                   id="url"
                                                   name="url"
                                                   placeholder="Endereço na Internet"
                                                   value="{{$empresa['urlempresa']}}" required/>
                                            <label for="url"
                                                   class="form-label">Endereço na Internet</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group-->
                            <div class="container-fluid container-no-sides mb-7 p-0">
                                <div class="row">
                                    <div class="col">
                                        <div class="form-floating fv-row">
                                            <input type="email"
                                                   class="form-control "
                                                   id="email"
                                                   name="email"
                                                   placeholder="Email geral de contacto"
                                                   value="{{$empresa['emailempresa']}}" required/>
                                            <label for="email"
                                                   class="form-label">Email geral de contacto</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group-->
                            <div class="container-fluid container-no-sides mb-7 p-0">
                                <div class="row">
                                    <div class="col">
                                        <div class="form-floating fv-row">
                                            <input type="tel"
                                                   class="form-control "
                                                   id="telefone"
                                                   name="telefone"
                                                   placeholder="Telefone"
                                                   value="{{$empresa['telefoneempresa']}}" required/>
                                            <label for="telefone"
                                                   class="form-label">Telefone</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group-->
                            <div class="container-fluid container-no-sides mb-7 p-0">
                                <div class="row">
                                    <div class="col">
                                        <div class="form-floating fv-row">
                                            <input readonly disabled
                                                   type="text"
                                                   class="form-control "
                                                   id="m_datepicker_1"
                                                   name="ddeclaracao"
                                                   placeholder="Data da declaração"
                                                   value="{{$empresa['datadeclaracao']}}" required/>
                                            <label for="ddeclaracao"
                                                   class="form-label">Data da declaração</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group-->
                            <div class=" fv-row rounded border mb-3 p-7 ">
                                <div class="form-check form-check-custom form-check-success form-check-solid form-check-lg">
                                    <input
                                            class="form-check-input"
                                            type="checkbox"
                                            id="cbdeclaracao"
                                            name="cbdeclaracao"
                                            @if($empresa['aceitadeclaracao']) checked @endif
                                    />

                                    <label
                                            class="form-check-label"
                                            for="cbdeclaracao">
                                        Declaro que esta informação é verdadeira para a elaboração do Acordo / Protocolo
                                        de Estágio com a Universidade de Coimbra
                                    </label>
                                </div>

                            </div>
                            <!--end::Input group-->
                        </div>
                        <!--begin::Actions-->
                        <div class="d-flex flex-stack">
                            <!--begin::Wrapper-->
                            <div>
                                <button type="submit" class="btn btn-primary mb-2" name="save" action="submit">
                                                        <span class="indicator-label">
                                                            Gravar
                                                        </span>
                                    <span class="indicator-progress">
                                                            Por favor aguarde... <span
                                                class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                                        </span>
                                </button>

                                <button type="reset" class="btn btn-secondary mb-2" action="cancel">
                                    Cancelar
                                </button>
                            </div>
                            <!--end::Wrapper-->
                        </div>
                        <!--end::Actions-->
                        <!--end::Step 1/2-->

                        <!--end::Group-->
                    </form>
                    <!--end::Form-->
                </div>
            </div>

        </div>
        <!--end::Form-->
    </div>
    <!--end::Card-->

    <!--begin::Card-->
    <div class="card mt-7">
        <div class="card-header p-5">
            <div class="card-title align-items-start col flex-column">
                <h3>
                    Administrador
                </h3>
            </div>


        </div>
        <!--begin::Form-->

        <div class="card-body">

            <div class="d-flex flex-column flex-xl-row end">

                <!--begin::Content-->
                <div class="flex-row-fluid">
                    <!--begin::Form-->
                    <form enctype="multipart/form-data" action="###" class="form" action="#" method="POST"
                          id="empresaForm">

                        <!--w-lg-500px-->

                        {{ csrf_field() }}
                        <!--begin::Group-->
                        <!--begin::Step 1-->
                        <div class="table-responsive">
                            <table class="table table-row-bordered">
                                <thead>
                                <tr class="fw-bold fs-6 text-gray-800">
                                    <th>Titulo</th>
                                    <th>Nome</th>
                                    <th>Cargo</th>
                                    <th>Email</th>
                                    <th>Contacto</th>
                                    <th>Estado</th>
                                    <th>Opções</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr id="rp_model-2">
                                    <td class="data-id">
                                        {{$empresa['tresponsavelempresa']}}
                                    </td>
                                    <td class="data-data">
                                        {{$empresa['responsavelempresa']}}
                                    </td>
                                    <td class="data-aluno">
                                        {{$empresa['cresponsavelempresa']}}
                                    </td>
                                    <td class="data-orientador">
                                        <a href="mailto:{{$empresa['emailempresa']}}">{{$empresa['emailempresa']}}</a>
                                    </td>
                                    <td class="data-titulo">
                                        {{$empresa['telefoneempresa']}}
                                    </td>
                                    <td class="data-estado">
                                        Activo
                                    </td>
                                    <td class="data-opcoes">
                                        <p data-toggle="tooltip" data-placement="top"
                                           title="Administrador registado no momento de registo da empresa, não pode ser alterado ou desactivado">
                                            Administrador registado no momento de registo da empresa, não pode ser
                                            alterado ou desactivado
                                        </p>
                                    </td>

                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <!--end::Step 1/2-->

                        <!--end::Group-->
                    </form>
                    <!--end::Form-->
                </div>
            </div>
        </div>

        <!--end::Form-->
    </div>
    <!--end::Card-->

    <!--begin::Card-->
    <div class="card mt-7">
        <div class="card-header p-5">
            <div class="card-title align-items-start col flex-column">
                <h3>
                    Representantes Legais
                </h3>
            </div>
            <div class="card-toolbar">
                <button type="reset" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#modal_rl">
                    Adicionar Representante Legal
                </button>
            </div>

        </div>
        <!--begin::Form-->

        <div class="card-body">

            <div class="d-flex flex-column flex-xl-row end">

                <!--begin::Content-->
                <div class="flex-row-fluid">
                    <!--begin::Form-->
                    <form enctype="multipart/form-data" action="###" class="form" action="#" method="POST"
                          id="empresaForm">

                        <!--w-lg-500px-->

                        {{ csrf_field() }}
                        <!--begin::Group-->
                        <!--begin::Step 1-->
                        <div class="table-responsive">
                            <table class="table table-row-bordered">
                                <thead>
                                <tr class="fw-bold fs-6 text-gray-800">
                                    <th>Titulo</th>
                                    <th>Nome</th>
                                    <th>Cargo</th>
                                    <th>Email</th>
                                    <th>Contacto</th>
                                    <th>Estado</th>
                                    <th>Opções</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($empresa['representantes'] as $es)
                                    <tr id="rp_model-2" representanteId="{{$es['id']}}">
                                        <th scope="row" class="data-id">
                                            {{$es['titulo']}}
                                        </th>
                                        <td class="data-data">
                                            {{$es['nome']}}
                                        </td>
                                        <td class="data-aluno">
                                            {{$es['cargo']}}
                                        </td>
                                        <td class="data-orientador">
                                            <a href="mailto:{{$es['email']}}">{{$es['email']}}</a>
                                        </td>
                                        <td class="data-titulo">
                                            {{$es['telefone']}}
                                        </td>
                                        <td class="data-estado">
                                            {{$es['estado']}}
                                        </td>
                                        <td class="data-opcoes">
                                            @if($es['activo']==1)
                                                <button name="representante-desactiva"
                                                        class="btn btn-primary"
                                                        data-toggle="modal"
                                                        onclick="javascript:return false;">
                                                    Desactivar
                                                </button>
                                            @else
                                                <button name="representante-activa"
                                                        class="btn btn-primary"
                                                        data-toggle="modal"
                                                        onclick="javascript:return false;">
                                                    Activar
                                                </button>
                                        @endif


                                        {{--                                            <button name="@if($es['activo']==1) representante-desactiva @else representante-activa @endif"--}}
                                        {{--                                                class="btn btn-primary"--}}
                                        {{--                                                data-toggle="modal"--}}
                                        {{--                                                onclick="javascript:return false;"> @if($es['activo']==1)Desativar @else Ativar @endif--}}
                                        {{--                                            </button>--}}
                                        {{--                                        </td>--}}
                                        <td class="data-opcoes-2">
                                            <button name="representante-recupera"
                                                    class="btn btn-primary" data-toggle="modal"
                                                    onclick="javascript:return false;">Recuperar password
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!--end::Step 1/2-->

                        <!--end::Group-->
                    </form>
                    <!--end::Form-->
                </div>
            </div>
            <div class="d-flex flex-column flex-xl-row end">
                <p>Representante Legal: Pessoas que podem representar legalmente a empresa,
                    utilizado para fins de assinatura de protocolos de estágio</p>
            </div>
        </div>

        <!--end::Form-->
    </div>
    <!--end::Card-->

    <!--begin::Card-->
    <div class="card mt-7">
        <div class="card-header p-5">
            <div class="card-title align-items-start col flex-column">
                <h3>Colaboradores</h3>
            </div>
            <div class="card-toolbar">
                <button type="reset" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#modal_colaborador">Adicionar Colaborador
                </button>
            </div>

        </div>
        <!--begin::Form-->
        <div class="card-body ">
            <div class="d-flex flex-column flex-xl-row end">

                <!--begin::Content-->
                <div class="flex-row-fluid">
                    <!--begin::Form-->
                    <form enctype="multipart/form-data" action="" class="form" action="#" method="POST"
                          id="empresaForm">

                        <!--w-lg-500px-->

                        {{ csrf_field() }}
                        <!--begin::Group-->

                        <!--begin::Step 1-->
                        <div class="table-responsive">
                            <table class="table table-row-bordered">
                                <thead>
                                <tr class="fw-bold fs-6 text-gray-800">
                                    <th hidden>ID</th>
                                    <th>Titulo</th>
                                    <th>Nome</th>
                                    <th>Cargo</th>
                                    <th>Email</th>
                                    <th>Contacto</th>
                                    <th>Estado</th>
                                    <th>Ações</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($empresa['colaboradores'] as $es)
                                    <tr id="rp_model-2" colaboradorId="{{$es['id']}}">
                                        <td class="data-id">
                                            {{$es['titulo']}}
                                        </td>
                                        <td hidden>
                                            {{$es['id']}}
                                        </td>
                                        <td class="data-data">
                                            {{$es['nome']}}
                                        </td>
                                        <td class="data-aluno">
                                            {{$es['cargo']}}
                                        </td>
                                        <td class="data-orientador">
                                            {{$es['email']}}
                                        </td>
                                        <td class="data-titulo">
                                            {{$es['telefone']}}
                                        </td>
                                        <td class="data-estado">
                                            {{$es['estado']}}
                                        </td>

                                        <td class="text-end sorting_1">
                                            <a href="#" class="btn btn-light btn-active-light-primary btn-sm"
                                               data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end"
                                               data-kt-menu-flip="top-end">
                                                Ações
                                                <span class="svg-icon svg-icon-5 m-0">
                                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                         width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <polygon points="0 0 24 0 24 24 0 24"></polygon>
                                            <path d="M6.70710678,15.7071068 C6.31658249,16.0976311 5.68341751,16.0976311 5.29289322,15.7071068 C4.90236893,15.3165825 4.90236893,14.6834175 5.29289322,14.2928932 L11.2928932,8.29289322 C11.6714722,7.91431428 12.2810586,7.90106866 12.6757246,8.26284586 L18.6757246,13.7628459 C19.0828436,14.1360383 19.1103465,14.7686056 18.7371541,15.1757246 C18.3639617,15.5828436 17.7313944,15.6103465 17.3242754,15.2371541 L12.0300757,10.3841378 L6.70710678,15.7071068 Z"
                                                  fill="currentColor" fill-rule="nonzero"
                                                  transform="translate(12.000003, 11.999999) rotate(-180.000000) translate(-12.000003, -11.999999)"></path>
                                        </g>
                                    </svg>
                                                </span>
                                            </a>
                                            <!--begin::Menu-->
                                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 py-4"
                                                 data-kt-menu="true" style="max-width: 200px;">
                                                <!--begin::Menu item-->
                                                <div class="menu-item px-3">
                                                    <a id="update_colab" data-colab-id="{{$es->id}}" class="menu-link px-3"
                                                       data-kt-docs-table-filter="see_row" data-bs-toggle="modal"
                                                       data-bs-target="#modal_colaboradorupdate">
                                                        Editar Dados
                                                    </a>
                                                </div>
                                                <!--end::Menu item-->
                                                <!--begin::Menu item-->
                                                <div class="menu-item px-3">
                                                    <a href="{{$es->getCVDownload()}}" download="{{str_replace(' ', '_', $es->nome)}}.pdf" class="menu-link px-3"
                                                       data-kt-docs-table-filter="see_row">
                                                        Download CV
                                                    </a>
                                                </div>
                                                <!--end::Menu item-->
                                                <!--begin::Menu item-->
                                                <div class="menu-item px-3">
                                                    @if($es['activo']==1)
                                                        <a id="colaborador-desactiva"
                                                                class="menu-link px-3"
                                                                data-toggle="modal"
                                                                onclick="javascript:return false;">
                                                            Desactivar
                                                        </a>
                                                    @else
                                                        <a id="colaborador-activa"
                                                                class="menu-link px-3"
                                                                data-toggle="modal"
                                                                onclick="javascript:return false;">
                                                            Activar
                                                        </a>
                                                    @endif
                                                </div>
                                                <div class="menu-item px-3">
                                                    <a id="colaborador-recupera"
                                                            class="menu-link px-3" data-toggle="modal"
                                                            onclick="javascript:return false;" style="text-align: left">Recuperar password</a>
                                                </div>
                                                <!--end::Menu item-->
                                            </div>
                                            <!--end::Menu-->
                                        </td>
{{--                                        <td class="data-opcoes">--}}
{{--                                        @if($es['activo']==1)--}}
{{--                                            <button name="colaborador-desactiva"--}}
{{--                                                    class="btn btn-primary"--}}
{{--                                                    data-toggle="modal"--}}
{{--                                                    onclick="javascript:return false;">--}}
{{--                                                Desactivar--}}
{{--                                            </button>--}}
{{--                                        @else--}}
{{--                                            <button name="colaborador-activa"--}}
{{--                                                    class="btn btn-primary"--}}
{{--                                                    data-toggle="modal"--}}
{{--                                                    onclick="javascript:return false;">--}}
{{--                                                Activar--}}
{{--                                            </button>--}}
{{--                                         @endif--}}
{{--                                         </td>--}}
{{--                                            <td class="data-opcoes">--}}
{{--                                                <button name="colaborador-recupera"--}}
{{--                                                        class="btn btn-primary" data-toggle="modal"--}}
{{--                                                        onclick="javascript:return false;">Recuperar--}}
{{--                                                    password--}}
{{--                                                </button>--}}
{{--                                            </td>--}}
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <br>
                        <!--end::Step 1/2-->

                        <!--end::Group-->
                    </form>
                    <!--end::Form-->
                </div>
            </div>
            <div class="d-flex flex-column flex-xl-row end">
                <div class="col-lg-12">
                    <p>Colaborador: pessoa que pode efectuar login na conta da empresa e efectuar
                        operações na plataforma</p>
                </div>
            </div>

        </div>
        <!--end::Form-->
    </div>
    <!--end::Card-->


    <!-- Button trigger modal -->


    <!-- Modal -->




    @include('metronicv815.layout.partials.modals.modalRepresentanteLegal')
    @include('metronicv815.layout.partials.modals.modalColaborador')
    @include('metronicv815.layout.partials.modals.modalColaboradorUpdate')

@stop

@section('scripts')
    {{--    <script src="{{asset('metronicv510/assets/demo/default/custom/components/forms/widgets/summernote.js')}}"--}}
    {{--            type="text/javascript"></script>--}}
    {{--    <script src="{{asset('metronicv510/assets/demo/default/custom/components/forms/widgets/bootstrap-datepicker.js')}}"--}}
    {{--            type="text/javascript"></script>--}}
    <script src="{{asset('js/empresa.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/representanteLegal.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/colaborador.js')}}" type="text/javascript"></script>
    <script src="{{asset('metronicv815/js/vendors/plugins/dropzone.init.js')}}" type="text/javascript"></script>
    <script type="text/javascript">

        $(document).ready(function () {
            Empresa.dadosEmpresa();

            var string = "{!! $empresa['actividadeempresa'] !!}";
            let temp = document.createElement('div');
            temp.innerHTML = string;
            string = temp.textContent;
            $('#actividade').val(string);
        });
    </script>

@stop