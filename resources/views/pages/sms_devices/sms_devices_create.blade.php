@extends('layouts.application.layout_application')
@section('PageTitle', __('messages.sms_devices.create.01'))

@section('PageVendorCSS')

@endsection

@section('PageCustomCSS')

@endsection

@section('Breadcrumb')
    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 ">
        <li class="breadcrumb-item text-muted">
            <a href="{{ route('Dashboard.Index') }}" class="text-muted text-hover-primary">{{ Settings::get('app_alias') }}</a>
        </li>
        <li class="breadcrumb-item">
            <span class="bullet bg-gray-500 w-5px h-2px"></span>
        </li>
        <li class="breadcrumb-item text-muted">
            <a href="{{ route('SMSDevices.Index') }}" class="text-muted text-hover-primary">{{ __('messages.sms_devices.index.01') }}</a>
        </li>
    </ul>
@endsection

@section('PageContent')
    <div class="row g-5 g-xl-8">
        <div class="col-xl-12">
            <div class="card shadow-sm">
                <div class="card-header ribbon ribbon-start ribbon-clip">
                    <div class="ribbon-label bg-success fs-6" style="padding: 10px 15px;"><span class="d-flex text-white fw-bolder fs-6">{{ __('messages.sms_devices.create.02') }}</span></div>
                    <h3 class="card-title"></h3>
                    <div class="card-toolbar"></div>
                </div>
                <div class="card-body">
                    <form action="{{ route('SMSDevices.Store') }}" id="createForm" enctype="multipart/form-data" method="POST" autocomplete="off">
                        @csrf

                        <div class="row">
                            <div class="col-6">
                                <label for="input-device_name" class="required form-label">{{ __('messages.sms_devices.form.01') }}</label>
                                <input type="text" name="input-device_name" id="input-device_name" class="form-control @error('input-device_name') is-invalid error-input @enderror" placeholder="{{ __('messages.sms_devices.form.01') }} {{ __('messages.forms.01') }}" maxlength="50" value="{{ old('input-device_name') }}"/>
                                @if ($errors->has('input-device_name'))
                                    <div class="invalid-feedback">
                                        @ {{ $errors->first('input-device_name') }}
                                    </div>
                                @endif
                            </div>
                            <div class="col-6">
                                <label for="input-phone_no" class="required form-label">{{ __('messages.sms_devices.form.02') }}</label>
                                <input type="text" name="input-phone_no" id="input-phone_no" class="form-control @error('input-phone_no') is-invalid error-input @enderror" placeholder="{{ __('messages.sms_devices.form.02') }} {{ __('messages.forms.01') }}" maxlength="50" value="{{ old('input-phone_no') }}"/>
                                @if ($errors->has('input-phone_no'))
                                    <div class="invalid-feedback">
                                        @ {{ $errors->first('input-phone_no') }}
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="row mt-6">
                            <div class="col-12">
                                <label for="input-gsm_api_token" class="required form-label">{{ __('messages.sms_devices.form.03') }}</label>
                                <input type="text" name="input-gsm_api_token" id="input-gsm_api_token" class="form-control @error('input-gsm_api_token') is-invalid error-input @enderror" placeholder="{{ __('messages.sms_devices.form.03') }} {{ __('messages.forms.01') }}" maxlength="500" value="{{ old('input-gsm_api_token') }}"/>
                                @if ($errors->has('input-gsm_api_token'))
                                    <div class="invalid-feedback">
                                        @ {{ $errors->first('input-gsm_api_token') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="row mt-6">
                            <div class="col-6">
                                <label for="input-credit_count" class="required form-label">{{ __('messages.sms_devices.form.05') }}</label>
                                <input type="text" name="input-credit_count" id="input-credit_count" class="form-control @error('input-credit_count') is-invalid error-input @enderror" placeholder="{{ __('messages.sms_devices.form.05') }} {{ __('messages.forms.01') }}" maxlength="50" value="{{ old('input-credit_count') }}"/>
                                @if ($errors->has('input-credit_count'))
                                    <div class="invalid-feedback">
                                        @ {{ $errors->first('input-credit_count') }}
                                    </div>
                                @endif
                            </div>
                            <div class="col-6">
                                <label for="input-is_active" class="required form-label">{{ __('messages.sms_devices.form.06') }}</label>
                                <select class="form-select @error('input-is_active') is-invalid error-input @enderror" name="input-is_active" id="input-is_active" data-control="select2" data-placeholder="{{ __('messages.forms.06') }}" data-hide-search="true">
                                    <option></option>
                                    <option value="1" {{ old('input-is_active') == '1' ? 'selected' : '' }}>{{ __('messages.sms_devices.form.06.01') }}</option>
                                    <option value="0" {{ old('input-is_active') == '0' ? 'selected' : '' }}>{{ __('messages.sms_devices.form.06.02') }}</option>
                                </select>
                                @if ($errors->has('input-is_active'))
                                    <div class="invalid-feedback">
                                        @ {{ $errors->first('input-is_active') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </form>
                    <div class="separator border-2 my-10"></div>
                    <button type="submit" class="btn btn-success btn-sm" form="createForm">
                        <span class="indicator-label">{{ __('messages.forms.02') }}</span>
                        <span class="indicator-progress">{{ __('messages.forms.03') }} <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>
                    <a href="{{ route('SMSDevices.Index') }}" class="btn btn-light-danger btn-sm ms-2">{{ __('messages.forms.04') }}</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('PageVendorJS')

@endsection

@section('PageCustomJS')
    <script>
        $("#input-payment_start_date").flatpickr({
            dateFormat: "d-m-Y"
        });
    </script>
@endsection

@section('PageModals')

@endsection
