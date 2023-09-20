<div class="offcanvas offcanvas-end " tabindex="-1" id="offcanvasDadosEmpresa" aria-labelledby="offcanvasLabel"
    style="width: 70%">
    <div class="offcanvas-header">
        {{-- <h5 class="offcanvas-title" id="offcanvasLabel">Offcanvas</h5> --}}
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="card border-0 ">
            <div class="card-body">
                <h5 class="card-title header-text-1">{{ __('company.data.data_edit') }}</h5>
                <br>
                <form id="empresaDataForm" method="POST" action="{{ route('empresa.dados.editar.post') }}"
                    class="needs-validation">
              
                    <!-- Nome Empresa -->
                    <div class="mb-3">

                        <div class="row">
                            <div class="col-md-8 fv-row">
                                <label for="nomeempresa"
                                    class="sub-header-text-5 mb-1 text-primary required">{{ __('company.data.name') }}</label>
                                <input type="text" class="form-control--dei form-control-lg full-border "
                                    id="nomeempresa" name="nomeempresa" placeholder=" "
                                    value="{{old('nomeempresa',$empresa->nomeempresa)}}" required>
                            </div>
                            <div class="col-md fv-row">
                                <label for="acronimo"
                                    class="sub-header-text-5 mb-1 text-primary">{{ __('company.data.acronym') }}</label>
                                <input type="text" class="form-control--dei form-control-lg full-border "
                                    id="acronimo" name="acronimo" placeholder=" " value="{{old('acronimo', $empresa->acronimo )}}"
                                    required>
                            </div>
                        </div>
                    </div>
                    <!-- Morada -->
                    <div class="mb-3 fv-row">
                        <label for="morada"
                            class="sub-header-text-5 mb-1 text-primary required">{{ __('company.data.address') }}</label>
                        <textarea type="text" class="form-control--dei form-control-lg full-border " id="morada" name="morada"
                            placeholder=" " value="" required style="resize: none" maxlength="512" rows="1">{{old('morada',$empresa->morada)}}</textarea>
                    </div>
                    <!-- Country -->
                    <div class="row mb-3">
                        <div class="col-md">
                            <div class="fv-row">
                                <label for="pais_codigo_iso"
                                    class="sub-header-text-5 mb-1 text-primary required">{{ __('company.data.country') }}</label>
                                <select class="form-select--dei form-select-lg full-border " aria-label="Default select example"
                                    id="pais_codigo_iso" name="pais_codigo_iso" style="padding-bottom: 0.44rem;" required>
                                    <!-- Empty option -->
                                    <option class="body-text-2" value="" @if ($empresa->pais_codigo_iso == "") selected @endif disabled hidden>{{ __('student.select.country') }}</option>
                                    @foreach (App\Models\Pais::getCountries() as $country)
                                        <option class="body-text-2" value="{{ $country['codigo_iso'] }}"
                                            data-phone-code="{{ $country['codigo_tel'] }}"
                                            @if(old('pais_codigo_iso',$empresa->pais_codigo_iso) == $country['codigo_iso']) selected @endif >
                                            {{ $country['nome'] }}</option>
                                    @endforeach

                                </select>
                            </div>
                        </div>
                        <div class="col-md">
                            <!-- Phone -->
                            <div class="fv-row">
                                <label for="telefone"
                                    class="sub-header-text-5 mb-1 text-primary required">{{ __('company.data.phone') }}</label>
                                <input type="tel" class="form-control--dei form-control-lg full-border" id="telefone"
                                    name="telefone" placeholder=" " value="{{ old('telefone',$empresa->telefone) }}" required>
                            </div>
                        </div>
                    </div>
                    <!-- atividade --> 
                    <div class="fv-row px-0 mb-3 ">
                        <label for="atividade"
                            class="sub-header-text-5 mb-1 text-primary required">{{ __('company.data.activity') }}</label>
                        <textarea type="text" class="form-control--dei form-control-lg full-border "
                            id="atividade" name="atividade"
                            required style="resize: none" maxlength="1024" rows="1">{{old('atividade',$empresa->atividade)}}</textarea>
                    </div>
                    <!-- Website-->
                    <div class="fv-row mb-3">
                        <label for="url"
                            class="sub-header-text-5 mb-1 text-primary">{{ __('company.data.website') }}</label>
                        <input type="url" class="form-control--dei form-control-lg full-border "
                            id="url" name="url" placeholder=" " value="{{ old('url',$empresa->url) }}"
                            required max="128">
                    </div>

                    <div class="d-block flex-nowrap justify-content-end d-md-flex">
                        <div class="order-2">
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
