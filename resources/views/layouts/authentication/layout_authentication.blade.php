<!DOCTYPE html>
<!-- Author: ETech.X | Product Name: {{ Settings::get('app_title') }} | Product Version: {{ Settings::get('app_version') }} -->
<html lang="tr" >
<head><base href=""/>
    <title>{{ Settings::get('app_alias') }} | @yield('PageTitle')</title>
    @include('layouts.application.partials.partial_meta')
    <link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet" type="text/css" />
    @yield('PageVendorCSS')
    @yield('PageCustomCSS')
    <script> if (window.top != window.self) { window.top.location.replace(window.self.location.href); } </script>
</head>

<body id="kt_body" class="app-blank">
    <div class="d-flex flex-column flex-root" id="kt_app_root">
        @yield('PageContent')
    </div>
    <script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
    <script>
        KTThemeMode.setMode("dark");
    </script>
    @yield('PageVendorJS')
    @yield('PageCustomJS')
</body>
</html>
