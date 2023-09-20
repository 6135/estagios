<div class="modal fade" id="modal_colaboradorupdate" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form id="ColaboradorUpdateForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle"> Atualizar CV </h5>
                    <button type="reset" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                </div>
                <div class="modal-body">

                    <!--begin::Dropzone-->
                    <div class="fv-row mb-7">

                        <div class="dropzone" id="cv_orientador_update_dropzone">
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
                    <button type="button" class="btn btn-primary" id="btnUpdateColaboradorSave"> Save changes</button>
                </div>
                <input hidden type="text" class="col-lg-2 form-control" name="filename" id="filenameUpdate" value="">
            </form>
        </div>
    </div>
</div>