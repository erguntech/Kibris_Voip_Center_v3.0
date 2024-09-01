<!DOCTYPE html>
<!-- Author: ETech.X | Product Name: {{ Settings::get('app_title') }} | Product Version: {{ Settings::get('app_version') }} -->
<html lang="tr" data-bs-theme-mode="dark">
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

<body id="kt_body" class="app-blank bgi-size-cover bgi-position-center bgi-no-repeat">
    <div class="d-flex flex-column flex-root" id="kt_app_root">
        @yield('PageContent')
    </div>
    <script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
    <form id="logout-form" action="{{ route('logout') }}" method="POST">
        @csrf
    </form>
    @yield('PageVendorJS')
    @yield('PageCustomJS')
    <script>
        KTThemeMode.setMode("dark");
    </script>
</body>
</html>
