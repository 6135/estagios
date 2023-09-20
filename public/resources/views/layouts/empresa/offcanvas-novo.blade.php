<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRequestColaborador" aria-labelledby="offcanvasLabel"
    style="width: 70%">
    <div class="offcanvas-header">
        {{-- <h5 class="offcanvas-title" id="offcanvasLabel">Offcanvas</h5> --}}
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="card border-0 ">
            <div class="card-body">
                <div class="card-title header-text-1 ">
                    <!-- align everything to the left -->
                    <!-- Title plus a select to choose the type of user to add in the same row-->
                    <div class="d-flex justify-content-start">
                        <div class="d-flex align-items-center">
                            <h5 class="card-title header-text-1 ">{{ trans_choice('words.new',1) }}&nbsp;/&nbsp;</h5>
                        </div>
                        <div class="dropdown align-items-center px-0" style="padding-bottom: 0px">
                            <button id="dropdown-toggle" class="btn btn-outline-primary border-top-0 border-end-0 border-start-0 dropdown-toggle pt-0 px-0" type="button"
                                id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false" style="border-radius: 0; border-bottom-width: 2px">
                                <span class="header-text-3 " style="font-weight: 400">{{ trans_choice('words.roles.short.Gestor',1) }}</span>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                <li><a class="dropdown-item" href="#"
                                        onclick="changeFormAction('{{route('empresa.request.new.gestor.post')}}')">{{ trans_choice('words.roles.short.Gestor',1) }}</a>
                                </li>
                                <li><a class="dropdown-item" href="#"
                                        onclick="changeFormAction('{{route('empresa.request.new.rep.post')}}')">{{ trans_choice('words.roles.short.EmpresaRepresentanteLegal',1) }}</a>
                                </li>
                                <li><a class="dropdown-item" href="#"
                                    onclick="changeFormAction('{{route('empresa.request.new.colab.post')}}')">{{ trans_choice('words.roles.short.EmpresaColaborador',1) }}</a>
                                </li>
                            </ul>

                        </div>
                    </div>
                </div>
                <br>
                <form id="requestGestorForm" method="POST" action="{{ route('empresa.request.new.gestor.post') }}"
                    class="needs-validation">
                    <!-- Nome Empresa -->
                    <div class="fv-row mb-3">
                        <label for="nome"
                            class="sub-header-text-5 mb-1 text-primary required">{{ __('company.data.manager.name') }}</label>
                        <input type="text" class="form-control--dei form-control-lg full-border "
                            id="nome" name="nome" placeholder=""
                            value="{{''}}" required>
                    </div>
                    <div class="fv-row mb-3">
                        <label for="email"
                            class="sub-header-text-5 mb-1 text-primary required">{{ __('company.data.manager.email') }}</label>
                        <input type="email" class="form-control--dei form-control-lg full-border "
                            id="email" name="email" placeholder=" " value="{{''}}"
                            required>
                    </div>

                    <div class="d-block flex-nowrap justify-content-end d-md-flex">
                        <div class="order-2">
                            <button class="btn btn-outline-primary form-btn-dei mb-3" type="submit" id="submitButtonGestor">
                                <span class="spaced-uppertext-dei-bigger">{{ __('words.save') }}</span><span
                                    class="spinner-border spinner-border-sm d-none" id="spinnerGestor" role="status"
                                    aria-hidden="true" style="margin-left: 5px"></span>

                            </button>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
