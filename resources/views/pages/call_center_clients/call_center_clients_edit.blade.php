@extends('layouts.application.layout_application')
@section('PageTitle', __('messages.call_center_clients.edit.01'))

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
            <a href="{{ route('CallCenterClients.Index') }}" class="text-muted text-hover-primary">{{ __('messages.call_center_clients.index.01') }}</a>
        </li>
    </ul>
@endsection

@section('PageContent')
    <div class="row g-5 g-xl-8">
        <div class="col-xl-12">
            <div class="alert alert-info d-flex align-items-center p-5">
                <i class="ki-duotone ki-shield-tick fs-2hx text-info me-4"><span class="path1"></span><span class="path2"></span></i>
                <div class="d-flex flex-column">
                    <h4 class="mb-1">@ {{ __('messages.call_center_clients.alert.01') }}</h4>
                    <span>- {{ __('messages.call_center_clients.alert.02') }}</span>
                </div>
            </div>

            @if (session('result'))
                <div class="mb-4">
                    @include('components.alert', $data = ['alert_type' => session('result'), 'alert_title' => session('title'), 'alert_content' => session('content')])
                </div>
            @endif

            <div class="card shadow-sm">
                <div class="card-header ribbon ribbon-start ribbon-clip">
                    <div class="ribbon-label bg-warning fs-6" style="padding: 10px 15px;"><span class="d-flex text-white fw-bolder fs-6">{{ __('messages.call_center_clients.edit.02') }}</span></div>
                    <h3 class="card-title"></h3>
                    <div class="card-toolbar"></div>
                </div>
                <div class="card-body">
                    <form action="{{ route('CallCenterClients.Update', $callCenterClient->id) }}" id="editForm" enctype="multipart/form-data" method="POST" autocomplete="off">
                        @method('PUT')
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                <label for="input-assigned_user_id" class="required form-label">{{ __('messages.call_center_clients.form.01') }}</label>
                                <select class="form-select @error('input-assigned_user_id') is-invalid error-input @enderror" name="input-assigned_user_id" id="input-assigned_user_id" data-control="select2" data-placeholder="{{ __('messages.forms.06') }}" data-hide-search="true">
                                    <option></option>
                                    <option value="0" selected="selected">{{ __('messages.call_center_clients.form.01.01') }}</option>
                                    @foreach($employees as $employee)
                                        <option value="{{ $employee->id }}" @if (old('input-assigned_user_id', $callCenterClient->assigned_user_id) == $employee->id) selected="selected" @endif>{{ $employee->linkedUser->getUserFullName() }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('input-assigned_user_id'))
                                    <div class="invalid-feedback">
                                        @ {{ $errors->first('input-assigned_user_id') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="row mt-6">
                            <div class="col-6">
                                <label for="input-first_name" class="required form-label">{{ __('messages.call_center_clients.form.02') }}</label>
                                <input type="text" name="input-first_name" id="input-first_name" class="form-control @error('input-first_name') is-invalid error-input @enderror" placeholder="{{ __('messages.call_center_clients.form.02') }} {{ __('messages.forms.01') }}" maxlength="50" value="{{ old('input-first_name', $callCenterClient->first_name) }}"/>
                                @if ($errors->has('input-first_name'))
                                    <div class="invalid-feedback">
                                        @ {{ $errors->first('input-first_name') }}
                                    </div>
                                @endif
                            </div>
                            <div class="col-6">
                                <label for="input-last_name" class="required form-label">{{ __('messages.call_center_clients.form.03') }}</label>
                                <input type="text" name="input-last_name" id="input-last_name" class="form-control @error('input-last_name') is-invalid error-input @enderror" placeholder="{{ __('messages.call_center_clients.form.03') }} {{ __('messages.forms.01') }}" maxlength="50" value="{{ old('input-last_name', $callCenterClient->last_name) }}"/>
                                @if ($errors->has('input-last_name'))
                                    <div class="invalid-feedback">
                                        @ {{ $errors->first('input-last_name') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="row mt-6">
                            <div class="col-6">
                                <label for="input-company_name" class="form-label">{{ __('messages.call_center_clients.form.04') }}</label>
                                <input type="text" name="input-company_name" id="input-company_name" class="form-control @error('input-company_name') is-invalid error-input @enderror" placeholder="{{ __('messages.call_center_clients.form.04') }} {{ __('messages.forms.01') }}" maxlength="150" value="{{ old('input-company_name', $callCenterClient->company_name) }}"/>
                                @if ($errors->has('input-company_name'))
                                    <div class="invalid-feedback">
                                        @ {{ $errors->first('input-company_name') }}
                                    </div>
                                @endif
                            </div>
                            <div class="col-6">
                                <label for="input-contact_no" class="required form-label">{{ __('messages.call_center_clients.form.05') }}</label>
                                <input type="text" name="input-contact_no" id="input-contact_no" class="form-control @error('input-contact_no') is-invalid error-input @enderror" placeholder="{{ __('messages.call_center_clients.form.05') }} {{ __('messages.forms.01') }}" maxlength="50" value="{{ old('input-contact_no', $callCenterClient->contact_no) }}"/>
                                @if ($errors->has('input-contact_no'))
                                    <div class="invalid-feedback">
                                        @ {{ $errors->first('input-contact_no') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="row mt-6">
                            <div class="col-12">
                                <label for="input-is_active" class="required form-label">{{ __('messages.call_center_clients.form.08') }}</label>
                                <select class="form-select @error('input-is_active') is-invalid error-input @enderror" name="input-is_active" id="input-is_active" data-control="select2" data-placeholder="{{ __('messages.forms.06') }}" data-hide-search="true">
                                    <option></option>
                                    <option value="1" {{ old('input-is_active', $callCenterClient->is_active) == '1' ? 'selected' : '' }}>{{ __('messages.call_center_clients.form.08.01') }}</option>
                                    <option value="0" {{ old('input-is_active', $callCenterClient->is_active) == '0' ? 'selected' : '' }}>{{ __('messages.call_center_clients.form.08.02') }}</option>
                                </select>
                                @if ($errors->has('input-is_active'))
                                    <div class="invalid-feedback">
                                        @ {{ $errors->first('input-is_active') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="row mt-6">
                            <div class="col-12">
                                <label for="input-description" class="form-label">{{ __('messages.call_center_clients.form.06') }}</label>
                                <textarea name="input-description" id="input-description" class="form-control @error('input-description') is-invalid error-input @enderror" rows="8" placeholder="{{ __('messages.call_center_clients.form.06') }} {{ __('messages.forms.01') }}" maxlength="750">{{ old('input-description', $callCenterClient->description) }}</textarea>
                                @if ($errors->has('input-description'))
                                    <div class="invalid-feedback">
                                        @ {{ $errors->first('input-description') }}
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
                    <a href="{{ route('CallCenterClients.Index') }}" class="btn btn-light-danger btn-sm ms-2">{{ __('messages.forms.04') }}</a>
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
