@extends('layouts.application.layout_application')
@section('PageTitle', __('messages.system_settings.index.01'))

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
                    <h4 class="mb-1">@ {{ __('messages.system_settings.alert.01') }}</h4>
                    <span>- {{ __('messages.system_settings.alert.02') }}</span>
                </div>
            </div>

            @if (session('result'))
                @include('components.alert', $data = ['alert_type' => session('result'), 'alert_title' => session('title'), 'alert_content' => session('content')])
            @endif

            <div class="card shadow-sm">
                <div class="card-header ribbon ribbon-start ribbon-clip">
                    <div class="ribbon-label bg-warning fs-6" style="padding: 10px 15px;"><span class="d-flex text-white fw-bolder fs-6">{{ __('messages.system_settings.index.01') }}</span></div>
                    <h3 class="card-title"></h3>
                    <div class="card-toolbar"></div>
                </div>

                <div class="card-body">
                    <form action="{{ route('SystemSettings.Update') }}" id="editForm" enctype="multipart/form-data" method="POST" autocomplete="off">
                        @csrf
                        @method('POST')
                        <div class="row">
                            <div class="col-12">
                                <label for="input-system_currency" class="required form-label">{{ __('messages.system_settings.form.01') }}</label>
                                <select class="form-select @error('input-system_currency') is-invalid error-input @enderror" name="input-system_currency" id="input-system_currency" data-control="select2" data-placeholder="{{ __('messages.forms.06') }}" data-hide-search="true">
                                    <option></option>
                                    <option value="TRY" {{ old('input-system_currency', Settings::get('app_system_currency')) == 'TRY' ? 'selected' : '' }}>{{ __('messages.system_settings.form.01.01') }}</option>
                                    <option value="USD" {{ old('input-system_currency', Settings::get('app_system_currency')) == 'USD' ? 'selected' : '' }}>{{ __('messages.system_settings.form.01.02') }}</option>
                                    <option value="EUR" {{ old('input-system_currency', Settings::get('app_system_currency')) == 'EUR' ? 'selected' : '' }}>{{ __('messages.system_settings.form.01.03') }}</option>
                                </select>
                                @if ($errors->has('input-system_currency'))
                                    <div class="invalid-feedback">
                                        @ {{ $errors->first('input-system_currency') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="row mt-6">
                            <div class="col-12">
                                <label for="input-auto_suspend_days" class="form-label required">{{ __('messages.system_settings.form.02') }}</label>
                                <select class="form-select @error('input-auto_suspend_days') is-invalid error-input @enderror" name="input-auto_suspend_days" id="input-auto_suspend_days" data-control="select2" data-placeholder="{{ __('messages.forms.06') }}" data-hide-search="true">
                                    <option></option>
                                    <option value="3" {{ old('input-auto_suspend_days', Settings::get('app_auto_suspend_days')) == '3' ? 'selected' : '' }}>{{ __('messages.system_settings.form.02.01') }}</option>
                                    <option value="5" {{ old('input-auto_suspend_days', Settings::get('app_auto_suspend_days')) == '5' ? 'selected' : '' }}>{{ __('messages.system_settings.form.02.02') }}</option>
                                    <option value="10" {{ old('input-auto_suspend_days', Settings::get('app_auto_suspend_days')) == '10' ? 'selected' : '' }}>{{ __('messages.system_settings.form.02.03') }}</option>
                                </select>
                                @if ($errors->has('input-auto_suspend_days'))
                                    <div class="invalid-feedback">
                                        @ {{ $errors->first('input-auto_suspend_days') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="row mt-6">
                            <div class="col-4">
                                <label for="input-whatsapp_contact" class="form-label">{{ __('messages.system_settings.form.03') }}</label>
                                <input type="text" name="input-whatsapp_contact" id="input-whatsapp_contact" class="form-control @error('input-whatsapp_contact') is-invalid error-input @enderror" placeholder="{{ __('messages.system_settings.form.03') }} {{ __('messages.forms.01') }}" maxlength="50" value="{{ old('input-whatsapp_contact', Settings::get('app_whatsapp_contact')) }}"/>
                                @if ($errors->has('input-whatsapp_contact'))
                                    <div class="invalid-feedback">
                                        @ {{ $errors->first('input-whatsapp_contact') }}
                                    </div>
                                @endif
                            </div>
                            <div class="col-4">
                                <label for="input-telegram_contact" class="form-label">{{ __('messages.system_settings.form.04') }}</label>
                                <input type="text" name="input-telegram_contact" id="input-telegram_contact" class="form-control @error('input-telegram_contact') is-invalid error-input @enderror" placeholder="{{ __('messages.system_settings.form.04') }} {{ __('messages.forms.01') }}" maxlength="50" value="{{ old('input-telegram_contact', Settings::get('app_telegram_contact')) }}"/>
                                @if ($errors->has('input-telegram_contact'))
                                    <div class="invalid-feedback">
                                        @ {{ $errors->first('input-telegram_contact') }}
                                    </div>
                                @endif
                            </div>
                            <div class="col-4">
                                <label for="input-skype_contact" class="form-label">{{ __('messages.system_settings.form.05') }}</label>
                                <input type="text" name="input-skype_contact" id="input-skype_contact" class="form-control @error('input-skype_contact') is-invalid error-input @enderror" placeholder="{{ __('messages.system_settings.form.05') }} {{ __('messages.forms.01') }}" maxlength="50" value="{{ old('input-skype_contact', Settings::get('app_skype_contact')) }}"/>
                                @if ($errors->has('input-skype_contact'))
                                    <div class="invalid-feedback">
                                        @ {{ $errors->first('input-skype_contact') }}
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
