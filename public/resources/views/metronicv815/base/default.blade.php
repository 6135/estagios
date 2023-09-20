<!DOCTYPE html>


<?php
function getSvgIcon($path, $class = '')
{
    // $rootPath = "/var/www/estagiosadminv2.dei.uc.pt/public/public/metronicv815/"; // project path
    // $rootPath = "/var/www/estagiosadminv2.dei.uc.pt/public/public/metronicv815/"; // project path
    if(env('APP_URL')=="https://estagios2dev.dei.uc.pt")
        $rootPath = "/var/www/estagiosadminv2.dei.uc.pt/public/public/metronicv815/"; // project path
    else 
        $rootPath = asset('/metronicv815/') . '/';
    $full_path = $rootPath . $path;

    //if ( !file_exists($full_path) ) {
    //    return "<!--SVG file not found: $full_path-->\n";
    //}

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


<!--
Template Name: Metronic - Responsive Admin Dashboard Template build with Twitter Bootstrap 4
Author: KeenThemes
Website: http://www.keenthemes.com/
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Dribbble: www.dribbble.com/keenthemes
Like: www.facebook.com/keenthemes
Purchase: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
Renew Support: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<html lang="en">
<!-- begin::Head -->

<head>
    @yield('styles')
    @include('metronicv815.layout.partials.head')
</head>
<!-- end::Head -->
<!-- end::Body -->

@if (empty(session()->get('leftmenuminimized')))
    @php
        session()->put('leftmenuminimized', 0);
    @endphp
@endif

{{-- @if (session()->get('leftmenuminimized') == 1) --}}
{{--    <body class="m-page--fluid m--skin- m-content--skin-light2 m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-light m-aside-left--offcanvas m-aside-left--minimize m-brand--minimize m-footer--push m-aside--offcanvas-default"> --}}
{{--    @else --}}
{{--        <body class="m-page--fluid m--skin- m-content--skin-light2 m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-light m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default"  > --}}
{{--        @endif --}}

<body id="kt_app_body" data-kt-app-layout="dark-sidebar" data-kt-app-header-fixed="true" data-kt-app-sidebar-enabled="true"
    data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-hoverable="true" data-kt-app-sidebar-push-header="true"
    data-kt-app-sidebar-push-toolbar="true" data-kt-app-sidebar-push-footer="true" data-kt-app-toolbar-enabled="true"
    class="app-default">
    <!--begin::Theme mode setup on page load-->
    <script>
        0
    </script>
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
    <div class="d-flex flex-column flex-root app-root" id="kt_app_root">
        <!--begin::Page-->
        <div class="app-page flex-column flex-column-fluid" id="kt_app_page">
            <!--begin::Header-->
            @include('metronicv815.layout.partials.header')
            <!--end::header-->
            <!--begin::Wrapper-->
            <div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
                <!--begin::Sidebar-->
                @include('metronicv815.layout.partials.leftnav')
                <!--end::Sidebar-->
                <!--begin::Main-->
                <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
                    <!--begin::Content wrapper-->
                    <div class="d-flex flex-column flex-column-fluid">
                        <!--begin::Content-->
                        <div id="kt_app_content" class="app-content flex-column-fluid">
                            <!--begin::Content container-->
                            <div id="kt_app_content_container" class="app-container container-xxl">
                                @yield('content')
                            </div>
                            <!--end::Content container-->
                        </div>
                        <!--end::Content-->
                    </div>
                    <!--end::Content wrapper-->
                    <!--begin::Footer-->
                    @include('metronicv815.layout.partials.footer')
                    <!--end::Footer-->
                </div>
                <!--end:::Main-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Page-->
        {{--    @include('metronicv815.layout.partials.sidebar') --}}
    </div>
    <!--end::App-->
    <!--begin::Base Scripts -->

    <script>
        var hostUrl = "assets/";
    </script>
    @yield('early_scripts')
    @if (!isset($custom_scripts))
        <script src="{{ asset('metronicv815/plugins/global/plugins.bundle.js') }}"></script>
        <script src="{{ asset('metronicv815/js/scripts.bundle.js') }}"></script>
        <script src="{{ asset('metronicv510/assets/demo/default/custom/components/base/toastr.js') }}" type="text/javascript">
        </script>
        <script src="{{ asset('js/jquery.serializejson.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/checkSession.js') }}" type="text/javascript"></script>
        <script src="{{ asset('metronicv815/plugins/custom/datatables/datatables.bundle.js') }}" type="text/javascript">
        </script>
    @endif
    {{--        @if (session()->get('isadmin')) --}}
    {{--            <script src="{{asset('js/superuser.js')}}" type="text/javascript"></script> --}}
    {{--        @endif --}}
    <!--end::Base Scripts -->
    <!--begin::Page Resources -->
    @yield('scripts')
    <!--end::Page Resources -->
</body>
<!-- end::Body -->

</html>
