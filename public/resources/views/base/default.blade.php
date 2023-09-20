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
<!-- begin::Head -->

<head>
    <!-- dei.css stylesheet -->

    @if (View::hasSection('styles'))
        @yield('styles')
    @endif

    @include('layouts.head')

</head>
<!-- end::Head -->
<!-- end::Body -->

@if (empty(session()->get('leftmenuminimized')))
    @php
        session()->put('leftmenuminimized', 0);
    @endphp
@endif

<body>
    <!--begin::Theme mode setup on page load-->
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
    <!--end::Theme mode setup on page load-->
    <!--Begin::Google Tag Manager (noscript) -->
    <noscript>
        <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5FS8GGP" height="0" width="0"
            style="display:none;visibility:hidden"></iframe>
    </noscript>
    <!--End::Google Tag Manager (noscript) -->

    <!--begin::App-->
    @include('layouts.header')
    <div class="container-fluid"
        style="margin-top: var(--navbar-padding-y); padding-left: var(--container-padding); padding-right: var(--container-padding)">
        @yield('content')

    </div>
    @yield('modals')
    @yield('offcanvas')
    @include('layouts.sidebar')
    {{-- @include('layouts.footer') --}}

    <!--end::App-->
    <!--begin::Base Scripts -->

    <script>
        var hostUrl = "assets/";
    </script>
    @yield('early_scripts')


    <!--begin::Page Resources -->
    <script src="{{ asset('js/jquery-3.7.0.min.js') }}" crossorigin="anonymous"></script>
    <script src="{{ asset('bootstrap/js/bootstrap.bundle.js') }}" crossorigin="anonymous"></script>
    <script src="{{ asset('js/toastr.min.js') }}" crossorigin="anonymous"></script>
    <script src="{{ asset('js/select2/select2.full.min.js') }}" crossorigin="anonymous"></script>
    <script src="{{ asset('js/select2/i18n/pt.js') }}" crossorigin="anonymous"></script>
    <script src="{{ asset('js/select2/i18n/en.js') }}" crossorigin="anonymous"></script>
    <script src="{{ asset('js/select2/i18n/es.js') }}" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/es6-shim/0.35.3/es6-shim.min.js"></script>
    <script src="{{ asset('js/formvalidation/FormValidation.full.js') }}" crossorigin="anonymous"></script>
    <!-- Auto Focus plugin -->
    <script src="{{ asset('js/formvalidation/plugins/AutoFocus.js') }}" crossorigin="anonymous"></script>
    <!-- Bootstrap 5 plugin --> 
    <script src="{{ asset('js/formvalidation/plugins/Bootstrap5.js') }}" crossorigin="anonymous"></script>
    <!-- DataTables  -->
    <script src="{{ asset('DataTables/datatables.min.js') }}"></script>
    {{-- <script src="{{ asset('metronicv815/plugins/custom/datatables/datatables.bundle.js') }}" type="text/javascript"> --}}


    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    @yield('scripts')
    <!--end::Page Resources -->
</body>
<!-- end::Body -->

</html>
