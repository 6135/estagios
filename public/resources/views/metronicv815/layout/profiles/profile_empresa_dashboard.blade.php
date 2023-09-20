@extends('metronicv815.base.default')

@section('content')
    {{-- @include('metronicv815.layout.partials.messageCard') --}}
    @include('metronicv815.layout.estagios.estagiosTable')
{{--    <div class="app-main flex-column flex-row-fluid " id="kt_app_main">--}}

{{--        <!--Begin::Section-->--}}
{{--        <div class="card mt-5" style="min-width:90%">--}}
{{--            <!--begin::Modal content-->--}}

{{--            <!--begin::Modal header-->--}}
{{--            <div class="card-header p-5">--}}
{{--                <!--begin::Modal title-->--}}
{{--                <h3 class="card-title align-items-start flex-column"> Estágios Recentes</h3>--}}
{{--                <!--end::Modal title-->--}}
{{--                <div class="card-toolbar">--}}
{{--                    <ul class="nav" id="kt_chart_widget_8_tabs" role="tablist">--}}
{{--                        <li class="nav-item" role="presentation">--}}
{{--                            <a class="nav-link btn btn-sm btn-color-muted btn-active btn-active-light fw-bold px-4 me-1" data-bs-toggle="tab" id="kt_chart_widget_8_week_toggle" href="#kt_chart_widget_8_week_tab" aria-selected="false" role="tab" tabindex="-1">Month</a>--}}
{{--                        </li>--}}
{{--                        <li class="nav-item" role="presentation">--}}
{{--                            <a class="nav-link btn btn-sm btn-color-muted btn-active btn-active-light fw-bold px-4 me-1 active" data-bs-toggle="tab" id="kt_chart_widget_8_month_toggle" href="#kt_chart_widget_8_month_tab" aria-selected="true" role="tab">Week</a>--}}
{{--                        </li>--}}
{{--                    </ul>--}}
{{--                    <ul class="nav" id="kt_chart_widget_8_tabs" role="tablist">--}}
{{--                        <li class="nav-item" role="presentation">--}}
{{--                            <a class="nav-link btn btn-sm btn-color-muted btn-active btn-active-light fw-bold px-4 me-1 active" data-bs-toggle="tab" id="kt_chart_widget_8_week_toggle" href="#kt_chart_widget_8_week_tab" aria-selected="true" role="tab">--}}
{{--                                Estagios--}}
{{--                            </a>--}}
{{--                        </li>--}}
{{--                        <li class="nav-item" role="presentation">--}}
{{--                            <a class="nav-link btn btn-sm btn-color-muted btn-active btn-active-light fw-bold px-4 me-1" data-bs-toggle="tab" id="kt_chart_widget_8_month_toggle" href="#kt_chart_widget_8_month_tab" aria-selected="false" role="tab" tabindex="-1">--}}
{{--                                Submetidos--}}
{{--                            </a>--}}
{{--                        </li>--}}
{{--                    </ul>--}}

{{--                </div>--}}
{{--            </div>--}}

{{--            <div class="card-body">--}}
{{--                <div class="scroll scroll-pull" data-scroll="true" data-wheel-propagation="true" style="max-height: 600px">--}}
{{--                    <div class="timeline timeline-1">--}}
{{--                        @foreach ($ultimosestagiosnovos as $ue)--}}
{{--                            <div class="timeline-item">--}}
{{--                                <div class="timeline-line w-40px"></div>--}}
{{--                                <div class="timeline-icon symbol symbol-circle symbol-40px">--}}
{{--                                    <div class="symbol-label bg-light">--}}
{{--                                        <!--begin::Svg Icon | path: icons/duotune/communication/com009.svg-->--}}
{{--                                        <span class="svg-icon svg-icon-2 svg-icon-gray-500">--}}
{{--																		<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">--}}
{{--																			<path opacity="0.3" d="M5.78001 21.115L3.28001 21.949C3.10897 22.0059 2.92548 22.0141 2.75004 21.9727C2.57461 21.9312 2.41416 21.8418 2.28669 21.7144C2.15923 21.5869 2.06975 21.4264 2.0283 21.251C1.98685 21.0755 1.99507 20.892 2.05201 20.7209L2.886 18.2209L7.22801 13.879L10.128 16.774L5.78001 21.115Z" fill="currentColor"></path>--}}
{{--																			<path d="M21.7 8.08899L15.911 2.30005C15.8161 2.2049 15.7033 2.12939 15.5792 2.07788C15.455 2.02637 15.3219 1.99988 15.1875 1.99988C15.0531 1.99988 14.92 2.02637 14.7958 2.07788C14.6717 2.12939 14.5589 2.2049 14.464 2.30005L13.74 3.02295C13.548 3.21498 13.4402 3.4754 13.4402 3.74695C13.4402 4.01849 13.548 4.27892 13.74 4.47095L14.464 5.19397L11.303 8.35498C10.1615 7.80702 8.87825 7.62639 7.62985 7.83789C6.38145 8.04939 5.2293 8.64265 4.332 9.53601C4.14026 9.72817 4.03256 9.98855 4.03256 10.26C4.03256 10.5315 4.14026 10.7918 4.332 10.984L13.016 19.667C13.208 19.859 13.4684 19.9668 13.74 19.9668C14.0115 19.9668 14.272 19.859 14.464 19.667C15.3575 18.77 15.9509 17.618 16.1624 16.3698C16.374 15.1215 16.1932 13.8383 15.645 12.697L18.806 9.53601L19.529 10.26C19.721 10.452 19.9814 10.5598 20.253 10.5598C20.5245 10.5598 20.785 10.452 20.977 10.26L21.7 9.53601C21.7952 9.44108 21.8706 9.32825 21.9221 9.2041C21.9737 9.07995 22.0002 8.94691 22.0002 8.8125C22.0002 8.67809 21.9737 8.54505 21.9221 8.4209C21.8706 8.29675 21.7952 8.18392 21.7 8.08899Z" fill="currentColor"></path>--}}
{{--																		</svg>--}}
{{--																	</span>--}}
{{--                                        <!--end::Svg Icon-->--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="timeline-content mb-10 mt-n1">--}}
{{--                                    <!--begin::Timeline heading-->--}}
{{--                                    <div class="pe-3 mb-5">--}}
{{--                                        <!--begin::Title-->--}}

{{--                                        <div class="fs-5 fw-semibold mb-2">--}}
{{--                                            <a href="/estagios/propostas/nova/{{$ue->idestagio}}">({{$ue->created}}) : {{$ue->tituloestagio or 'SEM TÍTULO DEFINIDO'}}</a>--}}
{{--                                            <div class="min-w-125px pe-2">--}}
{{--                                                <span class="badge badge-{{$ue->estado['badge']}}">{{$ue->estado['text']}}</span>--}}
{{--                                            </div>--}}

{{--                                        </div>--}}
{{--                                        <!--end::Title-->--}}
{{--                                    </div>--}}
{{--                                    <!--end::Timeline heading-->--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        @endforeach--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}


{{--        </div>--}}

{{--        <!--begin::Timeline widget 3-->--}}
{{--        <div class="card mt-5 ">--}}
{{--            <!--begin::Header-->--}}
{{--            <div class="card-header border-0 pt-5">--}}
{{--                <h3 class="card-title align-items-start flex-column">--}}
{{--                    <span class="card-label fw-bold text-dark">Calendario</span>--}}
{{--                    <span class="text-muted mt-1 fw-semibold fs-7">16 Tarefas</span>--}}
{{--                </h3>--}}
{{--                <!--begin::Toolbar-->--}}
{{--                <!--end::Toolbar-->--}}
{{--            </div>--}}
{{--            <!--end::Header-->--}}
{{--            <!--begin::Body-->--}}
{{--            <div class="card-body pt-7 px-0">--}}
{{--                <!--begin::Nav-->--}}
{{--                <ul class="nav nav-stretch nav-pills nav-pills-custom nav-pills-active-custom d-flex justify-content-between mb-8 px-5" role="tablist">--}}
{{--                    <!--begin::Nav item-->--}}
{{--                    <li class="nav-item p-0 ms-0" role="presentation">--}}
{{--                        <!--begin::Date-->--}}
{{--                        <a class="nav-link btn d-flex flex-column flex-center rounded-pill min-w-45px py-4 px-3 btn-active-danger" data-bs-toggle="tab" href="#kt_timeline_widget_3_tab_content_1" aria-selected="false" tabindex="-1" role="tab">--}}
{{--                            <span class="fs-7 fw-semibold">Fr</span>--}}
{{--                            <span class="fs-6 fw-bold">20</span>--}}
{{--                        </a>--}}
{{--                        <!--end::Date-->--}}
{{--                    </li>--}}
{{--                    <!--end::Nav item-->--}}
{{--                    <!--begin::Nav item-->--}}
{{--                    <li class="nav-item p-0 ms-0" role="presentation">--}}
{{--                        <!--begin::Date-->--}}
{{--                        <a class="nav-link btn d-flex flex-column flex-center rounded-pill min-w-45px py-4 px-3 btn-active-danger" data-bs-toggle="tab" href="#kt_timeline_widget_3_tab_content_2" aria-selected="false" tabindex="-1" role="tab">--}}
{{--                            <span class="fs-7 fw-semibold">Sa</span>--}}
{{--                            <span class="fs-6 fw-bold">21</span>--}}
{{--                        </a>--}}
{{--                        <!--end::Date-->--}}
{{--                    </li>--}}
{{--                    <!--end::Nav item-->--}}
{{--                    <!--begin::Nav item-->--}}
{{--                    <li class="nav-item p-0 ms-0" role="presentation">--}}
{{--                        <!--begin::Date-->--}}
{{--                        <a class="nav-link btn d-flex flex-column flex-center rounded-pill min-w-45px py-4 px-3 btn-active-danger" data-bs-toggle="tab" href="#kt_timeline_widget_3_tab_content_3" aria-selected="false" tabindex="-1" role="tab">--}}
{{--                            <span class="fs-7 fw-semibold">Su</span>--}}
{{--                            <span class="fs-6 fw-bold">22</span>--}}
{{--                        </a>--}}
{{--                        <!--end::Date-->--}}
{{--                    </li>--}}
{{--                    <!--end::Nav item-->--}}
{{--                    <!--begin::Nav item-->--}}
{{--                    <li class="nav-item p-0 ms-0" role="presentation">--}}
{{--                        <!--begin::Date-->--}}
{{--                        <a class="nav-link btn d-flex flex-column flex-center rounded-pill min-w-45px py-4 px-3 btn-active-danger active" data-bs-toggle="tab" href="#kt_timeline_widget_3_tab_content_4" aria-selected="true" role="tab">--}}
{{--                            <span class="fs-7 fw-semibold">Tu</span>--}}
{{--                            <span class="fs-6 fw-bold">23</span>--}}
{{--                        </a>--}}
{{--                        <!--end::Date-->--}}
{{--                    </li>--}}
{{--                    <!--end::Nav item-->--}}
{{--                    <!--begin::Nav item-->--}}
{{--                    <li class="nav-item p-0 ms-0" role="presentation">--}}
{{--                        <!--begin::Date-->--}}
{{--                        <a class="nav-link btn d-flex flex-column flex-center rounded-pill min-w-45px py-4 px-3 btn-active-danger" data-bs-toggle="tab" href="#kt_timeline_widget_3_tab_content_5" aria-selected="false" tabindex="-1" role="tab">--}}
{{--                            <span class="fs-7 fw-semibold">Tu</span>--}}
{{--                            <span class="fs-6 fw-bold">24</span>--}}
{{--                        </a>--}}
{{--                        <!--end::Date-->--}}
{{--                    </li>--}}
{{--                    <!--end::Nav item-->--}}
{{--                    <!--begin::Nav item-->--}}
{{--                    <li class="nav-item p-0 ms-0" role="presentation">--}}
{{--                        <!--begin::Date-->--}}
{{--                        <a class="nav-link btn d-flex flex-column flex-center rounded-pill min-w-45px py-4 px-3 btn-active-danger" data-bs-toggle="tab" href="#kt_timeline_widget_3_tab_content_6" aria-selected="false" tabindex="-1" role="tab">--}}
{{--                            <span class="fs-7 fw-semibold">We</span>--}}
{{--                            <span class="fs-6 fw-bold">25</span>--}}
{{--                        </a>--}}
{{--                        <!--end::Date-->--}}
{{--                    </li>--}}
{{--                    <!--end::Nav item-->--}}
{{--                    <!--begin::Nav item-->--}}
{{--                    <li class="nav-item p-0 ms-0" role="presentation">--}}
{{--                        <!--begin::Date-->--}}
{{--                        <a class="nav-link btn d-flex flex-column flex-center rounded-pill min-w-45px py-4 px-3 btn-active-danger" data-bs-toggle="tab" href="#kt_timeline_widget_3_tab_content_7" aria-selected="false" tabindex="-1" role="tab">--}}
{{--                            <span class="fs-7 fw-semibold">Th</span>--}}
{{--                            <span class="fs-6 fw-bold">26</span>--}}
{{--                        </a>--}}
{{--                        <!--end::Date-->--}}
{{--                    </li>--}}
{{--                    <!--end::Nav item-->--}}
{{--                    <!--begin::Nav item-->--}}
{{--                    <li class="nav-item p-0 ms-0" role="presentation">--}}
{{--                        <!--begin::Date-->--}}
{{--                        <a class="nav-link btn d-flex flex-column flex-center rounded-pill min-w-45px py-4 px-3 btn-active-danger" data-bs-toggle="tab" href="#kt_timeline_widget_3_tab_content_8" aria-selected="false" tabindex="-1" role="tab">--}}
{{--                            <span class="fs-7 fw-semibold">Fri</span>--}}
{{--                            <span class="fs-6 fw-bold">27</span>--}}
{{--                        </a>--}}
{{--                        <!--end::Date-->--}}
{{--                    </li>--}}
{{--                    <!--end::Nav item-->--}}
{{--                    <!--begin::Nav item-->--}}
{{--                    <li class="nav-item p-0 ms-0" role="presentation">--}}
{{--                        <!--begin::Date-->--}}
{{--                        <a class="nav-link btn d-flex flex-column flex-center rounded-pill min-w-45px py-4 px-3 btn-active-danger" data-bs-toggle="tab" href="#kt_timeline_widget_3_tab_content_9" aria-selected="false" tabindex="-1" role="tab">--}}
{{--                            <span class="fs-7 fw-semibold">Sa</span>--}}
{{--                            <span class="fs-6 fw-bold">28</span>--}}
{{--                        </a>--}}
{{--                        <!--end::Date-->--}}
{{--                    </li>--}}
{{--                    <!--end::Nav item-->--}}
{{--                    <!--begin::Nav item-->--}}
{{--                    <li class="nav-item p-0 ms-0" role="presentation">--}}
{{--                        <!--begin::Date-->--}}
{{--                        <a class="nav-link btn d-flex flex-column flex-center rounded-pill min-w-45px py-4 px-3 btn-active-danger" data-bs-toggle="tab" href="#kt_timeline_widget_3_tab_content_10" aria-selected="false" tabindex="-1" role="tab">--}}
{{--                            <span class="fs-7 fw-semibold">Su</span>--}}
{{--                            <span class="fs-6 fw-bold">29</span>--}}
{{--                        </a>--}}
{{--                        <!--end::Date-->--}}
{{--                    </li>--}}
{{--                    <!--end::Nav item-->--}}
{{--                    <!--begin::Nav item-->--}}
{{--                    <li class="nav-item p-0 ms-0" role="presentation">--}}
{{--                        <!--begin::Date-->--}}
{{--                        <a class="nav-link btn d-flex flex-column flex-center rounded-pill min-w-45px py-4 px-3 btn-active-danger" data-bs-toggle="tab" href="#kt_timeline_widget_3_tab_content_11" aria-selected="false" tabindex="-1" role="tab">--}}
{{--                            <span class="fs-7 fw-semibold">Mo</span>--}}
{{--                            <span class="fs-6 fw-bold">30</span>--}}
{{--                        </a>--}}
{{--                        <!--end::Date-->--}}
{{--                    </li>--}}
{{--                    <!--end::Nav item-->--}}
{{--                </ul>--}}
{{--                <!--end::Nav-->--}}
{{--                <!--begin::Tab Content (ishlamayabdi)-->--}}
{{--                <div class="tab-content mb-2 px-9">--}}
{{--                    <!--begin::Tap pane-->--}}
{{--                    <div class="tab-pane fade" id="kt_timeline_widget_3_tab_content_1" role="tabpanel">--}}
{{--                        <!--begin::Wrapper-->--}}
{{--                        <div class="d-flex align-items-center mb-6">--}}
{{--                            <!--begin::Bullet-->--}}
{{--                            <span data-kt-element="bullet" class="bullet bullet-vertical d-flex align-items-center min-h-70px mh-100 me-4 bg-success"></span>--}}
{{--                            <!--end::Bullet-->--}}
{{--                            <!--begin::Info-->--}}
{{--                            <div class="flex-grow-1 me-5">--}}
{{--                                <!--begin::Time-->--}}
{{--                                <div class="text-gray-800 fw-semibold fs-2">10:20 - 11:00--}}
{{--                                    <span class="text-gray-400 fw-semibold fs-7">AM</span></div>--}}
{{--                                <!--end::Time-->--}}
{{--                                <!--begin::Description-->--}}
{{--                                <div class="text-gray-700 fw-semibold fs-6">9 Degree Project Estimation Meeting</div>--}}
{{--                                <!--end::Description-->--}}
{{--                                <!--begin::Link-->--}}
{{--                                <div class="text-gray-400 fw-semibold fs-7">Lead by--}}
{{--                                    <!--begin::Name-->--}}
{{--                                    <a href="#" class="text-primary opacity-75-hover fw-semibold">Peter Marcus</a>--}}
{{--                                    <!--end::Name--></div>--}}
{{--                                <!--end::Link-->--}}
{{--                            </div>--}}
{{--                            <!--end::Info-->--}}
{{--                            <!--begin::Action-->--}}
{{--                            <a href="#" class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#kt_modal_create_project">View</a>--}}
{{--                            <!--end::Action-->--}}
{{--                        </div>--}}
{{--                        <!--end::Wrapper-->--}}
{{--                        <!--begin::Wrapper-->--}}
{{--                        <div class="d-flex align-items-center mb-6">--}}
{{--                            <!--begin::Bullet-->--}}
{{--                            <span data-kt-element="bullet" class="bullet bullet-vertical d-flex align-items-center min-h-70px mh-100 me-4 bg-warning"></span>--}}
{{--                            <!--end::Bullet-->--}}
{{--                            <!--begin::Info-->--}}
{{--                            <div class="flex-grow-1 me-5">--}}
{{--                                <!--begin::Time-->--}}
{{--                                <div class="text-gray-800 fw-semibold fs-2">12:00 - 13:40--}}
{{--                                    <span class="text-gray-400 fw-semibold fs-7">AM</span></div>--}}
{{--                                <!--end::Time-->--}}
{{--                                <!--begin::Description-->--}}
{{--                                <div class="text-gray-700 fw-semibold fs-6">Dashboard UI/UX Design Review</div>--}}
{{--                                <!--end::Description-->--}}
{{--                                <!--begin::Link-->--}}
{{--                                <div class="text-gray-400 fw-semibold fs-7">Lead by--}}
{{--                                    <!--begin::Name-->--}}
{{--                                    <a href="#" class="text-primary opacity-75-hover fw-semibold">Lead by Bob</a>--}}
{{--                                    <!--end::Name--></div>--}}
{{--                                <!--end::Link-->--}}
{{--                            </div>--}}
{{--                            <!--end::Info-->--}}
{{--                            <!--begin::Action-->--}}
{{--                            <a href="#" class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#kt_modal_create_project">View</a>--}}
{{--                            <!--end::Action-->--}}
{{--                        </div>--}}
{{--                        <!--end::Wrapper-->--}}
{{--                        <!--begin::Wrapper-->--}}
{{--                        <div class="d-flex align-items-center mb-6">--}}
{{--                            <!--begin::Bullet-->--}}
{{--                            <span data-kt-element="bullet" class="bullet bullet-vertical d-flex align-items-center min-h-70px mh-100 me-4 bg-info"></span>--}}
{{--                            <!--end::Bullet-->--}}
{{--                            <!--begin::Info-->--}}
{{--                            <div class="flex-grow-1 me-5">--}}
{{--                                <!--begin::Time-->--}}
{{--                                <div class="text-gray-800 fw-semibold fs-2">16:30 - 17:00--}}
{{--                                    <span class="text-gray-400 fw-semibold fs-7">PM</span></div>--}}
{{--                                <!--end::Time-->--}}
{{--                                <!--begin::Description-->--}}
{{--                                <div class="text-gray-700 fw-semibold fs-6">Marketing Campaign Discussion</div>--}}
{{--                                <!--end::Description-->--}}
{{--                                <!--begin::Link-->--}}
{{--                                <div class="text-gray-400 fw-semibold fs-7">Lead by--}}
{{--                                    <!--begin::Name-->--}}
{{--                                    <a href="#" class="text-primary opacity-75-hover fw-semibold">Lead by Mark Morris</a>--}}
{{--                                    <!--end::Name--></div>--}}
{{--                                <!--end::Link-->--}}
{{--                            </div>--}}
{{--                            <!--end::Info-->--}}
{{--                            <!--begin::Action-->--}}
{{--                            <a href="#" class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#kt_modal_create_project">View</a>--}}
{{--                            <!--end::Action-->--}}
{{--                        </div>--}}
{{--                        <!--end::Wrapper-->--}}
{{--                    </div>--}}
{{--                    <!--end::Tap pane-->--}}
{{--                    <!--begin::Tap pane-->--}}
{{--                    <div class="tab-pane fade" id="kt_timeline_widget_3_tab_content_2" role="tabpanel">--}}
{{--                        <!--begin::Wrapper-->--}}
{{--                        <div class="d-flex align-items-center mb-6">--}}
{{--                            <!--begin::Bullet-->--}}
{{--                            <span data-kt-element="bullet" class="bullet bullet-vertical d-flex align-items-center min-h-70px mh-100 me-4 bg-warning"></span>--}}
{{--                            <!--end::Bullet-->--}}
{{--                            <!--begin::Info-->--}}
{{--                            <div class="flex-grow-1 me-5">--}}
{{--                                <!--begin::Time-->--}}
{{--                                <div class="text-gray-800 fw-semibold fs-2">16:30 - 17:00--}}
{{--                                    <span class="text-gray-400 fw-semibold fs-7">PM</span></div>--}}
{{--                                <!--end::Time-->--}}
{{--                                <!--begin::Description-->--}}
{{--                                <div class="text-gray-700 fw-semibold fs-6">Marketing Campaign Discussion</div>--}}
{{--                                <!--end::Description-->--}}
{{--                                <!--begin::Link-->--}}
{{--                                <div class="text-gray-400 fw-semibold fs-7">Lead by--}}
{{--                                    <!--begin::Name-->--}}
{{--                                    <a href="#" class="text-primary opacity-75-hover fw-semibold">Lead by Mark Morris</a>--}}
{{--                                    <!--end::Name--></div>--}}
{{--                                <!--end::Link-->--}}
{{--                            </div>--}}
{{--                            <!--end::Info-->--}}
{{--                            <!--begin::Action-->--}}
{{--                            <a href="#" class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#kt_modal_create_project">View</a>--}}
{{--                            <!--end::Action-->--}}
{{--                        </div>--}}
{{--                        <!--end::Wrapper-->--}}
{{--                        <!--begin::Wrapper-->--}}
{{--                        <div class="d-flex align-items-center mb-6">--}}
{{--                            <!--begin::Bullet-->--}}
{{--                            <span data-kt-element="bullet" class="bullet bullet-vertical d-flex align-items-center min-h-70px mh-100 me-4 bg-info"></span>--}}
{{--                            <!--end::Bullet-->--}}
{{--                            <!--begin::Info-->--}}
{{--                            <div class="flex-grow-1 me-5">--}}
{{--                                <!--begin::Time-->--}}
{{--                                <div class="text-gray-800 fw-semibold fs-2">12:00 - 13:40--}}
{{--                                    <span class="text-gray-400 fw-semibold fs-7">AM</span></div>--}}
{{--                                <!--end::Time-->--}}
{{--                                <!--begin::Description-->--}}
{{--                                <div class="text-gray-700 fw-semibold fs-6">9 Degree Project Estimation Meeting</div>--}}
{{--                                <!--end::Description-->--}}
{{--                                <!--begin::Link-->--}}
{{--                                <div class="text-gray-400 fw-semibold fs-7">Lead by--}}
{{--                                    <!--begin::Name-->--}}
{{--                                    <a href="#" class="text-primary opacity-75-hover fw-semibold">Peter Marcus</a>--}}
{{--                                    <!--end::Name--></div>--}}
{{--                                <!--end::Link-->--}}
{{--                            </div>--}}
{{--                            <!--end::Info-->--}}
{{--                            <!--begin::Action-->--}}
{{--                            <a href="#" class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#kt_modal_create_project">View</a>--}}
{{--                            <!--end::Action-->--}}
{{--                        </div>--}}
{{--                        <!--end::Wrapper-->--}}
{{--                        <!--begin::Wrapper-->--}}
{{--                        <div class="d-flex align-items-center mb-6">--}}
{{--                            <!--begin::Bullet-->--}}
{{--                            <span data-kt-element="bullet" class="bullet bullet-vertical d-flex align-items-center min-h-70px mh-100 me-4 bg-success"></span>--}}
{{--                            <!--end::Bullet-->--}}
{{--                            <!--begin::Info-->--}}
{{--                            <div class="flex-grow-1 me-5">--}}
{{--                                <!--begin::Time-->--}}
{{--                                <div class="text-gray-800 fw-semibold fs-2">10:20 - 11:00--}}
{{--                                    <span class="text-gray-400 fw-semibold fs-7">AM</span></div>--}}
{{--                                <!--end::Time-->--}}
{{--                                <!--begin::Description-->--}}
{{--                                <div class="text-gray-700 fw-semibold fs-6">9 Degree Project Estimation Meeting</div>--}}
{{--                                <!--end::Description-->--}}
{{--                                <!--begin::Link-->--}}
{{--                                <div class="text-gray-400 fw-semibold fs-7">Lead by--}}
{{--                                    <!--begin::Name-->--}}
{{--                                    <a href="#" class="text-primary opacity-75-hover fw-semibold">Peter Marcus</a>--}}
{{--                                    <!--end::Name--></div>--}}
{{--                                <!--end::Link-->--}}
{{--                            </div>--}}
{{--                            <!--end::Info-->--}}
{{--                            <!--begin::Action-->--}}
{{--                            <a href="#" class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#kt_modal_create_project">View</a>--}}
{{--                            <!--end::Action-->--}}
{{--                        </div>--}}
{{--                        <!--end::Wrapper-->--}}
{{--                    </div>--}}
{{--                    <!--end::Tap pane-->--}}
{{--                    <!--begin::Tap pane-->--}}
{{--                    <div class="tab-pane fade" id="kt_timeline_widget_3_tab_content_3" role="tabpanel">--}}
{{--                        <!--begin::Wrapper-->--}}
{{--                        <div class="d-flex align-items-center mb-6">--}}
{{--                            <!--begin::Bullet-->--}}
{{--                            <span data-kt-element="bullet" class="bullet bullet-vertical d-flex align-items-center min-h-70px mh-100 me-4 bg-primary"></span>--}}
{{--                            <!--end::Bullet-->--}}
{{--                            <!--begin::Info-->--}}
{{--                            <div class="flex-grow-1 me-5">--}}
{{--                                <!--begin::Time-->--}}
{{--                                <div class="text-gray-800 fw-semibold fs-2">10:20 - 11:00--}}
{{--                                    <span class="text-gray-400 fw-semibold fs-7">AM</span></div>--}}
{{--                                <!--end::Time-->--}}
{{--                                <!--begin::Description-->--}}
{{--                                <div class="text-gray-700 fw-semibold fs-6">9 Degree Project Estimation Meeting</div>--}}
{{--                                <!--end::Description-->--}}
{{--                                <!--begin::Link-->--}}
{{--                                <div class="text-gray-400 fw-semibold fs-7">Lead by--}}
{{--                                    <!--begin::Name-->--}}
{{--                                    <a href="#" class="text-primary opacity-75-hover fw-semibold">Peter Marcus</a>--}}
{{--                                    <!--end::Name--></div>--}}
{{--                                <!--end::Link-->--}}
{{--                            </div>--}}
{{--                            <!--end::Info-->--}}
{{--                            <!--begin::Action-->--}}
{{--                            <a href="#" class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#kt_modal_create_project">View</a>--}}
{{--                            <!--end::Action-->--}}
{{--                        </div>--}}
{{--                        <!--end::Wrapper-->--}}
{{--                        <!--begin::Wrapper-->--}}
{{--                        <div class="d-flex align-items-center mb-6">--}}
{{--                            <!--begin::Bullet-->--}}
{{--                            <span data-kt-element="bullet" class="bullet bullet-vertical d-flex align-items-center min-h-70px mh-100 me-4 bg-warning"></span>--}}
{{--                            <!--end::Bullet-->--}}
{{--                            <!--begin::Info-->--}}
{{--                            <div class="flex-grow-1 me-5">--}}
{{--                                <!--begin::Time-->--}}
{{--                                <div class="text-gray-800 fw-semibold fs-2">12:00 - 13:40--}}
{{--                                    <span class="text-gray-400 fw-semibold fs-7">AM</span></div>--}}
{{--                                <!--end::Time-->--}}
{{--                                <!--begin::Description-->--}}
{{--                                <div class="text-gray-700 fw-semibold fs-6">Marketing Campaign Discussion</div>--}}
{{--                                <!--end::Description-->--}}
{{--                                <!--begin::Link-->--}}
{{--                                <div class="text-gray-400 fw-semibold fs-7">Lead by--}}
{{--                                    <!--begin::Name-->--}}
{{--                                    <a href="#" class="text-primary opacity-75-hover fw-semibold">Lead by Bob</a>--}}
{{--                                    <!--end::Name--></div>--}}
{{--                                <!--end::Link-->--}}
{{--                            </div>--}}
{{--                            <!--end::Info-->--}}
{{--                            <!--begin::Action-->--}}
{{--                            <a href="#" class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#kt_modal_create_project">View</a>--}}
{{--                            <!--end::Action-->--}}
{{--                        </div>--}}
{{--                        <!--end::Wrapper-->--}}
{{--                        <!--begin::Wrapper-->--}}
{{--                        <div class="d-flex align-items-center mb-6">--}}
{{--                            <!--begin::Bullet-->--}}
{{--                            <span data-kt-element="bullet" class="bullet bullet-vertical d-flex align-items-center min-h-70px mh-100 me-4 bg-info"></span>--}}
{{--                            <!--end::Bullet-->--}}
{{--                            <!--begin::Info-->--}}
{{--                            <div class="flex-grow-1 me-5">--}}
{{--                                <!--begin::Time-->--}}
{{--                                <div class="text-gray-800 fw-semibold fs-2">16:30 - 17:00--}}
{{--                                    <span class="text-gray-400 fw-semibold fs-7">PM</span></div>--}}
{{--                                <!--end::Time-->--}}
{{--                                <!--begin::Description-->--}}
{{--                                <div class="text-gray-700 fw-semibold fs-6">Marketing Campaign Discussion</div>--}}
{{--                                <!--end::Description-->--}}
{{--                                <!--begin::Link-->--}}
{{--                                <div class="text-gray-400 fw-semibold fs-7">Lead by--}}
{{--                                    <!--begin::Name-->--}}
{{--                                    <a href="#" class="text-primary opacity-75-hover fw-semibold">Lead by Mark Morris</a>--}}
{{--                                    <!--end::Name--></div>--}}
{{--                                <!--end::Link-->--}}
{{--                            </div>--}}
{{--                            <!--end::Info-->--}}
{{--                            <!--begin::Action-->--}}
{{--                            <a href="#" class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#kt_modal_create_project">View</a>--}}
{{--                            <!--end::Action-->--}}
{{--                        </div>--}}
{{--                        <!--end::Wrapper-->--}}
{{--                    </div>--}}
{{--                    <!--end::Tap pane-->--}}
{{--                    <!--begin::Tap pane-->--}}
{{--                    <div class="tab-pane fade show active" id="kt_timeline_widget_3_tab_content_4" role="tabpanel">--}}
{{--                        <!--begin::Wrapper-->--}}
{{--                        <div class="d-flex align-items-center mb-6">--}}
{{--                            <!--begin::Bullet-->--}}
{{--                            <span data-kt-element="bullet" class="bullet bullet-vertical d-flex align-items-center min-h-70px mh-100 me-4 bg-info"></span>--}}
{{--                            <!--end::Bullet-->--}}
{{--                            <!--begin::Info-->--}}
{{--                            <div class="flex-grow-1 me-5">--}}
{{--                                <!--begin::Time-->--}}
{{--                                <div class="text-gray-800 fw-semibold fs-2">10:20 - 11:00--}}
{{--                                    <span class="text-gray-400 fw-semibold fs-7">AM</span></div>--}}
{{--                                <!--end::Time-->--}}
{{--                                <!--begin::Description-->--}}
{{--                                <div class="text-gray-700 fw-semibold fs-6">9 Degree Project Estimation Meeting</div>--}}
{{--                                <!--end::Description-->--}}
{{--                                <!--begin::Link-->--}}
{{--                                <div class="text-gray-400 fw-semibold fs-7">Lead by--}}
{{--                                    <!--begin::Name-->--}}
{{--                                    <a href="#" class="text-primary opacity-75-hover fw-semibold">Peter Marcus</a>--}}
{{--                                    <!--end::Name--></div>--}}
{{--                                <!--end::Link-->--}}
{{--                            </div>--}}
{{--                            <!--end::Info-->--}}
{{--                            <!--begin::Action-->--}}
{{--                            <a href="#" class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#kt_modal_create_project">View</a>--}}
{{--                            <!--end::Action-->--}}
{{--                        </div>--}}
{{--                        <!--end::Wrapper-->--}}
{{--                        <!--begin::Wrapper-->--}}
{{--                        <div class="d-flex align-items-center mb-6">--}}
{{--                            <!--begin::Bullet-->--}}
{{--                            <span data-kt-element="bullet" class="bullet bullet-vertical d-flex align-items-center min-h-70px mh-100 me-4 bg-warning"></span>--}}
{{--                            <!--end::Bullet-->--}}
{{--                            <!--begin::Info-->--}}
{{--                            <div class="flex-grow-1 me-5">--}}
{{--                                <!--begin::Time-->--}}
{{--                                <div class="text-gray-800 fw-semibold fs-2">16:30 - 17:00--}}
{{--                                    <span class="text-gray-400 fw-semibold fs-7">PM</span></div>--}}
{{--                                <!--end::Time-->--}}
{{--                                <!--begin::Description-->--}}
{{--                                <div class="text-gray-700 fw-semibold fs-6">Dashboard UI/UX Design Review</div>--}}
{{--                                <!--end::Description-->--}}
{{--                                <!--begin::Link-->--}}
{{--                                <div class="text-gray-400 fw-semibold fs-7">Lead by--}}
{{--                                    <!--begin::Name-->--}}
{{--                                    <a href="#" class="text-primary opacity-75-hover fw-semibold">Lead by Bob</a>--}}
{{--                                    <!--end::Name--></div>--}}
{{--                                <!--end::Link-->--}}
{{--                            </div>--}}
{{--                            <!--end::Info-->--}}
{{--                            <!--begin::Action-->--}}
{{--                            <a href="#" class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#kt_modal_create_project">View</a>--}}
{{--                            <!--end::Action-->--}}
{{--                        </div>--}}
{{--                        <!--end::Wrapper-->--}}
{{--                        <!--begin::Wrapper-->--}}
{{--                        <div class="d-flex align-items-center mb-6">--}}
{{--                            <!--begin::Bullet-->--}}
{{--                            <span data-kt-element="bullet" class="bullet bullet-vertical d-flex align-items-center min-h-70px mh-100 me-4 bg-success"></span>--}}
{{--                            <!--end::Bullet-->--}}
{{--                            <!--begin::Info-->--}}
{{--                            <div class="flex-grow-1 me-5">--}}
{{--                                <!--begin::Time-->--}}
{{--                                <div class="text-gray-800 fw-semibold fs-2">12:00 - 13:40--}}
{{--                                    <span class="text-gray-400 fw-semibold fs-7">AM</span></div>--}}
{{--                                <!--end::Time-->--}}
{{--                                <!--begin::Description-->--}}
{{--                                <div class="text-gray-700 fw-semibold fs-6">Marketing Campaign Discussion</div>--}}
{{--                                <!--end::Description-->--}}
{{--                                <!--begin::Link-->--}}
{{--                                <div class="text-gray-400 fw-semibold fs-7">Lead by--}}
{{--                                    <!--begin::Name-->--}}
{{--                                    <a href="#" class="text-primary opacity-75-hover fw-semibold">Lead by Mark Morris</a>--}}
{{--                                    <!--end::Name--></div>--}}
{{--                                <!--end::Link-->--}}
{{--                            </div>--}}
{{--                            <!--end::Info-->--}}
{{--                            <!--begin::Action-->--}}
{{--                            <a href="#" class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#kt_modal_create_project">View</a>--}}
{{--                            <!--end::Action-->--}}
{{--                        </div>--}}
{{--                        <!--end::Wrapper-->--}}
{{--                    </div>--}}
{{--                    <!--end::Tap pane-->--}}
{{--                    <!--begin::Tap pane-->--}}
{{--                    <div class="tab-pane fade" id="kt_timeline_widget_3_tab_content_5" role="tabpanel">--}}
{{--                        <!--begin::Wrapper-->--}}
{{--                        <div class="d-flex align-items-center mb-6">--}}
{{--                            <!--begin::Bullet-->--}}
{{--                            <span data-kt-element="bullet" class="bullet bullet-vertical d-flex align-items-center min-h-70px mh-100 me-4 bg-danger"></span>--}}
{{--                            <!--end::Bullet-->--}}
{{--                            <!--begin::Info-->--}}
{{--                            <div class="flex-grow-1 me-5">--}}
{{--                                <!--begin::Time-->--}}
{{--                                <div class="text-gray-800 fw-semibold fs-2">12:00 - 13:40--}}
{{--                                    <span class="text-gray-400 fw-semibold fs-7">AM</span></div>--}}
{{--                                <!--end::Time-->--}}
{{--                                <!--begin::Description-->--}}
{{--                                <div class="text-gray-700 fw-semibold fs-6">9 Dashboard UI/UX Design Review</div>--}}
{{--                                <!--end::Description-->--}}
{{--                                <!--begin::Link-->--}}
{{--                                <div class="text-gray-400 fw-semibold fs-7">Lead by--}}
{{--                                    <!--begin::Name-->--}}
{{--                                    <a href="#" class="text-primary opacity-75-hover fw-semibold">Lead by Bob</a>--}}
{{--                                    <!--end::Name--></div>--}}
{{--                                <!--end::Link-->--}}
{{--                            </div>--}}
{{--                            <!--end::Info-->--}}
{{--                            <!--begin::Action-->--}}
{{--                            <a href="#" class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#kt_modal_create_project">View</a>--}}
{{--                            <!--end::Action-->--}}
{{--                        </div>--}}
{{--                        <!--end::Wrapper-->--}}
{{--                        <!--begin::Wrapper-->--}}
{{--                        <div class="d-flex align-items-center mb-6">--}}
{{--                            <!--begin::Bullet-->--}}
{{--                            <span data-kt-element="bullet" class="bullet bullet-vertical d-flex align-items-center min-h-70px mh-100 me-4 bg-warning"></span>--}}
{{--                            <!--end::Bullet-->--}}
{{--                            <!--begin::Info-->--}}
{{--                            <div class="flex-grow-1 me-5">--}}
{{--                                <!--begin::Time-->--}}
{{--                                <div class="text-gray-800 fw-semibold fs-2">10:20 - 11:00--}}
{{--                                    <span class="text-gray-400 fw-semibold fs-7">AM</span></div>--}}
{{--                                <!--end::Time-->--}}
{{--                                <!--begin::Description-->--}}
{{--                                <div class="text-gray-700 fw-semibold fs-6">9 Degree Project Estimation Meeting</div>--}}
{{--                                <!--end::Description-->--}}
{{--                                <!--begin::Link-->--}}
{{--                                <div class="text-gray-400 fw-semibold fs-7">Lead by--}}
{{--                                    <!--begin::Name-->--}}
{{--                                    <a href="#" class="text-primary opacity-75-hover fw-semibold">Lead by Mark Morris</a>--}}
{{--                                    <!--end::Name--></div>--}}
{{--                                <!--end::Link-->--}}
{{--                            </div>--}}
{{--                            <!--end::Info-->--}}
{{--                            <!--begin::Action-->--}}
{{--                            <a href="#" class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#kt_modal_create_project">View</a>--}}
{{--                            <!--end::Action-->--}}
{{--                        </div>--}}
{{--                        <!--end::Wrapper-->--}}
{{--                        <!--begin::Wrapper-->--}}
{{--                        <div class="d-flex align-items-center mb-6">--}}
{{--                            <!--begin::Bullet-->--}}
{{--                            <span data-kt-element="bullet" class="bullet bullet-vertical d-flex align-items-center min-h-70px mh-100 me-4 bg-info"></span>--}}
{{--                            <!--end::Bullet-->--}}
{{--                            <!--begin::Info-->--}}
{{--                            <div class="flex-grow-1 me-5">--}}
{{--                                <!--begin::Time-->--}}
{{--                                <div class="text-gray-800 fw-semibold fs-2">16:30 - 17:00--}}
{{--                                    <span class="text-gray-400 fw-semibold fs-7">PM</span></div>--}}
{{--                                <!--end::Time-->--}}
{{--                                <!--begin::Description-->--}}
{{--                                <div class="text-gray-700 fw-semibold fs-6">Marketing Campaign Discussion</div>--}}
{{--                                <!--end::Description-->--}}
{{--                                <!--begin::Link-->--}}
{{--                                <div class="text-gray-400 fw-semibold fs-7">Lead by--}}
{{--                                    <!--begin::Name-->--}}
{{--                                    <a href="#" class="text-primary opacity-75-hover fw-semibold">Peter Marcus</a>--}}
{{--                                    <!--end::Name--></div>--}}
{{--                                <!--end::Link-->--}}
{{--                            </div>--}}
{{--                            <!--end::Info-->--}}
{{--                            <!--begin::Action-->--}}
{{--                            <a href="#" class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#kt_modal_create_project">View</a>--}}
{{--                            <!--end::Action-->--}}
{{--                        </div>--}}
{{--                        <!--end::Wrapper-->--}}
{{--                    </div>--}}
{{--                    <!--end::Tap pane-->--}}
{{--                    <!--begin::Tap pane-->--}}
{{--                    <div class="tab-pane fade" id="kt_timeline_widget_3_tab_content_6" role="tabpanel">--}}
{{--                        <!--begin::Wrapper-->--}}
{{--                        <div class="d-flex align-items-center mb-6">--}}
{{--                            <!--begin::Bullet-->--}}
{{--                            <span data-kt-element="bullet" class="bullet bullet-vertical d-flex align-items-center min-h-70px mh-100 me-4 bg-info"></span>--}}
{{--                            <!--end::Bullet-->--}}
{{--                            <!--begin::Info-->--}}
{{--                            <div class="flex-grow-1 me-5">--}}
{{--                                <!--begin::Time-->--}}
{{--                                <div class="text-gray-800 fw-semibold fs-2">10:20 - 11:00--}}
{{--                                    <span class="text-gray-400 fw-semibold fs-7">AM</span></div>--}}
{{--                                <!--end::Time-->--}}
{{--                                <!--begin::Description-->--}}
{{--                                <div class="text-gray-700 fw-semibold fs-6">Marketing Campaign Discussion</div>--}}
{{--                                <!--end::Description-->--}}
{{--                                <!--begin::Link-->--}}
{{--                                <div class="text-gray-400 fw-semibold fs-7">Lead by--}}
{{--                                    <!--begin::Name-->--}}
{{--                                    <a href="#" class="text-primary opacity-75-hover fw-semibold">Lead by Mark Morris</a>--}}
{{--                                    <!--end::Name--></div>--}}
{{--                                <!--end::Link-->--}}
{{--                            </div>--}}
{{--                            <!--end::Info-->--}}
{{--                            <!--begin::Action-->--}}
{{--                            <a href="#" class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#kt_modal_create_project">View</a>--}}
{{--                            <!--end::Action-->--}}
{{--                        </div>--}}
{{--                        <!--end::Wrapper-->--}}
{{--                        <!--begin::Wrapper-->--}}
{{--                        <div class="d-flex align-items-center mb-6">--}}
{{--                            <!--begin::Bullet-->--}}
{{--                            <span data-kt-element="bullet" class="bullet bullet-vertical d-flex align-items-center min-h-70px mh-100 me-4 bg-primary"></span>--}}
{{--                            <!--end::Bullet-->--}}
{{--                            <!--begin::Info-->--}}
{{--                            <div class="flex-grow-1 me-5">--}}
{{--                                <!--begin::Time-->--}}
{{--                                <div class="text-gray-800 fw-semibold fs-2">16:30 - 17:00--}}
{{--                                    <span class="text-gray-400 fw-semibold fs-7">PM</span></div>--}}
{{--                                <!--end::Time-->--}}
{{--                                <!--begin::Description-->--}}
{{--                                <div class="text-gray-700 fw-semibold fs-6">9 Degree Project Estimation Meeting</div>--}}
{{--                                <!--end::Description-->--}}
{{--                                <!--begin::Link-->--}}
{{--                                <div class="text-gray-400 fw-semibold fs-7">Lead by--}}
{{--                                    <!--begin::Name-->--}}
{{--                                    <a href="#" class="text-primary opacity-75-hover fw-semibold">Peter Marcus</a>--}}
{{--                                    <!--end::Name--></div>--}}
{{--                                <!--end::Link-->--}}
{{--                            </div>--}}
{{--                            <!--end::Info-->--}}
{{--                            <!--begin::Action-->--}}
{{--                            <a href="#" class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#kt_modal_create_project">View</a>--}}
{{--                            <!--end::Action-->--}}
{{--                        </div>--}}
{{--                        <!--end::Wrapper-->--}}
{{--                        <!--begin::Wrapper-->--}}
{{--                        <div class="d-flex align-items-center mb-6">--}}
{{--                            <!--begin::Bullet-->--}}
{{--                            <span data-kt-element="bullet" class="bullet bullet-vertical d-flex align-items-center min-h-70px mh-100 me-4 bg-warning"></span>--}}
{{--                            <!--end::Bullet-->--}}
{{--                            <!--begin::Info-->--}}
{{--                            <div class="flex-grow-1 me-5">--}}
{{--                                <!--begin::Time-->--}}
{{--                                <div class="text-gray-800 fw-semibold fs-2">12:00 - 13:40--}}
{{--                                    <span class="text-gray-400 fw-semibold fs-7">AM</span></div>--}}
{{--                                <!--end::Time-->--}}
{{--                                <!--begin::Description-->--}}
{{--                                <div class="text-gray-700 fw-semibold fs-6">9 Dashboard UI/UX Design Review</div>--}}
{{--                                <!--end::Description-->--}}
{{--                                <!--begin::Link-->--}}
{{--                                <div class="text-gray-400 fw-semibold fs-7">Lead by--}}
{{--                                    <!--begin::Name-->--}}
{{--                                    <a href="#" class="text-primary opacity-75-hover fw-semibold">Lead by Bob</a>--}}
{{--                                    <!--end::Name--></div>--}}
{{--                                <!--end::Link-->--}}
{{--                            </div>--}}
{{--                            <!--end::Info-->--}}
{{--                            <!--begin::Action-->--}}
{{--                            <a href="#" class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#kt_modal_create_project">View</a>--}}
{{--                            <!--end::Action-->--}}
{{--                        </div>--}}
{{--                        <!--end::Wrapper-->--}}
{{--                    </div>--}}
{{--                    <!--end::Tap pane-->--}}
{{--                    <!--begin::Tap pane-->--}}
{{--                    <div class="tab-pane fade" id="kt_timeline_widget_3_tab_content_7" role="tabpanel">--}}
{{--                        <!--begin::Wrapper-->--}}
{{--                        <div class="d-flex align-items-center mb-6">--}}
{{--                            <!--begin::Bullet-->--}}
{{--                            <span data-kt-element="bullet" class="bullet bullet-vertical d-flex align-items-center min-h-70px mh-100 me-4 bg-warning"></span>--}}
{{--                            <!--end::Bullet-->--}}
{{--                            <!--begin::Info-->--}}
{{--                            <div class="flex-grow-1 me-5">--}}
{{--                                <!--begin::Time-->--}}
{{--                                <div class="text-gray-800 fw-semibold fs-2">12:00 - 13:40--}}
{{--                                    <span class="text-gray-400 fw-semibold fs-7">AM</span></div>--}}
{{--                                <!--end::Time-->--}}
{{--                                <!--begin::Description-->--}}
{{--                                <div class="text-gray-700 fw-semibold fs-6">9 Degree Project Estimation Meeting</div>--}}
{{--                                <!--end::Description-->--}}
{{--                                <!--begin::Link-->--}}
{{--                                <div class="text-gray-400 fw-semibold fs-7">Lead by--}}
{{--                                    <!--begin::Name-->--}}
{{--                                    <a href="#" class="text-primary opacity-75-hover fw-semibold">Lead by Bob</a>--}}
{{--                                    <!--end::Name--></div>--}}
{{--                                <!--end::Link-->--}}
{{--                            </div>--}}
{{--                            <!--end::Info-->--}}
{{--                            <!--begin::Action-->--}}
{{--                            <a href="#" class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#kt_modal_create_project">View</a>--}}
{{--                            <!--end::Action-->--}}
{{--                        </div>--}}
{{--                        <!--end::Wrapper-->--}}
{{--                        <!--begin::Wrapper-->--}}
{{--                        <div class="d-flex align-items-center mb-6">--}}
{{--                            <!--begin::Bullet-->--}}
{{--                            <span data-kt-element="bullet" class="bullet bullet-vertical d-flex align-items-center min-h-70px mh-100 me-4 bg-danger"></span>--}}
{{--                            <!--end::Bullet-->--}}
{{--                            <!--begin::Info-->--}}
{{--                            <div class="flex-grow-1 me-5">--}}
{{--                                <!--begin::Time-->--}}
{{--                                <div class="text-gray-800 fw-semibold fs-2">10:20 - 11:00--}}
{{--                                    <span class="text-gray-400 fw-semibold fs-7">AM</span></div>--}}
{{--                                <!--end::Time-->--}}
{{--                                <!--begin::Description-->--}}
{{--                                <div class="text-gray-700 fw-semibold fs-6">9 Dashboard UI/UX Design Review</div>--}}
{{--                                <!--end::Description-->--}}
{{--                                <!--begin::Link-->--}}
{{--                                <div class="text-gray-400 fw-semibold fs-7">Lead by--}}
{{--                                    <!--begin::Name-->--}}
{{--                                    <a href="#" class="text-primary opacity-75-hover fw-semibold">Peter Marcus</a>--}}
{{--                                    <!--end::Name--></div>--}}
{{--                                <!--end::Link-->--}}
{{--                            </div>--}}
{{--                            <!--end::Info-->--}}
{{--                            <!--begin::Action-->--}}
{{--                            <a href="#" class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#kt_modal_create_project">View</a>--}}
{{--                            <!--end::Action-->--}}
{{--                        </div>--}}
{{--                        <!--end::Wrapper-->--}}
{{--                        <!--begin::Wrapper-->--}}
{{--                        <div class="d-flex align-items-center mb-6">--}}
{{--                            <!--begin::Bullet-->--}}
{{--                            <span data-kt-element="bullet" class="bullet bullet-vertical d-flex align-items-center min-h-70px mh-100 me-4 bg-success"></span>--}}
{{--                            <!--end::Bullet-->--}}
{{--                            <!--begin::Info-->--}}
{{--                            <div class="flex-grow-1 me-5">--}}
{{--                                <!--begin::Time-->--}}
{{--                                <div class="text-gray-800 fw-semibold fs-2">16:30 - 17:00--}}
{{--                                    <span class="text-gray-400 fw-semibold fs-7">PM</span></div>--}}
{{--                                <!--end::Time-->--}}
{{--                                <!--begin::Description-->--}}
{{--                                <div class="text-gray-700 fw-semibold fs-6">Marketing Campaign Discussion</div>--}}
{{--                                <!--end::Description-->--}}
{{--                                <!--begin::Link-->--}}
{{--                                <div class="text-gray-400 fw-semibold fs-7">Lead by--}}
{{--                                    <!--begin::Name-->--}}
{{--                                    <a href="#" class="text-primary opacity-75-hover fw-semibold">Lead by Mark Morris</a>--}}
{{--                                    <!--end::Name--></div>--}}
{{--                                <!--end::Link-->--}}
{{--                            </div>--}}
{{--                            <!--end::Info-->--}}
{{--                            <!--begin::Action-->--}}
{{--                            <a href="#" class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#kt_modal_create_project">View</a>--}}
{{--                            <!--end::Action-->--}}
{{--                        </div>--}}
{{--                        <!--end::Wrapper-->--}}
{{--                    </div>--}}
{{--                    <!--end::Tap pane-->--}}
{{--                    <!--begin::Tap pane-->--}}
{{--                    <div class="tab-pane fade" id="kt_timeline_widget_3_tab_content_8" role="tabpanel">--}}
{{--                        <!--begin::Wrapper-->--}}
{{--                        <div class="d-flex align-items-center mb-6">--}}
{{--                            <!--begin::Bullet-->--}}
{{--                            <span data-kt-element="bullet" class="bullet bullet-vertical d-flex align-items-center min-h-70px mh-100 me-4 bg-success"></span>--}}
{{--                            <!--end::Bullet-->--}}
{{--                            <!--begin::Info-->--}}
{{--                            <div class="flex-grow-1 me-5">--}}
{{--                                <!--begin::Time-->--}}
{{--                                <div class="text-gray-800 fw-semibold fs-2">16:30 - 17:00--}}
{{--                                    <span class="text-gray-400 fw-semibold fs-7">PM</span></div>--}}
{{--                                <!--end::Time-->--}}
{{--                                <!--begin::Description-->--}}
{{--                                <div class="text-gray-700 fw-semibold fs-6">Marketing Campaign Discussion</div>--}}
{{--                                <!--end::Description-->--}}
{{--                                <!--begin::Link-->--}}
{{--                                <div class="text-gray-400 fw-semibold fs-7">Lead by--}}
{{--                                    <!--begin::Name-->--}}
{{--                                    <a href="#" class="text-primary opacity-75-hover fw-semibold">Peter Marcus</a>--}}
{{--                                    <!--end::Name--></div>--}}
{{--                                <!--end::Link-->--}}
{{--                            </div>--}}
{{--                            <!--end::Info-->--}}
{{--                            <!--begin::Action-->--}}
{{--                            <a href="#" class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#kt_modal_create_project">View</a>--}}
{{--                            <!--end::Action-->--}}
{{--                        </div>--}}
{{--                        <!--end::Wrapper-->--}}
{{--                        <!--begin::Wrapper-->--}}
{{--                        <div class="d-flex align-items-center mb-6">--}}
{{--                            <!--begin::Bullet-->--}}
{{--                            <span data-kt-element="bullet" class="bullet bullet-vertical d-flex align-items-center min-h-70px mh-100 me-4 bg-info"></span>--}}
{{--                            <!--end::Bullet-->--}}
{{--                            <!--begin::Info-->--}}
{{--                            <div class="flex-grow-1 me-5">--}}
{{--                                <!--begin::Time-->--}}
{{--                                <div class="text-gray-800 fw-semibold fs-2">10:20 - 11:00--}}
{{--                                    <span class="text-gray-400 fw-semibold fs-7">AM</span></div>--}}
{{--                                <!--end::Time-->--}}
{{--                                <!--begin::Description-->--}}
{{--                                <div class="text-gray-700 fw-semibold fs-6">9 Degree Project Estimation Meeting</div>--}}
{{--                                <!--end::Description-->--}}
{{--                                <!--begin::Link-->--}}
{{--                                <div class="text-gray-400 fw-semibold fs-7">Lead by--}}
{{--                                    <!--begin::Name-->--}}
{{--                                    <a href="#" class="text-primary opacity-75-hover fw-semibold">Lead by Mark Morris</a>--}}
{{--                                    <!--end::Name--></div>--}}
{{--                                <!--end::Link-->--}}
{{--                            </div>--}}
{{--                            <!--end::Info-->--}}
{{--                            <!--begin::Action-->--}}
{{--                            <a href="#" class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#kt_modal_create_project">View</a>--}}
{{--                            <!--end::Action-->--}}
{{--                        </div>--}}
{{--                        <!--end::Wrapper-->--}}
{{--                        <!--begin::Wrapper-->--}}
{{--                        <div class="d-flex align-items-center mb-6">--}}
{{--                            <!--begin::Bullet-->--}}
{{--                            <span data-kt-element="bullet" class="bullet bullet-vertical d-flex align-items-center min-h-70px mh-100 me-4 bg-danger"></span>--}}
{{--                            <!--end::Bullet-->--}}
{{--                            <!--begin::Info-->--}}
{{--                            <div class="flex-grow-1 me-5">--}}
{{--                                <!--begin::Time-->--}}
{{--                                <div class="text-gray-800 fw-semibold fs-2">12:00 - 13:40--}}
{{--                                    <span class="text-gray-400 fw-semibold fs-7">AM</span></div>--}}
{{--                                <!--end::Time-->--}}
{{--                                <!--begin::Description-->--}}
{{--                                <div class="text-gray-700 fw-semibold fs-6">9 Dashboard UI/UX Design Review</div>--}}
{{--                                <!--end::Description-->--}}
{{--                                <!--begin::Link-->--}}
{{--                                <div class="text-gray-400 fw-semibold fs-7">Lead by--}}
{{--                                    <!--begin::Name-->--}}
{{--                                    <a href="#" class="text-primary opacity-75-hover fw-semibold">Lead by Bob</a>--}}
{{--                                    <!--end::Name--></div>--}}
{{--                                <!--end::Link-->--}}
{{--                            </div>--}}
{{--                            <!--end::Info-->--}}
{{--                            <!--begin::Action-->--}}
{{--                            <a href="#" class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#kt_modal_create_project">View</a>--}}
{{--                            <!--end::Action-->--}}
{{--                        </div>--}}
{{--                        <!--end::Wrapper-->--}}
{{--                    </div>--}}
{{--                    <!--end::Tap pane-->--}}
{{--                    <!--begin::Tap pane-->--}}
{{--                    <div class="tab-pane fade" id="kt_timeline_widget_3_tab_content_9" role="tabpanel">--}}
{{--                        <!--begin::Wrapper-->--}}
{{--                        <div class="d-flex align-items-center mb-6">--}}
{{--                            <!--begin::Bullet-->--}}
{{--                            <span data-kt-element="bullet" class="bullet bullet-vertical d-flex align-items-center min-h-70px mh-100 me-4 bg-info"></span>--}}
{{--                            <!--end::Bullet-->--}}
{{--                            <!--begin::Info-->--}}
{{--                            <div class="flex-grow-1 me-5">--}}
{{--                                <!--begin::Time-->--}}
{{--                                <div class="text-gray-800 fw-semibold fs-2">12:00 - 13:40--}}
{{--                                    <span class="text-gray-400 fw-semibold fs-7">AM</span></div>--}}
{{--                                <!--end::Time-->--}}
{{--                                <!--begin::Description-->--}}
{{--                                <div class="text-gray-700 fw-semibold fs-6">9 Degree Project Estimation Meeting</div>--}}
{{--                                <!--end::Description-->--}}
{{--                                <!--begin::Link-->--}}
{{--                                <div class="text-gray-400 fw-semibold fs-7">Lead by--}}
{{--                                    <!--begin::Name-->--}}
{{--                                    <a href="#" class="text-primary opacity-75-hover fw-semibold">Lead by Bob</a>--}}
{{--                                    <!--end::Name--></div>--}}
{{--                                <!--end::Link-->--}}
{{--                            </div>--}}
{{--                            <!--end::Info-->--}}
{{--                            <!--begin::Action-->--}}
{{--                            <a href="#" class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#kt_modal_create_project">View</a>--}}
{{--                            <!--end::Action-->--}}
{{--                        </div>--}}
{{--                        <!--end::Wrapper-->--}}
{{--                        <!--begin::Wrapper-->--}}
{{--                        <div class="d-flex align-items-center mb-6">--}}
{{--                            <!--begin::Bullet-->--}}
{{--                            <span data-kt-element="bullet" class="bullet bullet-vertical d-flex align-items-center min-h-70px mh-100 me-4 bg-primary"></span>--}}
{{--                            <!--end::Bullet-->--}}
{{--                            <!--begin::Info-->--}}
{{--                            <div class="flex-grow-1 me-5">--}}
{{--                                <!--begin::Time-->--}}
{{--                                <div class="text-gray-800 fw-semibold fs-2">16:30 - 17:00--}}
{{--                                    <span class="text-gray-400 fw-semibold fs-7">PM</span></div>--}}
{{--                                <!--end::Time-->--}}
{{--                                <!--begin::Description-->--}}
{{--                                <div class="text-gray-700 fw-semibold fs-6">Marketing Campaign Discussion</div>--}}
{{--                                <!--end::Description-->--}}
{{--                                <!--begin::Link-->--}}
{{--                                <div class="text-gray-400 fw-semibold fs-7">Lead by--}}
{{--                                    <!--begin::Name-->--}}
{{--                                    <a href="#" class="text-primary opacity-75-hover fw-semibold">Lead by Mark Morris</a>--}}
{{--                                    <!--end::Name--></div>--}}
{{--                                <!--end::Link-->--}}
{{--                            </div>--}}
{{--                            <!--end::Info-->--}}
{{--                            <!--begin::Action-->--}}
{{--                            <a href="#" class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#kt_modal_create_project">View</a>--}}
{{--                            <!--end::Action-->--}}
{{--                        </div>--}}
{{--                        <!--end::Wrapper-->--}}
{{--                        <!--begin::Wrapper-->--}}
{{--                        <div class="d-flex align-items-center mb-6">--}}
{{--                            <!--begin::Bullet-->--}}
{{--                            <span data-kt-element="bullet" class="bullet bullet-vertical d-flex align-items-center min-h-70px mh-100 me-4 bg-success"></span>--}}
{{--                            <!--end::Bullet-->--}}
{{--                            <!--begin::Info-->--}}
{{--                            <div class="flex-grow-1 me-5">--}}
{{--                                <!--begin::Time-->--}}
{{--                                <div class="text-gray-800 fw-semibold fs-2">10:20 - 11:00--}}
{{--                                    <span class="text-gray-400 fw-semibold fs-7">AM</span></div>--}}
{{--                                <!--end::Time-->--}}
{{--                                <!--begin::Description-->--}}
{{--                                <div class="text-gray-700 fw-semibold fs-6">9 Dashboard UI/UX Design Review</div>--}}
{{--                                <!--end::Description-->--}}
{{--                                <!--begin::Link-->--}}
{{--                                <div class="text-gray-400 fw-semibold fs-7">Lead by--}}
{{--                                    <!--begin::Name-->--}}
{{--                                    <a href="#" class="text-primary opacity-75-hover fw-semibold">Peter Marcus</a>--}}
{{--                                    <!--end::Name--></div>--}}
{{--                                <!--end::Link-->--}}
{{--                            </div>--}}
{{--                            <!--end::Info-->--}}
{{--                            <!--begin::Action-->--}}
{{--                            <a href="#" class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#kt_modal_create_project">View</a>--}}
{{--                            <!--end::Action-->--}}
{{--                        </div>--}}
{{--                        <!--end::Wrapper-->--}}
{{--                    </div>--}}
{{--                    <!--end::Tap pane-->--}}
{{--                    <!--begin::Tap pane-->--}}
{{--                    <div class="tab-pane fade" id="kt_timeline_widget_3_tab_content_10" role="tabpanel">--}}
{{--                        <!--begin::Wrapper-->--}}
{{--                        <div class="d-flex align-items-center mb-6">--}}
{{--                            <!--begin::Bullet-->--}}
{{--                            <span data-kt-element="bullet" class="bullet bullet-vertical d-flex align-items-center min-h-70px mh-100 me-4 bg-danger"></span>--}}
{{--                            <!--end::Bullet-->--}}
{{--                            <!--begin::Info-->--}}
{{--                            <div class="flex-grow-1 me-5">--}}
{{--                                <!--begin::Time-->--}}
{{--                                <div class="text-gray-800 fw-semibold fs-2">12:00 - 13:40--}}
{{--                                    <span class="text-gray-400 fw-semibold fs-7">AM</span></div>--}}
{{--                                <!--end::Time-->--}}
{{--                                <!--begin::Description-->--}}
{{--                                <div class="text-gray-700 fw-semibold fs-6">Marketing Campaign Discussion</div>--}}
{{--                                <!--end::Description-->--}}
{{--                                <!--begin::Link-->--}}
{{--                                <div class="text-gray-400 fw-semibold fs-7">Lead by--}}
{{--                                    <!--begin::Name-->--}}
{{--                                    <a href="#" class="text-primary opacity-75-hover fw-semibold">Peter Marcus</a>--}}
{{--                                    <!--end::Name--></div>--}}
{{--                                <!--end::Link-->--}}
{{--                            </div>--}}
{{--                            <!--end::Info-->--}}
{{--                            <!--begin::Action-->--}}
{{--                            <a href="#" class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#kt_modal_create_project">View</a>--}}
{{--                            <!--end::Action-->--}}
{{--                        </div>--}}
{{--                        <!--end::Wrapper-->--}}
{{--                        <!--begin::Wrapper-->--}}
{{--                        <div class="d-flex align-items-center mb-6">--}}
{{--                            <!--begin::Bullet-->--}}
{{--                            <span data-kt-element="bullet" class="bullet bullet-vertical d-flex align-items-center min-h-70px mh-100 me-4 bg-warning"></span>--}}
{{--                            <!--end::Bullet-->--}}
{{--                            <!--begin::Info-->--}}
{{--                            <div class="flex-grow-1 me-5">--}}
{{--                                <!--begin::Time-->--}}
{{--                                <div class="text-gray-800 fw-semibold fs-2">10:20 - 11:00--}}
{{--                                    <span class="text-gray-400 fw-semibold fs-7">AM</span></div>--}}
{{--                                <!--end::Time-->--}}
{{--                                <!--begin::Description-->--}}
{{--                                <div class="text-gray-700 fw-semibold fs-6">9 Dashboard UI/UX Design Review</div>--}}
{{--                                <!--end::Description-->--}}
{{--                                <!--begin::Link-->--}}
{{--                                <div class="text-gray-400 fw-semibold fs-7">Lead by--}}
{{--                                    <!--begin::Name-->--}}
{{--                                    <a href="#" class="text-primary opacity-75-hover fw-semibold">Lead by Bob</a>--}}
{{--                                    <!--end::Name--></div>--}}
{{--                                <!--end::Link-->--}}
{{--                            </div>--}}
{{--                            <!--end::Info-->--}}
{{--                            <!--begin::Action-->--}}
{{--                            <a href="#" class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#kt_modal_create_project">View</a>--}}
{{--                            <!--end::Action-->--}}
{{--                        </div>--}}
{{--                        <!--end::Wrapper-->--}}
{{--                        <!--begin::Wrapper-->--}}
{{--                        <div class="d-flex align-items-center mb-6">--}}
{{--                            <!--begin::Bullet-->--}}
{{--                            <span data-kt-element="bullet" class="bullet bullet-vertical d-flex align-items-center min-h-70px mh-100 me-4 bg-info"></span>--}}
{{--                            <!--end::Bullet-->--}}
{{--                            <!--begin::Info-->--}}
{{--                            <div class="flex-grow-1 me-5">--}}
{{--                                <!--begin::Time-->--}}
{{--                                <div class="text-gray-800 fw-semibold fs-2">16:30 - 17:00--}}
{{--                                    <span class="text-gray-400 fw-semibold fs-7">PM</span></div>--}}
{{--                                <!--end::Time-->--}}
{{--                                <!--begin::Description-->--}}
{{--                                <div class="text-gray-700 fw-semibold fs-6">9 Degree Project Estimation Meeting</div>--}}
{{--                                <!--end::Description-->--}}
{{--                                <!--begin::Link-->--}}
{{--                                <div class="text-gray-400 fw-semibold fs-7">Lead by--}}
{{--                                    <!--begin::Name-->--}}
{{--                                    <a href="#" class="text-primary opacity-75-hover fw-semibold">Lead by Mark Morris</a>--}}
{{--                                    <!--end::Name--></div>--}}
{{--                                <!--end::Link-->--}}
{{--                            </div>--}}
{{--                            <!--end::Info-->--}}
{{--                            <!--begin::Action-->--}}
{{--                            <a href="#" class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#kt_modal_create_project">View</a>--}}
{{--                            <!--end::Action-->--}}
{{--                        </div>--}}
{{--                        <!--end::Wrapper-->--}}
{{--                    </div>--}}
{{--                    <!--end::Tap pane-->--}}
{{--                    <!--begin::Tap pane-->--}}
{{--                    <div class="tab-pane fade" id="kt_timeline_widget_3_tab_content_11" role="tabpanel">--}}
{{--                        <!--begin::Wrapper-->--}}
{{--                        <div class="d-flex align-items-center mb-6">--}}
{{--                            <!--begin::Bullet-->--}}
{{--                            <span data-kt-element="bullet" class="bullet bullet-vertical d-flex align-items-center min-h-70px mh-100 me-4 bg-info"></span>--}}
{{--                            <!--end::Bullet-->--}}
{{--                            <!--begin::Info-->--}}
{{--                            <div class="flex-grow-1 me-5">--}}
{{--                                <!--begin::Time-->--}}
{{--                                <div class="text-gray-800 fw-semibold fs-2">16:30 - 17:00--}}
{{--                                    <span class="text-gray-400 fw-semibold fs-7">PM</span></div>--}}
{{--                                <!--end::Time-->--}}
{{--                                <!--begin::Description-->--}}
{{--                                <div class="text-gray-700 fw-semibold fs-6">9 Dashboard UI/UX Design Review</div>--}}
{{--                                <!--end::Description-->--}}
{{--                                <!--begin::Link-->--}}
{{--                                <div class="text-gray-400 fw-semibold fs-7">Lead by--}}
{{--                                    <!--begin::Name-->--}}
{{--                                    <a href="#" class="text-primary opacity-75-hover fw-semibold">Lead by Mark Morris</a>--}}
{{--                                    <!--end::Name--></div>--}}
{{--                                <!--end::Link-->--}}
{{--                            </div>--}}
{{--                            <!--end::Info-->--}}
{{--                            <!--begin::Action-->--}}
{{--                            <a href="#" class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#kt_modal_create_project">View</a>--}}
{{--                            <!--end::Action-->--}}
{{--                        </div>--}}
{{--                        <!--end::Wrapper-->--}}
{{--                        <!--begin::Wrapper-->--}}
{{--                        <div class="d-flex align-items-center mb-6">--}}
{{--                            <!--begin::Bullet-->--}}
{{--                            <span data-kt-element="bullet" class="bullet bullet-vertical d-flex align-items-center min-h-70px mh-100 me-4 bg-danger"></span>--}}
{{--                            <!--end::Bullet-->--}}
{{--                            <!--begin::Info-->--}}
{{--                            <div class="flex-grow-1 me-5">--}}
{{--                                <!--begin::Time-->--}}
{{--                                <div class="text-gray-800 fw-semibold fs-2">10:20 - 11:00--}}
{{--                                    <span class="text-gray-400 fw-semibold fs-7">AM</span></div>--}}
{{--                                <!--end::Time-->--}}
{{--                                <!--begin::Description-->--}}
{{--                                <div class="text-gray-700 fw-semibold fs-6">Marketing Campaign Discussion</div>--}}
{{--                                <!--end::Description-->--}}
{{--                                <!--begin::Link-->--}}
{{--                                <div class="text-gray-400 fw-semibold fs-7">Lead by--}}
{{--                                    <!--begin::Name-->--}}
{{--                                    <a href="#" class="text-primary opacity-75-hover fw-semibold">Peter Marcus</a>--}}
{{--                                    <!--end::Name--></div>--}}
{{--                                <!--end::Link-->--}}
{{--                            </div>--}}
{{--                            <!--end::Info-->--}}
{{--                            <!--begin::Action-->--}}
{{--                            <a href="#" class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#kt_modal_create_project">View</a>--}}
{{--                            <!--end::Action-->--}}
{{--                        </div>--}}
{{--                        <!--end::Wrapper-->--}}
{{--                        <!--begin::Wrapper-->--}}
{{--                        <div class="d-flex align-items-center mb-6">--}}
{{--                            <!--begin::Bullet-->--}}
{{--                            <span data-kt-element="bullet" class="bullet bullet-vertical d-flex align-items-center min-h-70px mh-100 me-4 bg-primary"></span>--}}
{{--                            <!--end::Bullet-->--}}
{{--                            <!--begin::Info-->--}}
{{--                            <div class="flex-grow-1 me-5">--}}
{{--                                <!--begin::Time-->--}}
{{--                                <div class="text-gray-800 fw-semibold fs-2">12:00 - 13:40--}}
{{--                                    <span class="text-gray-400 fw-semibold fs-7">AM</span></div>--}}
{{--                                <!--end::Time-->--}}
{{--                                <!--begin::Description-->--}}
{{--                                <div class="text-gray-700 fw-semibold fs-6">9 Degree Project Estimation Meeting</div>--}}
{{--                                <!--end::Description-->--}}
{{--                                <!--begin::Link-->--}}
{{--                                <div class="text-gray-400 fw-semibold fs-7">Lead by--}}
{{--                                    <!--begin::Name-->--}}
{{--                                    <a href="#" class="text-primary opacity-75-hover fw-semibold">Lead by Bob</a>--}}
{{--                                    <!--end::Name--></div>--}}
{{--                                <!--end::Link-->--}}
{{--                            </div>--}}
{{--                            <!--end::Info-->--}}
{{--                            <!--begin::Action-->--}}
{{--                            <a href="#" class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#kt_modal_create_project">View</a>--}}
{{--                            <!--end::Action-->--}}
{{--                        </div>--}}
{{--                        <!--end::Wrapper-->--}}
{{--                    </div>--}}
{{--                    <!--end::Tap pane-->--}}
{{--                </div>--}}
{{--                <!--end::Tab Content-->--}}
{{--                <!--begin::Action-->--}}
{{--                <div class="float-end d-none">--}}
{{--                    <a href="#" class="btn btn-sm btn-light me-2" data-bs-toggle="modal" data-bs-target="#kt_modal_create_project">Add Lesson</a>--}}
{{--                    <a href="#" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#kt_modal_create_app">Call Sick for Today</a>--}}
{{--                </div>--}}
{{--                <!--end::Action-->--}}
{{--            </div>--}}
{{--            <!--end: Card Body-->--}}
{{--        </div>--}}
{{--        <!--end::Timeline widget 3-->--}}


{{--    </div>--}}
@stop

@section('scripts')
    <script>
        var tableActionURL = "{{$tableActionURL}}";
        var compareAction = "{{$compareAction}}";
        var tableEditAction = "{{route('editarProposta')}}";
        var tableCandidatosAction = "{{route('estagiosCandidates')}}";
        var profile = "{{session()->get('profile')}}";
        var actionName = "{{$actionName}}";
    </script>
    <script src="{{asset('js/data-ajax-estagios2.js')}}" type="text/javascript"></script>
@stop
