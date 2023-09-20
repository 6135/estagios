<div class="modal fade" id="modal_colaborador_externo" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form id="novoColaboradorExternoForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle"> Novo colaborador Externo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                </div>
                <div class="modal-body">

                    {{-- <div class="form-group" style="display: none">
                        <label for="recipient-name" class="form-control-label">
                            Id:
                        </label>
                        <input type="text" class="col-lg-2 form-control" name="idempresa"
                            value="{{ $empresa['idempresa'] ?? '' }}">
                    </div> --}}
                    <div class="form-floating fv-row mb-7 ">
                        <input required type="text" class="form-control" id='nome' name="nome"
                            placeholder=" " value="">

                        <label for="nome" class="form-label required">
                            Nome
                        </label>
                    </div>
                    <div class="form-floating fv-row mb-7 ">
                        <input required type="email" class="form-control" name="email" id="email"
                            placeholder=" " value="">
                        <label for="email" class="form-label required">
                            Email
                        </label>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close"> Close
                    </button>
                    <button type="button" class="btn btn-primary" id="btnNovoColaboradorExternoSave"> Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
