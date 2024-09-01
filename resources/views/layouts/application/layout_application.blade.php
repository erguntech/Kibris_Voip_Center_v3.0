<!DOCTYPE html>
<!-- Author: ETech.X | Product Name: {{ Settings::get('app_title') }} | Product Version: {{ Settings::get('app_version') }} -->
@php
    use App\Models\CallCenterClient;
    if (\Illuminate\Support\Facades\Auth::user()->user_type == 4) {
        $isNewAssigns = true;
        $newAssignedNumberCount = CallCenterClient::where('assigned_user_id', Auth::user()->id)->where('status', 0)->get()->count();
    } else {
        $isNewAssigns = false;
    }
@endphp
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

    <body id="kt_app_body" data-kt-app-page-loading-enabled="true" data-kt-app-page-loading="on" data-kt-app-layout="dark-sidebar" data-kt-app-header-fixed="true" data-kt-app-sidebar-enabled="true" data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-push-header="true" data-kt-app-sidebar-push-toolbar="true" data-kt-app-sidebar-push-footer="true"  class="app-default" >
        @include('layouts.application.partials.partial_theme')
        @include('layouts.application.partials.partial_page_loader')
        <div class="d-flex flex-column flex-root app-root" id="kt_app_root">
            <div class="app-page flex-column flex-column-fluid" id="kt_app_page">
                @include('layouts.application.partials.partial_header')
                <div class="app-wrapper flex-column flex-row-fluid " id="kt_app_wrapper">
                    @include('layouts.application.partials.partial_sidebar')
                    <div class="app-main flex-column flex-row-fluid " id="kt_app_main">
                        <div class="d-flex flex-column flex-column-fluid">
                            <div id="kt_app_content" class="app-content flex-column-fluid" style="padding-top: 20px !important;">
                                <div id="kt_app_content_container" class="app-container container-fluid">
                                    @yield('PageContent')
                                </div>
                            </div>
                        </div>
                        @include('layouts.application.partials.partial_footer')
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.application.partials.partial_scroll_to_top')
        <form id="logout-form" action="{{ route('logout') }}" method="POST">
            @csrf
        </form>
        <script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
        <script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
        <script src="{{ asset('assets/js/custom.js') }}"></script>
        @yield('PageVendorJS')
        @yield('PageCustomJS')

        <script>
            @php
                use App\Models\UserSetting;

                $userSettings = UserSetting::where('user_id', Auth::user()->id)->first();

                if (!$userSettings) {
                    $userSettings = new UserSetting();
                    $userSettings->user_id = Auth::user()->id;
                    $userSettings->app_auto_logout_duration = 180;
                    $userSettings->save();
                }
            @endphp

            let timeout;
            let timerInterval;
            let logoutDuration = '{{ $userSettings->app_auto_logout_duration }}';
            let alertDuration = 10000;

            document.onmousemove = function(){
                clearTimeout(timeout);
                timeout = setTimeout(function () {
                    Swal.fire({
                        icon: 'error',
                        showCancelButton: true,
                        showConfirmButton: false,
                        allowOutsideClick: false,
                        cancelButtonText: '{{ __("messages.sweetalert.09") }}',
                        customClass: {
                            confirmButton: 'btn btn-danger',
                            cancelButton: 'btn btn-danger',
                            title: 'text-white'
                        },
                        buttonsStyling: false,
                        title: "{{ __('messages.sweetalert.07') }}!",
                        html: "{{ __('messages.sweetalert.06') }} <b></b> {{ __('messages.sweetalert.08') }}",
                        timer: alertDuration,
                        timerProgressBar: false,
                        didOpen: () => {
                            const timer = Swal.getPopup().querySelector("b");
                            timerInterval = setInterval(() => {
                                timer.textContent = `${(Swal.getTimerLeft() / 1000).toFixed(1)}`;
                            }, 100);
                        },
                        willClose: () => {
                            clearInterval(timerInterval);
                        }
                    }).then((result) => {
                        if (result.dismiss === Swal.DismissReason.timer) {
                            document.getElementById('logout-form').submit();
                        }
                    });
                }, (Number(logoutDuration) * 60000));
            };
        </script>
    </body>
    @yield('PageModals')
</html>
