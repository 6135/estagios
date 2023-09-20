@extends('base.default')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/calendar.css') }}">
    <style>
        .dataTables_info {
            padding-top: 0em !important;
        }

        thead {
            border-bottom-width: 2px !important;
            border-bottom-style: none !important;
            border: none !important;
            border-width: none !important;

        }

        table.dataTable thead th {
            border-bottom: none;
        }

        table.dataTable tfoot th {
            border-top: none;
            border-bottom: 1px solid #111;
        }

        table.dataTable tbody tr:first-child td {
            padding-top: 1.5rem !important;
        }

        .table> :not(caption)>*>* {
            border-bottom-width: 2px !important;
        }

        tbody tr {
            font-size: 1.2rem;
        }
    </style>
@stop

@section('content')

    <div class="main-page row ">
        <div class="col-md px-0">
            <div class="card border-0 py-0 my-0">
                <div class="card-body py-0 my-0">
                    <!--begin::Wrapper-->
                    <div class="d-flex flex-stack flex-wrap mb-5">
                        <!--begin::Search-->
                        <div class="flex-grow-1 px-2">
                            <label for="tableSearch"
                                class="sub-header-text-7 mb-1 text-primary py-3">{{ __('words.search') }}</label>
                            <input id="tableSearch" type="text" class=" form-control--dei pb-1 ps-15 "
                                style="font-size: 1rem" />
                        </div>
                        <!--end::Search-->

                        <!--begin::Toolbar-->
                        <div class="px-2" data-kt-docs-table-toolbar="base">
                            <!--begin::Filter-->
                            <label for=""
                            class="sub-header-text-7 mb-1 text-primary py-3">{{ __('words.state') }}</label>
                            <div class="dropdown align-items-center px-0" style="padding-bottom: 0px">
                                <button id="dropdown-toggle-state"
                                    class="btn btn-outline-primary rounded-pill dropdown-toggle border-" type="button"
                                    data-bs-toggle="dropdown" aria-expanded="false"
                                    style="border-width: 2px; min-width: 150px; position: relative;">
                                    <span class="displayed-text">{{trans_choice('words.all',2)}}</span>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdown-toggle-state">
                                    <li><a class="dropdown-item" classes="btn btn-outline-primary rounded-pill dropdown-toggle" value="0" onclick="">{{ trans_choice('words.all',2) }}</a></li>

                                    <li><a class="dropdown-item" classes="btn btn-outline-primary text-white rounded-pill dropdown-toggle text-bg-primary " value="1" onclick="">{{ __('words.active') }}</a></li>
                                    <li><a class="dropdown-item" classes="btn btn-outline-secondary rounded-pill dropdown-toggle text-bg-secondary" value="2" onclick="">{{ __('words.not_confirmed') }}</a></li>
                                    <li><a class="dropdown-item" classes="btn btn-outline-dark rounded-pill dropdown-toggle text-bg-dark" value="3" onclick="">{{ __('words.inactive') }}</a></li>
                                </ul>
                            </div>
                            
                            <!--end::Filter-->


                            <!--end::Add customer-->
                        </div>
                        <div class="px-2 pt-5">
                            <!--begin::Add customer-->
                            <button type="button" class="btn btn-primary rounded-0 py-2" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRequestColaborador" aria-controls="offcanvas">
                                <span
                                    class="text-white body-text-2">+&nbsp;{{ trans_choice('words.new', 1) . ' ' . trans_choice('words.roles.EmpresaColaborador', 1) }}</span>
                            </button>
                        </div>
                        <!--end::Toolbar-->
                        <!--end::Group actions-->
                    </div>
                    <!--end::Wrapper-->
                    <div class="table-responsive-lg">
                        <table id="ColaboradoresTable" class="table table-row-bordered border-primary border-2 gy-5">
                            <thead class="dei-items ">
                                <tr class="fw-semibold fs-6 ">
                                    <th class="text-primary" id="Header.nome">{{ __('words.name') }}</th>
                                    <th class="text-primary" id="Header.email">{{ __('words.email') }}</th>
                                    <th class="text-primary" id="Header.position">{{ trans_choice('words.position', 1) }}
                                    </th>
                                    <th class="text-primary" id="Header.telefone">{{ __('words.phonenumber') }}</th>
                                    <th class="text-primary" id="Header.estado">{{ __('words.state') }}</th>
                                    <th class="text-primary" id="Header.roles">{{ trans_choice('words.role', 2) }}</th>
                                    <th class="text-primary" id="Header.action" style="min-width: 50px"></th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>

                        </table>
                    </div>

                </div>
            </div>

        </div>
    </div>

@stop

@section('offcanvas')
    @include('layouts.empresa.offcanvas-novo')
    @include('layouts.empresa.offcanvas-edit')
@stop

@section('scripts')
    <script>
        const editColaboratorOffcanvas = new bootstrap.Offcanvas("#offcanvasEditColaborator");
        // editColaboratorOffcanvas.show();
        const dataURL = "{{ route('empresa.colaboradores.json') }}";

        // $("#ColaboradoresTable").DataTable({
        //     dom: "<'row'<'col-sm-12 col-md-6'f><'col-sm-12 col-md-6'>>" +
        //         "<'row'<'col-sm-12'tr>>" +
        //         "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
        // });
        const locale = "{{ app()->getLocale() }}";
        const localizedMessages = {
            nome: {
                required: "{{ __('validation.required', ['attribute' => __('company.data.manager.name')]) }}",
                between: "{{ __('validation.between.string', ['attribute' => __('company.data.manager.name'), 'max' => 512, 'min' => 3]) }}",
            },
            email: {
                required: "{{ __('validation.required', ['attribute' => __('company.data.legalrep.email')]) }}",
                email: "{{ __('validation.email', ['attribute' => __('company.data.legalrep.email')]) }}",
                max: "{{ __('validation.max.string', ['attribute' => __('company.data.legalrep.email'), 'max' => 512]) }}",
            },
            changeState : {
                activate: "{{ __('words.activate') }}",
                deactivate: "{{ __('words.deactivate') }}",
            },
            edit: "{{ __('words.edit') }}",
            zeroRecords: "{{ __('words.zeroRecords') }}",
            infoEmpty: "{{ __('words.info') }}",
        }
        let editURL = "";
        let changeStateURL = "{{route('empresa.change.user.state')}}";
    </script>
    <script src="{{ asset('js/tables/colaboradoresTable.js') }}"></script>

    <script src="{{ asset('js/pages/empresa/requestColaboradores.js') }}" crossorigin="anonymous"></script>
    <script src="{{ asset('js/pages/empresa/editColaboradores.js') }}" crossorigin="anonymous"></script>

    <script>
        $("#dropdown-toggle").next(".dropdown-menu").children().on("click", function() {
            $(this).closest(".dropdown-menu").prev(".dropdown-toggle").children('.header-text-3').html($(this)
                .text());

        });


        function setFilterStateBadge(state) {
            $('#filterStateBadge').html(state);
        }

        function changeFormAction(route) {
            $('#requestGestorForm').attr('action', route);
        }
    </script>
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
