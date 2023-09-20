<!DOCTYPE html>

<?php
function getSvgIcon($path, $class = '')
{
    $rootPath = '/var/www/estagiosadminv2.dei.uc.pt/public/public/metronicv815/'; // project path

    $full_path = $rootPath . $path;

    if (!file_exists($full_path)) {
        return "<!--SVG file not found: $full_path-->\n";
    }

    $cls = ['svg-icon'];

    if (!empty($class)) {
        $cls = array_merge($cls, explode(' ', $class));
    }

    $svg_content = file_get_contents($full_path);

    $output = "<!--begin::Svg Icon | path: $path-->\n";
    $output .= "<span class=\"" . implode(' ', $cls) . "\">" . $svg_content . '</span>';
    $output .= "\n<!--end::Svg Icon-->";

    return $output;
}
?>


<html lang="{{ app()->getLocale() }}">

<head>

    <meta charset="utf-8" />
    <title>{{ env('APP_TITLE') }}</title>
    <meta name="description" content="Initialized via remote ajax json data">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Includes bootstrap and custom sass for DEI colors --}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/toastr.min.css') }}">



    <link rel="stylesheet" href="{{ asset('bootstrap/icons/font/bootstrap-icons.css') }}">

</head>


@if (empty(session()->get('leftmenuminimized')))
    @php
        session()->put('leftmenuminimized', 0);
    @endphp
@endif


<body>
    <script>
        var defaultThemeMode = "light";
        var themeMode;
        if (document.documentElement) {
            if (document.documentElement.hasAttribute("data-theme-mode")) {
                themeMode = document.documentElement.getAttribute("data-theme-mode");
            } else {
                if (localStorage.getItem("data-theme") !== null) {
                    themeMode = localStorage.getItem("data-theme");
                } else {
                    themeMode = defaultThemeMode;
                }
            }
            if (themeMode === "system") {
                themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
            }
            document.documentElement.setAttribute("data-theme", themeMode);
        }
    </script>
    <noscript>
        <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5FS8GGP" height="0" width="0"
            style="display:none;visibility:hidden"></iframe>
    </noscript>

    <div aria-live="polite" aria-atomic="true" class="position-relative">
        <div class="container-fluid" style="">
            <div class="row align-items-top">

                
                <div class="col-md-4 bg-primary"
                    style="margin-top: -2px; overflow: hidden; padding-left: 0 !important; position: sticky; min-height: max-content;">
                    <p class="text-white font-size-181xl" style="line-height: 10rem; margin-left: -0.65rem">
                        <span class="font-dei-variable-sb">m</span><!--
                        --><span class="font-dei-grotesk">e</span><!--
                        --><span class="font-dei-variable-sl">i</span>
                    </p>
                    <p class="text-white font-size-181xl"
                        style="line-height: 10rem; padding-left: 2.5rem; margin-left: -0.65rem">
                        <span class="font-dei-grotesk">m</span><!--
                        --><span class="font-dei-mixed">d</span><!--
                        --><span class="font-dei-variable-reg">m</span>
                    </p>
                    <p class="text-white font-size-181xl"
                        style="line-height: 10rem; padding-left: 10.65rem; margin-left: -0.65rem">
                        <span class="font-dei-variable-light">m</span><!--
                        --><span class="font-dei-variable-sb">s</span><!--
                        --><span class="font-dei-variable-sl">i</span>
                    </p>
                    <p class="text-white font-size-181xl"
                        style="line-height: 10rem; padding-left: 0.00rem; margin-left: -0.65rem">
                        <span class="font-dei-variable-sb">m</span><!--
                        --><span class="font-dei-variable-light">e</span><!--
                        --><span class="font-dei-variable-sb">c</span><!--
                        --><span class="font-dei-variable-sl">d</span>
                    </p>
                    <p class="text-white font-size-181xl"
                    style="line-height: 10rem; padding-left: 0.00rem; margin-left: -0.65rem">
                    <span class="font-dei-variable-sb">a</span><!--
                    --><span class="font-dei-variable-light">o</span><!--
                    --><span class="font-dei-variable-sb">r</span>
                    </p>
                </div>
                <div class="col" style="margin-top: 0.75rem">
                    <div class="card border-0 mx-auto my-auto" style="max-width: 57.5rem;">
                        <div class="card-body mx-0 px-0 pb-0 mb-2">
                            <p class="card-title header-text-1 mb-3 fwd-600">{{__('company.data.data')}}</p>
                            <form id="companyConfirmForm" method="POST" action="{{ route('empresa.confirmar.post') }}">
                                <input type="hidden" name="hash" value="{{$user->confirmacao_hash}}" required disabled>
                                <div class="mb-3 row">
                                    <div class="fv-row col-md-8">
                                        <label for="nomeempresa"
                                            class="sub-header-text-5 mb-1 text-primary required">{{ __('company.data.name') }}</label>
                                        <input type="text" class="form-control--dei form-control-lg full-border "
                                            id="nomeempresa" name="nomeempresa" placeholder=" " value="{{ old('nomeempresa') }}"
                                            required max="512">
                                    </div>
                                    <div class="fv-row col-md">
                                        <label for="acronimo"
                                            class="sub-header-text-5 mb-1 text-primary required">{{ __('company.data.acronym') }}</label>
                                        <input type="text" class="form-control--dei form-control-lg full-border "
                                            id="acronimo" name="acronimo" placeholder=" " value="{{ old('acronimo') }}"
                                            required max="128">
                                    </div>
                                </div>
                                <div class="mb-3 fv-row px-0">
                                    <label for="morada"
                                        class="sub-header-text-5 mb-1 text-primary required">{{ __('company.data.address') }}</label>
                                    <textarea type="text" class="form-control--dei form-control-lg full-border "
                                        id="morada" name="morada" placeholder=" " value="{{ old('morada') }}"
                                        required style="resize: none" maxlength="512" rows="1"> </textarea>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md">
                                        <div class="fv-row">
                                            <label for="pais_codigo_iso"
                                                class="sub-header-text-5 mb-1 text-primary required">{{ __('company.data.country') }}</label>
                                            <select class="form-select--dei form-select-lg full-border " aria-label="Default select example"
                                                id="pais_codigo_iso" name="pais_codigo_iso" style="padding-bottom: 0.44rem;" required>
                                                <!-- Empty option -->
                                                <option class="body-text-2" value="" @if (old('pais_codigo_iso') == "") selected @endif disabled hidden>{{ __('student.select.country') }}</option>
                                                @foreach (App\Models\Pais::getCountries() as $country)
                                                    <option class="body-text-2" value="{{ $country['codigo_iso'] }}"
                                                        data-phone-code="{{ $country['codigo_tel'] }}"
                                                        {{old('pais_codigo_iso')}}>
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
                                                name="telefone" placeholder=" " value="{{ old('telefone') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md">
                                        <!-- Nif -->
                                        <div class="fv-row">
                                            <label for="nif"
                                                class="sub-header-text-5 mb-1 text-primary required">{{ __('company.data.nif') }}</label>
                                            <input type="text" class="form-control--dei form-control-lg full-border" id="nif"
                                                name="nif" placeholder=" " value="{{ old('nif') }}" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="fv-row px-0 mb-3 ">
                                    <label for="atividade"
                                        class="sub-header-text-5 mb-1 text-primary required">{{ __('company.data.activity') }}</label>
                                    <textarea type="text" class="form-control--dei form-control-lg full-border "
                                        id="atividade" name="atividade"
                                        required style="resize: none" maxlength="1024" rows="1">{{old('atividade')}}</textarea>
                                </div>
                                <div class="fv-row mb-3">
                                    <label for="url"
                                        class="sub-header-text-5 mb-1 text-primary">{{ __('company.data.website') }}</label>
                                    <input type="url" class="form-control--dei form-control-lg full-border "
                                        id="url" name="url" placeholder=" " value="{{ old('url') }}"
                                        required max="128">
                                </div>

                                <p class="sub-header-text-5 mb-1 text-primary">
                                    {{__('company.data.manager.manager')}}
                                </p>
                                <div class="mb-3 row">
                                    <div class="fv-row col-md-6">
                                        <label for="nome"
                                            class="sub-header-text-5 mb-1 text-primary required fwd-400" style="font-weight: 400">{{ __('company.data.manager.name') }}</label>
                                        <input type="text" class="form-control--dei form-control-lg full-border "
                                            id="nome" name="nome" placeholder=" " value="{{ old('nome') }}"
                                            required max="512">
                                    </div>
                                    <div class="fv-row col-md">
                                        <label for="cargo"
                                            class="sub-header-text-5 mb-1 text-primary required fwd-400" style="font-weight: 400">{{ __('company.data.manager.position') }}</label>
                                        <input type="text" class="form-control--dei form-control-lg full-border "
                                            id="cargo" name="cargo" placeholder=" " value="{{ old('cargo') }}"
                                            required max="128">
                                    </div>
                                </div>
                                <p class="sub-header-text-5 mb-1 text-primary">
                                    {{__('company.data.legalrep.legalrep')}}
                                </p>
                                <div class="mb-3 row">
                                    <div class="fv-row col-md-6">
                                        <label for="nome_representante_legal"
                                            class="sub-header-text-5 mb-1 text-primary required fwd-400" style="font-weight: 400">{{ __('company.data.legalrep.name') }}</label>
                                        <input type="text" class="form-control--dei form-control-lg full-border "
                                            id="nome_representante_legal" name="nome_representante_legal" placeholder=" " value="{{ old('nome_representante_legal') }}"
                                            required max="512">
                                    </div>
                                    <div class="fv-row col-md">
                                        <label for="cargo_representante_legal"
                                            class="sub-header-text-5 mb-1 text-primary required fwd-400" style="font-weight: 400">{{ __('company.data.legalrep.position') }}</label>
                                        <input type="text" class="form-control--dei form-control-lg full-border "
                                            id="cargo_representante_legal" name="cargo_representante_legal" placeholder=" " value="{{ old('cargo_representante_legal') }}"
                                            required max="128">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <div class="fv-row col-md-6">
                                        <label for="email"
                                            class="sub-header-text-5 mb-1 text-primary required fwd-400" style="font-weight: 400">{{ __('company.data.legalrep.email') }}</label>
                                        <input type="email" class="form-control--dei form-control-lg full-border "
                                            id="email" name="email" placeholder=" " value="{{ old('email') }}"
                                            required max="512">
                                    </div>
                                    <div class="fv-row col-md-6">
                                        <label for="phone"
                                            class="sub-header-text-5 mb-1 text-primary required fwd-400" style="font-weight: 400">{{ __('company.data.legalrep.phone') }}</label>
                                        <input type="phone" class="form-control--dei form-control-lg full-border "
                                            id="phone" name="phone" placeholder=" " value="{{ old('phone') }}"
                                            required max="512">
                                    </div>
                                </div>
                                <div class="row gx-2">
                                    <div class="d-grid col-md"></div>
                                    <div class="d-grid col-md-3">
                                        <button id="submitButton" type="button"
                                            class="btn btn-outline-primary form-btn-dei mb-3">
                                            <span class="spaced-uppertext-dei-bigger">{{ __('auth.register.new.create_company') }}
                                            </span>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
    <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
        <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
            <path
                d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
        </symbol>
        <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
            <path
                d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />
        </symbol>
        <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
            <path
                d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
        </symbol>
    </svg>
    <div class="toast-container top-0 end-0 p-3" id="toastContainer">

        <!-- Then put toasts within -->

    </div>
    </div>



    <script>
        var hostUrl = "assets/";
    </script>
    <script src="{{ asset('js/jquery-3.7.0.min.js') }}" crossorigin="anonymous"></script>
    <script src="{{ asset('bootstrap/js/bootstrap.js') }}" crossorigin="anonymous"></script>
    <script src="{{ asset('js/toastr.min.js') }}" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/es6-shim/0.35.3/es6-shim.min.js"></script>
    <script src="{{ asset('js/formvalidation/FormValidation.full.js') }}" crossorigin="anonymous"></script>
    <!-- Auto Focus plugin -->
    <script src="{{ asset('js/formvalidation/plugins/AutoFocus.js') }}" crossorigin="anonymous"></script>
    <!-- Bootstrap 5 plugin -->
    <script src="{{ asset('js/formvalidation/plugins/Bootstrap5.js') }}" crossorigin="anonymous"></script>
    <script src="{{ asset('js/bs-maxlength/bootstrap-maxlength.min.js') }}" crossorigin="anonymous"></script>

    <script>
        const locale = "{{ app()->getLocale() }}";
        const localizedMessages = {
            empresa: {
                nomeempresa: {
                    required: "{{ __('validation.required', ['attribute' => __('company.data.name')]) }}",
                    between: "{{ __('validation.between.string', ['attribute' => __('company.data.name'), 'max' => 512, 'min' => 3]) }}",
                },
                acronimo: {
                    required: "{{ __('validation.required', ['attribute' => __('company.data.acronym')]) }}",
                    between: "{{ __('validation.between.string', ['attribute' => __('company.data.acronym'), 'max' => 16, 'min' => 1]) }}",
                },
                morada: {
                    required: "{{ __('validation.required', ['attribute' => __('company.data.address')]) }}",
                    between: "{{ __('validation.between.string', ['attribute' => __('company.data.address'), 'max' => 512, 'min' => 8]) }}",
                },
                pais_codigo_iso: {
                    required: "{{ __('validation.required', ['attribute' => __('company.data.country')]) }}",
                    notexists: "{{ __('validation.exists', ['attribute' => __('company.data.country')]) }}" 

                },
                telefone: {
                    required: "{{ __('validation.required', ['attribute' => __('company.data.phone')]) }}",
                },
                nif: {
                    required: "{{ __('validation.required', ['attribute' => __('company.data.nif')]) }}",
                    unique: "{{ __('validation.unique', ['attribute' => __('company.data.nif')]) }}",
                },
                atividade: {
                    required: "{{ __('validation.required', ['attribute' => __('company.data.activity')]) }}",
                    between: "{{ __('validation.between.string', ['attribute' => __('company.data.activity'), 'max' => 1024, 'min' => 8]) }}",
                },
                url: {
                    url: "{{ __('validation.url', ['attribute' => __('company.data.website')]) }}",
                },
                
            },
            gestor: {
                nome: {
                    required: "{{ __('validation.required', ['attribute' => __('company.data.manager.name')]) }}",
                    max: "{{ __('validation.max.string', ['attribute' => __('company.data.manager.name'), 'max' => 255]) }}",

                },
                cargo: {
                    required: "{{ __('validation.required', ['attribute' => __('company.data.manager.position')]) }}",
                    max: "{{ __('validation.max.string', ['attribute' => __('company.data.manager.position'), 'max' => 128]) }}",
                },
            },
            legalrep: {
                nome_representante_legal: {
                    required: "{{ __('validation.required', ['attribute' => __('company.data.legalrep.name')]) }}",
                    max: "{{ __('validation.max.string', ['attribute' => __('company.data.legalrep.name'), 'max' => 255]) }}",

                },
                cargo_representante_legal: {
                    required: "{{ __('validation.required', ['attribute' => __('company.data.legalrep.position')]) }}",
                    max: "{{ __('validation.max.string', ['attribute' => __('company.data.legalrep.position'), 'max' => 128]) }}",
                },
                email: {
                    required: "{{ __('validation.required', ['attribute' => __('company.data.legalrep.email')]) }}",
                    email: "{{ __('validation.email', ['attribute' => __('company.data.legalrep.email')]) }}",
                    max: "{{ __('validation.max.string', ['attribute' => __('company.data.legalrep.email'), 'max' => 512]) }}",
                },
                phone: {
                    required: "{{ __('validation.required', ['attribute' => __('company.data.legalrep.phone')]) }}",
                    max: "{{ __('validation.max.string', ['attribute' => __('company.data.legalrep.phone'), 'max' => 32]) }}",
                },
            }


        }

        const paises = @json(App\Models\Pais::getCountries());
    </script>
    <script src="{{ asset('js/pages/empresa/confirmData.js') }}" crossorigin="anonymous"></script>
    <script>
        toastr.options.closeButton = true;
        toastr.options.closeMethod = 'fadeOut';
        toastr.options.closeDuration = 3000;
        toastr.options.closeEasing = 'swing';
        toastr.options.newestOnTop = false;
        toastr.options.preventDuplicates = true;
        toastr.options.progressBar = true;
        toastr.options.showDuration = 10;
        toastr.options.hideDuration = 10;
    </script>
    <script>
         $(document).ready(function() {
            /*
            *@see https://github.com/mimo84/bootstrap-maxlength
            */
            $('[maxlength]').maxlength({
                alwaysShow: true,
                showOnReady: true,
                appendToParent: true,
            });
        });
    </script>
</body>
<!-- end::Body -->

</html>
