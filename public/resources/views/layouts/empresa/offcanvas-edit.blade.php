<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasEditColaborator" aria-labelledby="offcanvasLabel"
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
                            <h5 class="card-title header-text-1 ">{{ trans_choice('company.messages.edit.short.colab',1)}}</h5>
                        </div>
                    </div>
                </div>
                <br>
                <form id="editColaboradorForm" method="POST" action="{{route('empresa.edit.user')}}"
                    class="needs-validation">
                    {{ csrf_field() }}
                    <!-- Nome Empresa -->
                    <div class="fv-row mb-3">
                        <label for="nome"
                            class="sub-header-text-5 mb-1 text-primary">{{ __('company.data.manager.name') }}</label>
                        <input type="text" class="form-control--dei form-control-lg full-border "
                            id="nomeEdit" name="nomeEdit" placeholder=""
                            value="{{''}}" disabled >
                        <input type="text" id="emailEdit" name="emailEdit" placeholder=""
                            value="{{''}}" hidden>
                    </div>
                    <label 
                        class="sub-header-text-5 mb-1 text-primary">{{ trans_choice('words.role',2) }}</label>
                    <div class="row">
                        <div class="col-md-6 mb-3" >
                            <div class="input-group fv-row">
                                <select class="form-select form-select-lg form-select--dei full-border cargo-select" name="cargos" id="cargo0" required>
                                    <option value="-1" selected hidden></option>
                                    <option value="Gestor">{{trans_choice('words.roles.short.Gestor',1)}}</option>
                                    <option value="EmpresaColaborador">{{trans_choice('words.roles.short.EmpresaColaborador',1)}}</option>
                                    <option value="EmpresaRepresentanteLegal">{{trans_choice('words.roles.short.EmpresaRepresentanteLegal',1)}}</option>
                                </select>
                                {{-- <button class="btn border-bottom border-primary border-start-0 border-2 " type="button" style="border-radius: 0;"><i class="bi bi-x-lg"></i></button> --}}
                            </div>
                        </div>
                        <div class="col-md-6 mb-3 " >
                            <div class="input-group fv-row">
                                <select class="form-select form-select-lg form-select--dei full-border border-end-0 cargo-select" name="cargos" id="cargo1">
                                    <option value="-1" selected hidden></option>
                                    <option value="Gestor">{{trans_choice('words.roles.short.Gestor',1)}}</option>
                                    <option value="EmpresaColaborador">{{trans_choice('words.roles.short.EmpresaColaborador',1)}}</option>
                                    <option value="EmpresaRepresentanteLegal">{{trans_choice('words.roles.short.EmpresaRepresentanteLegal',1)}}</option>
                                </select>
                                <button class="btn border-bottom border-primary border-start-0 border-2 cargo-clear" type="button" style="border-radius: 0;"><i class="bi bi-x-lg"></i></button>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3 d-none">
                            <div class="input-group fv-row">
                                <select class="form-select form-select-lg form-select--dei full-border border-end-0" name="cargos" id="cargo2">
                                    <option value="-1" hidden></option>
                                    <option value="Gestor">{{trans_choice('words.roles.short.Gestor',1)}}</option>
                                    <option value="EmpresaColaborador">{{trans_choice('words.roles.short.EmpresaColaborador',1)}}</option>
                                    <option value="EmpresaRepresentanteLegal">{{trans_choice('words.roles.short.EmpresaRepresentanteLegal',1)}}</option>
                                </select>
                                <button  class="btn border-bottom border-primary border-start-0 border-2 cargo-clear" type="button" style="border-radius: 0;"><i class="bi bi-x-lg"></i></button>
                            </div>
                        </div>
                    </div>
                    

                    <div class="d-block flex-nowrap justify-content-end d-md-flex">
                        <div class="order-2">
                            <button class="btn btn-outline-primary form-btn-dei mb-3" type="submit" id="submitButtonEditColab">
                                <span class="spaced-uppertext-dei-bigger">{{ __('words.save') }}</span><span
                                    class="spinner-border spinner-border-sm d-none" id="spinnerEditColab" role="status"
                                    aria-hidden="true" style="margin-left: 5px"></span>

                            </button>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
