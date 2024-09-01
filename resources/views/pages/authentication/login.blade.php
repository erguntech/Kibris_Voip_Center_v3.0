@extends('layouts.authentication.layout_authentication')
@section('PageTitle', __('messages.authentication.login.05'))

@section('PageVendorCSS')

@endsection

@section('PageCustomCSS')

@endsection

@section('PageContent')
    <div class="d-flex flex-column flex-lg-row flex-column-fluid">
        <div class="d-flex flex-column flex-lg-row-fluid w-lg-50 p-10 order-2 order-lg-1">
            <div class="d-flex flex-center flex-column flex-lg-row-fluid">
                <div class="w-lg-500px p-10">
                    <form class="form w-100" novalidate="novalidate" id="kt_sign_in_form" action="{{ route('login') }}" method="POST">
                    @csrf
                        <div class="text-center mb-11">
                            <img alt="Logo" src="{{ asset('assets/custom/media/logo_login_dark.svg') }}" class="h-125px h-lg-125px mb-2"/>

                            <h1 class="text-gray-800 fw-bolder mb-3f fs-4">{!! __('messages.authentication.login.01') !!}</h1>
                            <div class="text-gray-500 fw-semibold fs-6">{!! __('messages.authentication.login.02') !!}</div>
                        </div>
                        <div class="separator separator-content my-14">
                            <span class="w-125px text-gray-500 fw-semibold fs-7">@</span>
                        </div>
                        <div class="fv-row mb-8">
                            <input type="text" placeholder="{!! __('messages.authentication.login.form.01') !!}" name="email" autocomplete="off" class="form-control bg-transparent @error('email') is-invalid error-input @enderror" />
                            @if ($errors->has('email'))
                                <div class="text-danger mt-2">@ {{ $errors->first('email') }}</div>
                            @endif
                        </div>
                        <div class="fv-row mb-3">
                            <input type="password" placeholder="{!! __('messages.authentication.login.form.02') !!}" name="password" autocomplete="off" class="form-control bg-transparent @error('password') is-invalid error-input @enderror" />
                            @if ($errors->has('email'))
                                <div class="text-danger mt-2">@ {{ $errors->first('email') }}</div>
                            @endif
                        </div>
                        <div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-3" style="display: none;"></div>
                        <div class="d-grid mb-10">
                            <button type="submit" id="kt_sign_in_submit" class="btn btn-primary">
                                <span class="indicator-label">{{ __('messages.authentication.login.03') }}</span>
                                <span class="indicator-progress">{{ __('messages.authentication.login.04') }}
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                </span>
                            </button>
                        </div>
                        <div class="text-gray-500 text-center fw-semibold fs-6">
                            <span>{{ Settings::get('app_title') }} - {{ Settings::get('app_version') }}</span>
                        </div>
                    </form>
                </div>
            </div>

            <div class="d-flex flex-stack px-10 mx-auto">
                <div class="me-10">
                    <button class="btn btn-flex btn-link btn-color-gray-700 btn-active-color-primary rotate fs-base" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-start" data-kt-menu-offset="0px, 0px">
                        <img data-kt-element="current-lang-flag" class="w-20px h-20px rounded me-3" src="assets/media/flags/{{ Config::get('languages')[App::getLocale()]['flag-icon'] }}.svg" alt="" />
                        <span data-kt-element="current-lang-name" class="me-1">{{ Config::get('languages')[App::getLocale()]['display'] }}</span>
                        <span class="d-flex flex-center rotate-180">
                            <i class="ki-duotone ki-down fs-5 text-muted m-0"></i>
                        </span>
                    </button>
                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-4 fs-7" data-kt-menu="true" id="kt_auth_lang_menu">
                    @foreach (Config::get('languages') as $lang => $language)
                            <div class="menu-item px-3">
                                <a href="{{ route('lang.switch', $lang) }}" class="menu-link d-flex px-5" data-kt-lang="{{ $language['display'] }}">
                                    <span class="symbol symbol-20px me-4">
                                        <img data-kt-element="lang-flag" class="rounded-1" src="assets/media/flags/{{ $language['flag-icon'] }}.svg" alt="" />
                                    </span>
                                    <span data-kt-element="lang-name">{{ $language['display'] }}</span>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex flex-lg-row-fluid w-lg-50 bgi-size-cover bgi-position-center order-1 order-lg-2" style="background-image: url({{ asset('assets/custom/media/login_bg.png') }})"></div>
    </div>
@endsection

@section('PageVendorJS')

@endsection

@section('PageCustomJS')

@endsection

@section('PageModals')

@endsection
