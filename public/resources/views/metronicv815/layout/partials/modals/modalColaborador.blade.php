<div class="modal fade" id="modal_colaborador" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form id="novoColaboradorForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle"> Novo colaborador </h5>
                    <button type="reset" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                </div>
                <div class="modal-body">

                    <div class="form-group" style="display: none">
                        <label for="recipient-name" class="form-control-label">
                            Id:
                        </label>
                        <input type="text" class="col-lg-2 form-control" name="idempresa"
                               value="{{$empresa['idempresa'] ?? ''}}">
                    </div>
                    <div class="form-floating fv-row mb-7 ">
                        <input required type="text" class="form-control" id='nome' name="nome" placeholder=" " value="">

                        <label for="nome" class="form-label required">
                            Nome
                        </label>
                    </div>
                    <div class="form-floating fv-row mb-7 ">
                        <input required type="text" class="form-control" id="cargo" name="cargo" placeholder=" " value="">
                        <label for="cargo" class="form-label required">
                            Cargo
                        </label>
                    </div>
                    <div class="form-floating fv-row mb-7 ">
                        <input required type="email" class="form-control" name="email" id="email" placeholder=" " value="">
                        <label for="email" class="form-label required">
                            Email
                        </label>
                    </div>
                    <div class="form-floating fv-row mb-7 ">
                        <input required type="tel" class="form-control" name="telefone" id="telefone" placeholder=" " value="">
                        <label for="telefone" class="form-label required">
                            Telefone:
                        </label>
                    </div>
                    <div class="fv-row rounded border p-3 mb-7">
                        <label class="form-label required" for="">Formação</label>

                        <div class="row mt-7">

                            <div class="col-4 form-group">
                                <div class="form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox" value="1" id="checkFormacao"
                                           name="checkFormacao">
                                    <label class="form-check-label" for="checkFormacao">Mestrado ou equivalente</label>
                                </div>
                                <div class="fv-plugins-message-container invalid-feedback"></div>
                            </div>
                            <div class="col-5">
                                <div class="form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox" value="1"
                                           id="checkExperienciaRelevante" name="checkExperienciaRelevante">
                                    <label class="form-check-label" for="checkExperienciaRelevante">Experiencia
                                        relevante com:</label>
                                </div>
                            </div>
                            <div class="col-3 form-floating" style="display: none;">
                                <input type="number" min="1" max="100" step="1" class="form-control" name="anos"
                                       id="anos" placeholder=" " value="">
                                <label for="anos" class="form-label required">
                                    Anos
                                </label>
                            </div>
                        </div>
                    </div>
                    <!--begin::Dropzone-->
                    <div class="fv-row mb-7">

                        <div class="dropzone" id="cv_orientador_dropzone">
                            <!--begin::Message-->
                            <div class="dz-message needsclick">
                                <!--begin::Icon-->
                                <i class="bi bi-file-earmark-arrow-up text-primary fs-3x"></i>
                                <!--end::Icon-->

                                <!--begin::Info-->
                                <div class="ms-4">
                                    <h3 class="fs-5 fw-bold text-gray-900 mb-1 required">Arraste os ficheiros ou faça click para
                                        fazer upload</h3>
                                    <span class="fs-7 fw-semibold text-gray-400">Apenas 1 ficheiro</span>
                                </div>
                                <!--end::Info-->
                            </div>
                        </div>

                    </div>
                    <!--end::Dropzone-->

                </div>
                <div class="modal-footer">
                    <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close"> Close
                    </button>
                    <button type="button" class="btn btn-primary" id="btnNovoColaboradorSave"> Save changes</button>
                </div>
                <input hidden type="text" class="col-lg-2 form-control" name="filename" id="filename" value="">
            </form>
        </div>
    </div>
</div>