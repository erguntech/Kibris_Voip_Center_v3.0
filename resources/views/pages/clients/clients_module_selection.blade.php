@extends('layouts.application.layout_application')
@section('PageTitle', __('messages.client_module_selection.index.01'))

@section('PageVendorCSS')

@endsection

@section('PageCustomCSS')

@endsection

@section('Breadcrumb')
    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 ">
        <li class="breadcrumb-item text-muted">
            <a href="{{ route('Dashboard.Index') }}" class="text-muted text-hover-primary">{{ Settings::get('app_alias') }}</a>
        </li>
    </ul>
@endsection

@section('PageContent')
    <div class="row g-5 g-xl-8 mb-4">
        <div class="col-xl-12">

            @if (session('result'))
                @include('components.alert', $data = ['alert_type' => session('result'), 'alert_title' => session('title'), 'alert_content' => session('content')])
            @endif

            <div class="card shadow-sm">
                <div class="card-header ribbon ribbon-start ribbon-clip">
                    <div class="ribbon-label bg-warning fs-6" style="padding: 10px 15px;"><span class="d-flex text-white fw-bolder fs-6">{{ __('messages.client_module_selection.index.02') }}</span></div>
                    <h3 class="card-title"></h3>
                    <div class="card-toolbar">
                    </div>
                </div>

                <div class="card-body">
                    <form action="{{ route('Clients.ModuleSelection.Update', $client->id) }}" id="editForm" enctype="multipart/form-data" method="POST" autocomplete="off">
                        @csrf
                        @method('POST')
                        <div class="row">
                            <div class="col-6">
                                <label for="input-pbx_module" class="required form-label">{{ __('messages.client_module_selection.form.01') }}</label>
                                <select class="form-select @error('input-pbx_module') is-invalid error-input @enderror" name="input-pbx_module" id="input-pbx_module" data-control="select2" data-placeholder="{{ __('messages.forms.06') }}" data-hide-search="true">
                                    <option></option>
                                    <option value="1" {{ old('input-pbx_module', $clientModel->pbx_module) == '1' ? 'selected' : '' }}>{{ __('messages.client_module_selection.form.01.01') }}</option>
                                    <option value="0" {{ old('input-pbx_module', $clientModel->pbx_module) == '0' ? 'selected' : '' }}>{{ __('messages.client_module_selection.form.01.02') }}</option>
                                </select>
                                @if ($errors->has('input-pbx_module'))
                                    <div class="invalid-feedback">
                                        @ {{ $errors->first('input-pbx_module') }}
                                    </div>
                                @endif
                            </div>
                            <div class="col-6">
                                <label for="input-pbx_server_ip_address" class="required form-label">{{ __('messages.client_module_selection.form.02') }}</label>
                                <input type="text" name="input-pbx_server_ip_address" id="input-pbx_server_ip_address" class="form-control @error('input-pbx_server_ip_address') is-invalid error-input @enderror" placeholder="{{ __('messages.client_module_selection.form.02') }} {{ __('messages.forms.01') }}" maxlength="50" value="{{ old('input-pbx_server_ip_address', @$clientModel->pbx_server_ip_address) }}"/>
                                @if ($errors->has('input-pbx_server_ip_address'))
                                    <div class="invalid-feedback">
                                        @ {{ $errors->first('input-pbx_server_ip_address') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="separator separator-dashed border-secondary mt-7"></div>

                        <div class="row mt-6">
                            <div class="col-6">
                                <label for="input-sms_module" class="required form-label">{{ __('messages.client_module_selection.form.03') }}</label>
                                <select class="form-select @error('input-sms_module') is-invalid error-input @enderror" name="input-sms_module" id="input-sms_module" data-control="select2" data-placeholder="{{ __('messages.forms.06') }}" data-hide-search="true">
                                    <option></option>
                                    @php
                                        if ($clientModel->sms_module == true) {
                                            $smsModuleStatus = "1";
                                        } else {
                                            $smsModuleStatus = "0";
                                        }
                                    @endphp
                                    <option value="1" {{ old('input-sms_module', $smsModuleStatus) == '1' ? 'selected' : '' }}>{{ __('messages.client_module_selection.form.03.01') }}</option>
                                    <option value="0" {{ old('input-sms_module', $smsModuleStatus) == '0' ? 'selected' : '' }}>{{ __('messages.client_module_selection.form.03.02') }}</option>
                                </select>
                                @if ($errors->has('input-sms_module'))
                                    <div class="invalid-feedback">
                                        @ {{ $errors->first('input-sms_module') }}
                                    </div>
                                @endif
                            </div>
                            <div class="col-6">
                                <label for="input-sms_module_device_id" class="required form-label">{{ __('messages.client_module_selection.form.04') }}</label>
                                <select class="form-select @error('input-sms_module_device_id') is-invalid error-input @enderror" name="input-sms_module_device_id" id="input-sms_module_device_id" data-control="select2" data-placeholder="{{ __('messages.forms.06') }}" data-hide-search="true">
                                    <option></option>
                                    @if($clientSMSDevice != null)
                                        <option value="{{ $clientSMSDevice->id }}" {{ old('input-sms_module_device_id', $clientModel->sms_module_device_id) == $clientSMSDevice->id ? 'selected' : '' }}>{{ $clientSMSDevice->device_name }}</option>
                                    @endif
                                    @foreach($availableSMSDevices as $SMSDeviceItem)
                                        <option value="{{ $SMSDeviceItem->id }}" {{ old('input-sms_module_device_id', $clientModel->sms_module_device_id) == $SMSDeviceItem->id ? 'selected' : '' }}>{{ $SMSDeviceItem->device_name }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('input-sms_module_device_id'))
                                    <div class="invalid-feedback">
                                        @ {{ $errors->first('input-sms_module_device_id') }}
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
                    <a href="{{ route('Clients.Index') }}" class="btn btn-light-danger btn-sm ms-2">{{ __('messages.forms.04') }}</a>
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
