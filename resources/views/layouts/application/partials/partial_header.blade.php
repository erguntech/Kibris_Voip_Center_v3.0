<div id="kt_app_header" class="app-header" data-kt-sticky="true" data-kt-sticky-activate="{default: true, lg: true}" data-kt-sticky-name="app-header-minimize" data-kt-sticky-offset="{default: '200px', lg: '0'}" data-kt-sticky-animation="false">
    <div class="app-container container-fluid d-flex align-items-stretch justify-content-between " id="kt_app_header_container">
        <div class="d-flex align-items-center d-lg-none ms-n3 me-1 me-md-2" title="Show sidebar menu">
            <div class="btn btn-icon btn-active-color-primary w-35px h-35px" id="kt_app_sidebar_mobile_toggle">
                <i class="ki-solid ki-abstract-14 fs-2 fs-md-1"></i>
            </div>
        </div>
        <div class="d-flex align-items-center flex-grow-1 flex-lg-grow-0">
            <a href="{{ route('Dashboard.Index') }}" class="d-lg-none">
                <img alt="Logo" src="{{ asset('assets/custom/media/default-small-dark.svg') }}" class="h-30px theme-dark-show"/>
                <img alt="Logo" src="{{ asset('assets/custom/media/default-small.svg') }}" class="h-30px theme-light-show"/>
            </a>
        </div>
        <div class="d-flex align-items-stretch justify-content-between flex-lg-grow-1" id="kt_app_header_wrapper">
            <div data-kt-swapper="true" data-kt-swapper-mode="{default: 'prepend', lg: 'prepend'}" data-kt-swapper-parent="{default: '#kt_app_content_container', lg: '#kt_app_header_wrapper'}"  class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 align-items-center my-0">
                    @yield('PageTitle')
                </h1>
                <span class="h-20px border-gray-300 border-start mx-4"></span>
                @yield('Breadcrumb')
            </div>
            <div class="app-navbar flex-shrink-0">
                <div class="app-navbar-item ms-1 ms-md-4">
                    <a href="#" class="btn btn-icon btn-custom btn-icon-muted btn-active-light btn-active-color-primary w-35px h-35px" data-kt-menu-trigger="{default:'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
                        <i class="ki-solid ki-night-day theme-light-show fs-1"></i>
                        <i class="ki-solid ki-moon theme-dark-show fs-1"></i>
                    </a>

                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-title-gray-700 menu-icon-gray-500 menu-active-bg menu-state-color fw-semibold py-4 fs-base w-150px" data-kt-menu="true" data-kt-element="theme-mode-menu">
                        <div class="menu-item px-3 my-0">
                            <a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="light">
                                <span class="menu-icon" data-kt-element="icon">
                                    <i class="ki-solid ki-night-day fs-2"></i>
                                </span>
                                <span class="menu-title">{{ __('messages.partial.header.theme.01') }}</span>
                            </a>
                        </div>
                        <div class="menu-item px-3 my-0">
                            <a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="dark">
                                <span class="menu-icon" data-kt-element="icon">
                                    <i class="ki-solid ki-moon fs-2"></i>
                                </span>
                                <span class="menu-title">{{ __('messages.partial.header.theme.02') }}</span>
                            </a>
                        </div>
                        <div class="menu-item px-3 my-0">
                            <a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="system">
                                <span class="menu-icon" data-kt-element="icon">
                                    <i class="ki-solid ki-screen fs-2"></i>
                                </span>
                                <span class="menu-title">{{ __('messages.partial.header.theme.03') }}</span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="app-navbar-item ms-1 ms-md-4" id="kt_header_user_menu_toggle">
                    <div class="cursor-pointer symbol symbol-35px" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
                        <img src="{{ asset('assets/custom/media/blank.png') }}" class="rounded-3" alt="user"/>
                    </div>
                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px" data-kt-menu="true">
                        <div class="menu-item px-3">
                            <div class="menu-content d-flex align-items-center px-3">
                                <div class="symbol symbol-50px me-5">
                                    <img alt="Logo" src="{{ asset('assets/custom/media/blank.png') }}"/>
                                </div>
                                <div class="d-flex flex-column">
                                    <div class="fw-bold d-flex align-items-center fs-6">
                                        {{ \Illuminate\Support\Facades\Auth::user()->getUserFullName() }}
                                    </div>
                                    <a href="#" class="fw-semibold text-muted text-hover-primary fs-7">
                                        {{ \Illuminate\Support\Facades\Auth::user()->email }}
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="separator my-2"></div>
                        <div class="menu-item px-5">
                            <a href="{{ route('MyAnnouncements.Index') }}" class="menu-link px-5">
                                {{ __('messages.partial.header.menu.01') }}
                            </a>
                        </div>
                        <div class="separator my-2"></div>

                        <div class="menu-item px-5" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="left-start" data-kt-menu-offset="-15px, 0">
                            <a href="#" class="menu-link px-5">
                                <span class="menu-title position-relative">{{ __('messages.partial.header.menu.02') }}
                                    <span class="fs-8 rounded bg-light px-3 py-2 position-absolute translate-middle-y top-50 end-0">{{ Config::get('languages')[App::getLocale()]['display'] }}
                                        <img class="w-20px h-20px rounded-1 ms-2" src="{{ asset('assets/media/flags/'.Config::get('languages')[App::getLocale()]['flag-icon'].'.svg') }}" alt="" />
                                    </span>
                                </span>
                            </a>

                            <div class="menu-sub menu-sub-dropdown w-175px py-4">
                            @foreach (Config::get('languages') as $lang => $language)
                                    <div class="menu-item px-3">
                                        <a href="{{ route('lang.switch', $lang) }}" class="menu-link d-flex px-5">
                                        <span class="symbol symbol-20px me-4">
                                            <img class="rounded-1" src="{{ asset('assets/media/flags/'.$language['flag-icon'].'.svg') }}" alt="" />
                                        </span>{{ $language['display'] }}
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="menu-item px-5 my-1">
                            <a href="{{ route('GeneralSettings.Index') }}" class="menu-link px-5">
                                {{ __('messages.partial.header.menu.03') }}
                            </a>
                        </div>
                        <div class="menu-item px-5">
                            <a href="{{ route('logout') }}" class="menu-link px-5" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ __('messages.partial.header.menu.04') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
