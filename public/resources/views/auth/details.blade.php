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
        <iframe src="https://www.googletagcolab.com/ns.html?id=GTM-5FS8GGP" height="0" width="0"
            style="display:none;visibility:hidden"></iframe>
    </noscript>

    <div aria-live="polite" aria-atomic="true" class="position-relative">
        <div class="container-fluid" style="">
            <div class="row align-items-top">

                
                <div class="col-md-4 bg-primary v-100 vh-100"
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
                </div>
                <div class="col" style="margin-top: 0.75rem">
                    <div class="card border-0 mx-auto my-auto" style="max-width: 57.5rem;">
                        <div class="card-body mx-0 px-0 pb-0 mb-2">
                            <p class="card-title header-text-1 mb-3 fwd-600">{{__('company.data.colab.data')}}</p>
                            <form id="colabConfirmForm" method="POST" action="{{ route('colab.confirmar.post') }}" enctype="multipart/form-data">
                                                                     
                                <input type="text" name="hash" value="{{$user->confirmacao_hash}}" required hidden>
                                <div class="fv-row mb-3">
                                    <label for="nome"
                                        class="sub-header-text-5 mb-1 text-primary required">{{ __('company.data.colab.name') }}</label>
                                    <input type="text" class="form-control--dei form-control-lg full-border "
                                        id="nome" name="nome" placeholder=" " value="{{ old('nome',$user->nome) }}"
                                        required max="512">
                                </div>
                                <div class="mb-3 row">
                                    <div class="fv-row col-md-6">
                                        <label for="telefone"
                                            class="sub-header-text-5 mb-1 text-primary required">{{ __('company.data.colab.phone') }}</label>
                                        <input type="phone" class="form-control--dei form-control-lg full-border "
                                            id="telefone" name="telefone" placeholder=" " value="{{ old('telefone',$user->telefone) }}"
                                            required max="255">
                                    </div>
                                    <div class="fv-row col-md">
                                        <label for="cargo"
                                            class="sub-header-text-5 mb-1 text-primary required">{{ __('company.data.colab.position') }}</label>
                                        <input type="text" class="form-control--dei form-control-lg full-border "
                                            id="cargo" name="cargo" placeholder=" " value="{{ old('cargo',) }}"
                                            required max="255">
                                    </div>
                                </div>
                                @if($dataToAdd['Colab'])
                                    <div class="row mb-3">
                                        <div class="col-md-6 fv-row">
                                            <label for="formacao"
                                            class="sub-header-text-5 mb-1 text-primary required">{{ __('company.data.colab.training') }}</label>
                                            <select class="form-select--dei form-select-lg full-border " aria-label="Default select example"
                                                id="formacao" name="formacao" style="padding-bottom: 0.44rem;">
                                                <!-- Empty option -->
                                                <option class="body-text-2" value="" selected disabled hidden></option>
                                                @foreach (App\Models\Colaborador::getFormacao() as $formacao)
                                                    <option class="body-text-2" value="{{ $formacao['nome'] }}"
                                                        {{old('formacao')}}>
                                                        {{ $formacao['nome'] }}</option>
                                                @endforeach

                                            </select>
                                        </div>
                                        <div class="col-md-6 fv-row">
                                            <label for="anosexperiencia"
                                            class="sub-header-text-5 mb-1 text-primary required">{{ __('company.data.colab.yearsExp') }}</label>
                                            <input type="number" class="form-control--dei form-control-lg full-border " aria-label="Default select example"
                                                id="anosexperiencia" name="anosexperiencia" style="padding-bottom: 0.44rem;" max="50" min="0">
                                            
                                        </div>
                                    </div>
                                @endif
                                <div class="row gx-2">
                                    <div class="d-grid col-md-5 fv-row">
                                        @if($dataToAdd['Colab'])
                                            <label for="cv" class="sub-header-text-5 mb-1 text-primary required">{{__('company.data.colab.cv')}}</label>
                                            <input type="file" accept="application/pdf" id="cv" name="cv" class="btn btn-outline-primary form-btn-dei mb-3">
                                        @endif
                                    </div>
                                    <div class="d-grid col-md"> </div>
                                    <div class="d-grid col-md-3">
                                        <label for="cv" class="sub-header-text-5 mb-1 text-primary"><br></label>

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
            nome: {
                required: "{{ __('validation.required', ['attribute' => __('company.data.colab.name')]) }}",
                max: "{{ __('validation.max.string', ['attribute' => __('company.data.colab.name'), 'max' => 255]) }}",
            },
            cargo: {
                required: "{{ __('validation.required', ['attribute' => __('company.data.colab.position')]) }}",
                max: "{{ __('validation.max.string', ['attribute' => __('company.data.colab.position'), 'max' => 128]) }}",
            },
            telefone: {
                required: "{{ __('validation.required', ['attribute' => __('company.data.colab.phone')]) }}",
                max: "{{ __('validation.max.string', ['attribute' => __('company.data.colab.phone'), 'max' => 255]) }}",
            },
            formacao: {
                required: "{{ __('validation.required', ['attribute' => __('company.data.colab.training')]) }}",
                notexists: "{{ __('validation.exists', ['attribute' => __('company.data.colab.formacao')]) }}" 
            },
            anosexperiencia:{
                required: "{{ __('validation.required', ['attribute' => __('company.data.colab.yearsExp')]) }}",
                between: "{{ __('validation.between.numeric', ['attribute' => __('company.data.colab.yearsExp'), 'min' => 0, 'max' => 50]) }}" 
            },
            password: {
                required: "{{ __('validation.required', ['attribute' => __('auth.register.password.password')]) }}",
                min: "{{ __('validation.min.string', ['attribute' => __('auth.register.password.password'), 'min' => 8]) }}", 
            },
            password_confirmation: {
                required: "{{ __('validation.required', ['attribute' => __('auth.register.password.passwordconfirmation')]) }}",
                min: "{{ __('validation.min.string', ['attribute' => __('auth.register.password.passwordconfirmation'), 'min' => 8]) }}", 
                same: "{{ __('validation.same', ['attribute' => __('auth.register.password.passwordconfirmation'), 'other' => __('auth.register.password.password')]) }}"
            },
            cv: {
                required: "{{ __('validation.required', ['attribute' => __('company.data.colab.cv')]) }}",
                max: "{{ __('validation.max.file', ['attribute' => __('company.data.colab.cv'), 'max' => 10000]) }}",
                mimes: "{{ __('validation.mimes', ['attribute' => __('company.data.colab.cv'), 'values' => 'pdf']) }}",
            },
        }
        const and = "{{ __('words.and') }}";
        const formacao = @json(App\Models\Colaborador::getFormacao());
    </script>
    <script src="{{ asset('js/pages/empresa/confirmColab.js') }}" crossorigin="anonymous"></script>
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
