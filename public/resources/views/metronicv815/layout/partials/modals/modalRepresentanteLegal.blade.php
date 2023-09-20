<div class="modal fade" id="modal_rl" tabindex="-1" role="dialog" >
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form id="novoRepresentanteLegalForm">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">
                    Novo representante legal
                </h5>

                <button type="reset" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
                <div class="modal-body">

                    <div class="form-group" style="display: none">
                        <label for="recipient-name" class="form-label">
                            Id:
                        </label>
                        <input type="text" class="col-lg-2 form-control" name="idempresa" value="{{$empresa['idempresa'] ?? ''}}">
                    </div>
                    <div class="form-floating fv-row mb-7 ">
                        <input type="text" class="form-control" id='nome' name="nome" placeholder=" " value="">

                        <label for="nome" class="form-label required" >
                            Nome
                        </label>
                    </div>
                    <div class="form-floating fv-row mb-7 ">
                        <input type="email" class="form-control" id="cargo" name="cargo" placeholder=" " value="">
                        <label for="cargo" class="form-label required">
                            Cargo
                        </label>
                    </div>
                    <div class="form-floating fv-row mb-7 ">
                        <input type="text" class="form-control" name="email" id="email" placeholder=" " value="">
                        <label for="email" class="form-label required">
                            Email
                        </label>
                    </div>
                    <div class="form-floating fv-row mb-7 ">
                        <input type="tel" class="form-control" name="telefone" id="telefone" placeholder=" " value="">
                        <label for="telefone" class="form-label required">
                            Telefone:
                        </label>
                    </div>

            </div>
                <div class="modal-footer">
                    <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">Fechar</button>
                    <button type="button" class="btn btn-primary" id="btnNovoRepresentanteLegalSave">Gravar</button>
                </div>
            </form>
        </div>
    </div>
</div>