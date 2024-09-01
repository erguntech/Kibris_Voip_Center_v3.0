@extends('layouts.application.layout_application')
@section('PageTitle', __('messages.general_settings.index.01'))

@section('PageVendorCSS')

@endsection

@section('PageCustomCSS')
    <style>
        thead th { white-space: nowrap; }
    </style>
@endsection

@section('Breadcrumb')
    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 ">
        <li class="breadcrumb-item text-muted">
            <a href="{{ route('Dashboard.Index') }}" class="text-muted text-hover-primary">{{ Settings::get('app_alias') }}</a>
        </li>
    </ul>
@endsection

@section('PageContent')
    <div class="row g-5 g-xl-8">
        <div class="col-xl-12">
            <div class="alert alert-info d-flex align-items-center p-5">
                <i class="ki-duotone ki-shield-tick fs-2hx text-info me-4"><span class="path1"></span><span class="path2"></span></i>
                <div class="d-flex flex-column">
                    <h4 class="mb-1">@ {{ __('messages.general_settings.alert.01') }}</h4>
                    <span>- {{ __('messages.general_settings.alert.02') }}</span>
                </div>
            </div>

            @if (session('result'))
                @include('components.alert', $data = ['alert_type' => session('result'), 'alert_title' => session('title'), 'alert_content' => session('content')])
            @endif

            <div class="card shadow-sm">
                <div class="card-header ribbon ribbon-start ribbon-clip">
                    <div class="ribbon-label bg-warning fs-6" style="padding: 10px 15px;"><span class="d-flex text-white fw-bolder fs-6">{{ __('messages.general_settings.index.01') }}</span></div>
                    <h3 class="card-title"></h3>
                    <div class="card-toolbar"></div>
                </div>
                @if($errors->any())
                    {!! implode('', $errors->all('<div>:message</div>')) !!}
                @endif
                <div class="card-body">
                    <form action="{{ route('GeneralSettings.Update') }}" id="editForm" enctype="multipart/form-data" method="POST" autocomplete="off">
                        @csrf
                        @method('POST')
                        <div class="row">
                            <div class="col-12">
                                <label for="input-auto_logout_duration" class="form-label required">{{ __('messages.general_settings.form.01') }}</label>
                                <select class="form-select @error('input-auto_logout_duration') is-invalid error-input @enderror" name="input-auto_logout_duration" id="input-auto_logout_duration" data-control="select2" data-placeholder="{{ __('messages.forms.06') }}" data-hide-search="true">
                                    <option></option>
                                    <option value="10" {{ old('input-auto_logout_duration', $userSettings->app_auto_logout_duration) == '10' ? 'selected' : '' }}>{{ __('messages.general_settings.form.01.01') }}</option>
                                    <option value="30" {{ old('input-auto_logout_duration', $userSettings->app_auto_logout_duration) == '30' ? 'selected' : '' }}>{{ __('messages.general_settings.form.01.02') }}</option>
                                    <option value="60" {{ old('input-auto_logout_duration', $userSettings->app_auto_logout_duration) == '60' ? 'selected' : '' }}>{{ __('messages.general_settings.form.01.03') }}</option>
                                    <option value="180" {{ old('input-auto_logout_duration', $userSettings->app_auto_logout_duration) == '180' ? 'selected' : '' }}>{{ __('messages.general_settings.form.01.04') }}</option>
                                    <option value="300" {{ old('input-auto_logout_duration', $userSettings->app_auto_logout_duration) == '300' ? 'selected' : '' }}>{{ __('messages.general_settings.form.01.05') }}</option>
                                    <option value="720" {{ old('input-auto_logout_duration', $userSettings->app_auto_logout_duration) == '720' ? 'selected' : '' }}>{{ __('messages.general_settings.form.01.06') }}</option>
                                </select>
                                @if ($errors->has('input-auto_logout_duration'))
                                    <div class="invalid-feedback">
                                        @ {{ $errors->first('input-auto_logout_duration') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </form>
                    <div class="separator border-2 my-10"></div>
                    <button type="submit" class="btn btn-warning btn-sm" form="editForm">
                        <span class="indicator-label">{{ __('messages.forms.05') }}</span>
                        <span class="indicator-progress">{{ __('messages.forms.03') }} <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('PageVendorJS')

@endsection

@section('PageCustomJS')

@endsection

@section('PageModals')

@endsection
