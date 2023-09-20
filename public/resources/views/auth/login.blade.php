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


<body >
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
        <div class="container-fluid h-100 vh-100" style="">
            <div class="row align-items-center">
                <div class="col-md-5 vh-100 h-100 bg-primary" style="margin-top: -2px; overflow: hidden; padding-left: 0 !important;" >
                    <p class="text-white font-size-181xl" style="line-height: 10rem; margin-left: -0.65rem">
                        <span class="font-dei-variable-sb">m</span><!--
                        --><span class="font-dei-grotesk">e</span><!--
                        --><span class="font-dei-variable-sl">i</span>
                    </p>
                    <p class="text-white font-size-181xl" style="line-height: 10rem; padding-left: 2.5rem; margin-left: -0.65rem">
                        <span class="font-dei-grotesk">m</span><!--
                        --><span class="font-dei-mixed">d</span><!--
                        --><span class="font-dei-variable-reg">m</span>
                    </p>
                    <p class="text-white font-size-181xl" style="line-height: 10rem; padding-left: 10.65rem; margin-left: -0.65rem">
                        <span class="font-dei-variable-light">m</span><!--
                        --><span class="font-dei-variable-sb">s</span><!--
                        --><span class="font-dei-variable-sl">i</span>
                    </p>
                    <p class="text-white font-size-181xl" style="line-height: 10rem; padding-left: 0.00rem; margin-left: -0.65rem">
                        <span class="font-dei-variable-sb">m</span><!--
                        --><span class="font-dei-variable-light">e</span><!--
                        --><span class="font-dei-variable-sb">c</span><!--
                        --><span class="font-dei-variable-sl">d</span>
                    </p>
                </div>
                <div class="col ">
                    <div class="card border-0 mx-auto my-auto" style="max-width: 50%;">
                        <div class="card-body text-primary">
                            <p class="card-title font-size-menu mb-3"><!--
                            --><span class="font-dei-variable-sb    ">l</span><!--
                            --><span class="font-dei-variable-sl    ">o</span><!--
                            --><span class="font-dei-mixed          ">g</span><!--
                            --><span class="font-dei-variable-reg   ">i</span><!--
                            --><span class="font-dei-grotesk        ">n</span><!--
                            -->
                            </p>
                              
                            <form id="loginForm" method="POST" action="{{ route('login.post') }}">
                                <div class="form-floating mb-3">
                                    <input type="email" class="form-control--dei " id="email" name="email"
                                        placeholder="email@example.com" value="{{ old('email') }}" required>
                                    <label for="email" class="form-label--dei">E-mail</label>
                                </div>
                                <div class="input-group mb-1">
                                    <div class="form-floating">
                                        <input type="password" class="form-control--dei " id="password" name="password"
                                            placeholder="Password" required>

                                        <label for="password" class="form-label--dei">Password</label>
                                    </div>
                                    <button 
                                        id="showPassword" 
                                        class="btn border-bottom border-primary border-top-0 border-end-0 border-start-0 border-2 "
                                        type="button"
                                        style="border-radius: 0; padding-top: 1.5rem !important">
                                            <i class="text-primary bi bi-eye-slash-fill" style="font-size: 1.0rem" id="showPasswordIcon"></i>
                                    </button>
                                </div>
                                <div class="row justify-content-end text-end mb-3">
                                    <div class="col">
                                        <a href="#" class="text-decoration-none text-primary">
                                            <span class="spaced-uppertext-dei">{{ __('auth.reset.forgot') }}</span>
                                        </a>
                                    </div>
                                </div>
                                <div class="row gx-2">
                                    <div class="d-grid col-md-5">
                                        <button class="btn btn-outline-primary form-btn-dei mb-3" type="submit" id="submitButton">
                                            <span class="spaced-uppertext-dei-bigger">{{ __('auth.login')}}</span><span class="spinner-border spinner-border-sm d-none" id="loginSpinner" role="status" aria-hidden="true" style="margin-left: 5px"></span>

                                          </button>
                                          
                                    </div>
                                    <div class="d-grid col-md-7">
                                        <a href="{{route('register')}}" id="submitButton" type="button"
                                            class="btn btn-outline-primary form-btn-dei mb-3">
                                            <span
                                                class="spaced-uppertext-dei-bigger">{{ __('auth.register.new.company') }}
                                            </span>
                                        </a>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>

                {{-- <p class="text-primary font-size-menu"><!--
                        --><span class="font-dei-variable-sb    ">l</span><!--
                        --><span class="font-dei-variable-sl    ">o</span><!--
                        --><span class="font-dei-mixed          ">g</span><!--
                        --><span class="font-dei-variable-reg   ">i</span><!--
                        --><span class="font-dei-grotesk        ">n</span><!--
                        -->
                    </p> --}}

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
    <script src="{{ asset('js/pages/login.js')}}" crossorigin="anonymous"></script>
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
</body>
<!-- end::Body -->

</html>
