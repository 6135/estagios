{{-- @extends('metronicv815.base.default') --}}

{{-- @section('content') --}}
<div class="card card-mobile mt-5">
    <div class="card-header">
        <div class="card-title">
            <h3 class="card-title align-items-start flex-column">
                Lista de estágios
            </h3>
        </div>
    </div>
    <div class="card-body">
        <!--begin: Search Form -->
        <!--begin::Wrapper-->
        <div class="d-flex flex-stack flex-wrap mb-5">
            <!--begin::Search-->
            <div class="d-flex align-items-center position-relative my-1 mb-2 mb-md-0">
                <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                <span class="svg-icon svg-icon-1 position-absolute ms-6">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1"
                            transform="rotate(45 17.0365 15.1223)" fill="currentColor"></rect>
                        <path
                            d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                            fill="currentColor"></path>
                    </svg>
                </span>
                <!--end::Svg Icon-->
                <input type="text" data-kt-docs-table-filter="search" class="form-control form-control-solid ps-15"
                    placeholder="Procurar por titulo" style="max-width: 250px">
            </div>
            <!--end::Search-->

            <!--begin::Toolbar-->
            <div class="d-flex flex-wrap justify-content-end" data-kt-docs-table-toolbar="base">
                <!--begin::Filter-->
                <button type="button" class="btn btn-light-primary me-3 mb-2" data-kt-menu-trigger="click"
                    data-kt-menu-placement="bottom-end">
                    <!--begin::Svg Icon | path: icons/duotune/general/gen031.svg-->
                    <span class="svg-icon svg-icon-2">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M19.0759 3H4.72777C3.95892 3 3.47768 3.83148 3.86067 4.49814L8.56967 12.6949C9.17923 13.7559 9.5 14.9582 9.5 16.1819V19.5072C9.5 20.2189 10.2223 20.7028 10.8805 20.432L13.8805 19.1977C14.2553 19.0435 14.5 18.6783 14.5 18.273V13.8372C14.5 12.8089 14.8171 11.8056 15.408 10.964L19.8943 4.57465C20.3596 3.912 19.8856 3 19.0759 3Z"
                                fill="currentColor"></path>
                        </svg>
                    </span>
                    <!--end::Svg Icon-->Filtro
                </button>
                <!--begin::Menu 1-->
                <div class="menu menu-sub menu-sub-dropdown" data-kt-menu="true" id="kt-toolbar-filter" style="">
                    <!--begin::Header-->
                    <div class="px-7 py-5">
                        <div class="fs-4 text-dark fw-bold">Filter Options</div>
                    </div>
                    <!--end::Header-->
                    <!--begin::Separator-->
                    <div class="separator border-gray-200"></div>
                    <!--end::Separator-->
                    <!--begin::Content-->
                    <div class="px-7 py-5">
                        <!--begin::Input group-->
                        <div class="mb-10">
                            <!--begin::Label-->
                            <label class="form-label fs-5 fw-semibold mb-3">Estado:</label>
                            <!--end::Label-->
                            <!--begin::Options-->
                            <div class="d-flex flex-column flex-wrap fw-semibold"
                                data-kt-docs-table-filter="state_type">
                                <!--begin::Option-->
                                <label class="form-check form-check-sm form-check-custom form-check-solid mb-3 me-5">
                                    <input class="form-check-input" type="radio" name="state_type" value="all"
                                        checked="checked">
                                    <span class="form-check-label text-gray-600">Todos</span>
                                </label>
                                <!--end::Option-->
                                <!--begin::Option-->
                                <label class="form-check form-check-sm form-check-custom form-check-solid mb-3 me-5">
                                    <input class="form-check-input" type="radio" name="state_type" value="novo">
                                    <span class="form-check-label text-gray-600">Novo</span>
                                </label>
                                <!--end::Option-->
                                <!--begin::Option-->
                                <label class="form-check form-check-sm form-check-custom form-check-solid mb-3 me-5">
                                    <input class="form-check-input" type="radio" name="state_type" value="aguarda">
                                    <span class="form-check-label text-gray-600">Aguarda revisão da coordenação de
                                        curso</span>
                                </label>
                                <!--end::Option-->
                                <!--begin::Option-->
                                <label class="form-check form-check-sm form-check-custom form-check-solid mb-3 me-5">
                                    <input class="form-check-input" type="radio" name="state_type" value="aprovado">
                                    <span class="form-check-label text-gray-600">Aprovado</span>
                                </label>
                                <!--end::Option-->
                            </div>
                            <!--end::Options-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Actions-->
                        <div class="d-flex justify-content-end">
                            <button type="reset" class="btn btn-light btn-active-light-primary me-2"
                                data-kt-menu-dismiss="true" data-kt-docs-table-filter="reset">Reset
                            </button>
                            <button type="submit" class="btn btn-primary" data-kt-menu-dismiss="true"
                                data-kt-docs-table-filter="filter">Apply
                            </button>
                        </div>
                        <!--end::Actions-->
                    </div>
                    <!--end::Content-->
                </div>
                <!--end::Menu 1-->
                <!--end::Filter-->
                <!--begin::Novo Estagio-->
                <a href="{{ route('newProposta') }}" type="button" class="btn btn-primary mb-2"
                    data-bs-toggle="tooltip" data-bs-original-title="Coming Soon" data-kt-initialized="1">
                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr075.svg-->
                    <span class="svg-icon svg-icon-2">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2"
                                rx="1" transform="rotate(-90 11.364 20.364)" fill="currentColor"></rect>
                            <rect x="4.36396" y="11.364" width="16" height="2" rx="1"
                                fill="currentColor"></rect>
                        </svg>
                    </span>
                    <!--end::Svg Icon-->Novo Estagio
                </a>
                <!--end::Novo Estagio-->
            </div>
            <!--end::Toolbar-->

            <!--begin::Group actions-->
            <div class="d-flex justify-content-end align-items-center d-none" data-kt-docs-table-toolbar="selected">
                <div class="fw-bold me-5">
                    <span class="me-2" data-kt-docs-table-select="selected_count"></span> Selected
                </div>

                <button type="button" class="btn btn-danger" data-bs-toggle="tooltip" title="Coming Soon">
                    Selection Action
                </button>
            </div>
            <!--end::Group actions-->
        </div>
        <!--end::Wrapper-->

        <!--begin::Datatable-->
        <table id="kt_datatable_estagios" class="table align-middle table-row-dashed fs-6 gy-5">
            <thead>
                <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                    <th style="min-width: 75px">Código &nbsp;</th>
                    <th>Titulo</th>
                    <th>Orientadores</th>
                    <th>Aluno Atribuido</th>
                    <th>Estado</th>
                    <th># Candidatos</th>
                    <th class="min-w-100px">Ações</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 fw-semibold">
            </tbody>
        </table>
        <!--end::Datatable-->
        <!--begin: Datatable -->
        <div class="m_datatable" id="ajax_data"></div>
        <!--end: Datatable -->
    </div>
</div>
{{-- @stop --}}

{{-- @section('scripts') --}}
{{--    <script> --}}
{{--        var tableActionURL = "{{$tableActionURL}}"; --}}
{{--        var compareAction = "{{$compareAction}}"; --}}
{{--    </script> --}}
{{--    <script src="{{asset('js/data-ajax-estagios2.js')}}" type="text/javascript"></script> --}}
{{-- @stop --}}
