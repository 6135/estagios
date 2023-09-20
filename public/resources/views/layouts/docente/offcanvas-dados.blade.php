<div class="offcanvas offcanvas-end " tabindex="-1" id="offcanvasDadosDocente" aria-labelledby="offcanvasLabel" style="width: 70%">
    <div class="offcanvas-header">
        {{-- <h5 class="offcanvas-title" id="offcanvasLabel">Offcanvas</h5> --}}
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="card border-0 " style="width: 50%">
            <div class="card-body">
                <h5 class="card-title header-text-1">{{ __('professor.personal.data') }}</h5>
                <br>
                <form id="docenteDataForm" method="POST" action="{{ route('docente.dados.editar.post')}}" class="needs-validation">
                    <!-- Nome Completo -->
                    <div class="mb-3 fv-row ">
                        <label for="nome"
                            class="sub-header-text-5 mb-1 text-primary ">{{ __('professor.full.name') }}</label>
                            <input type="text" class="form-control--dei full-border " id="nome" name="nome"
                                placeholder=" " value="{{ old('nome', session()->get('user')->nome) }}" required>
                    </div>
                    <!-- Nome Curto -->
                    <div class="mb-3 fv-row">
                        <label for="nome_curto"
                            class="sub-header-text-5 mb-1 text-primary">{{ __('professor.short.name') }}</label>
                        <input type="text" class="form-control--dei full-border " id="nome_curto" name="nome_curto"
                            placeholder=" " value="{{ old('nome_curto',session()->get('user')->getShortName()) }}" required>
                    </div>
                    <!-- Email -->
                    <label for="email"
                        class="sub-header-text-5 mb-1 text-primary">{{ __('professor.email') }}</label>
                    <input type="email" class="form-control--dei full-border mb-3" id="email" name="email"
                        placeholder=" " value="{{ old('email', session()->get('user')->email . '@dei.uc.pt') }}"
                        required disabled>

                    <!-- Area especialidade select-->
                    <div class="mb-4 fv-row">
                        <label for="especializacao_nome"
                            class="sub-header-text-5 mb-1 text-primary">{{ trans_choice('professor.specialty', 1) }}</label>
                        <select class="form-select  form-control--dei full-border" aria-label="Default select example"
                            id="especializacao_nome" name="especializacao_nome" required>
                            <!-- Empty option -->
                            <option class="body-text-2" value="" selected disabled hidden>
                                {{ trans_choice('professor.select.specialty', 1) }}</option>
                            @php
                                //get all specialties from active courses
                                
                                //get all specialties from active courses
                                $especialidades = \App\Models\Especializacao::getActiveEspecializacoes();
                                
                            @endphp
                            @foreach ($especialidades as $especialidade)
                                <option class="body-text-2" value="{{ $especialidade->nome }}"
                                    {{ old('especializacao_nome',optional(session()->get('user')->docente())->especializacao_nome) == $especialidade->nome? 'selected': '' }}>
                                    {{ $especialidade->nome }}</option>
                            @endforeach

                        </select>
                    </div>
                    <div class="row gx-2">
                        <div class="d-grid col-md-5">
                            <button class="btn btn-outline-primary form-btn-dei mb-3" type="submit" id="submitButton">
                                <span class="spaced-uppertext-dei-bigger">{{ __('words.save') }}</span><span
                                    class="spinner-border spinner-border-sm d-none" id="loginSpinner" role="status"
                                    aria-hidden="true" style="margin-left: 5px"></span>

                            </button>

                        </div>
                    </div>
                </form>
                
            </div>
        </div>
    </div>
</div>
