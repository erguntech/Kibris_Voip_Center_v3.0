@extends('layouts.application.layout_application')
@section('PageTitle', __('messages.clients.create.01'))

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
            <a href="{{ route('Clients.Index') }}" class="text-muted text-hover-primary">{{ __('messages.clients.index.01') }}</a>
        </li>
    </ul>
@endsection

@section('PageContent')
    <div class="row g-5 g-xl-8">
        <div class="col-xl-12">
            <div class="alert alert-info d-flex align-items-center p-5">
                <i class="ki-duotone ki-shield-tick fs-2hx text-info me-4"><span class="path1"></span><span class="path2"></span></i>
                <div class="d-flex flex-column">
                    <h4 class="mb-1">@ {{ __('messages.clients.alert.01') }}</h4>
                    <span>- {{ __('messages.clients.alert.02') }}</span>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-header ribbon ribbon-start ribbon-clip">
                    <div class="ribbon-label bg-success fs-6" style="padding: 10px 15px;"><span class="d-flex text-white fw-bolder fs-6">{{ __('messages.clients.create.02') }}</span></div>
                    <h3 class="card-title"></h3>
                    <div class="card-toolbar"></div>
                </div>

                <div class="card-body">
                    <form action="{{ route('Clients.Store') }}" id="createForm" enctype="multipart/form-data" method="POST" autocomplete="off">
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                <label for="input-company_name" class="required form-label">{{ __('messages.clients.form.01') }}</label>
                                <input type="text" name="input-company_name" id="input-company_name" class="form-control @error('input-company_name') is-invalid error-input @enderror" placeholder="{{ __('messages.clients.form.01') }} {{ __('messages.forms.01') }}" maxlength="150" value="{{ old('input-company_name') }}"/>
                                @if ($errors->has('input-company_name'))
                                    <div class="invalid-feedback">
                                        @ {{ $errors->first('input-company_name') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="row mt-6">
                            <div class="col-6">
                                <label for="input-first_name" class="required form-label">{{ __('messages.users.form.01') }}</label>
                                <input type="text" name="input-first_name" id="input-first_name" class="form-control @error('input-first_name') is-invalid error-input @enderror" placeholder="{{ __('messages.users.form.01') }} {{ __('messages.forms.01') }}" maxlength="50" value="{{ old('input-first_name') }}"/>
                                @if ($errors->has('input-first_name'))
                                    <div class="invalid-feedback">
                                        @ {{ $errors->first('input-first_name') }}
                                    </div>
                                @endif
                            </div>
                            <div class="col-6">
                                <label for="input-last_name" class="required form-label">{{ __('messages.users.form.02') }}</label>
                                <input type="text" name="input-last_name" id="input-last_name" class="form-control @error('input-last_name') is-invalid error-input @enderror" placeholder="{{ __('messages.users.form.02') }} {{ __('messages.forms.01') }}" maxlength="50" value="{{ old('input-last_name') }}"/>
                                @if ($errors->has('input-last_name'))
                                    <div class="invalid-feedback">
                                        @ {{ $errors->first('input-last_name') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="row mt-6">
                            <div class="col-12">
                                <label for="input-email" class="required form-label">{{ __('messages.users.form.03') }}</label>
                                <input type="email" name="input-email" id="input-email" class="form-control @error('input-email') is-invalid error-input @enderror" placeholder="{{ __('messages.users.form.03') }} {{ __('messages.forms.01') }}" maxlength="50" value="{{ old('input-email') }}"/>
                                @if ($errors->has('input-email'))
                                    <div class="invalid-feedback">
                                        @ {{ $errors->first('input-email') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="row mt-6">
                            <div class="col-6">
                                <label for="input-contact_no" class="required form-label">{{ __('messages.clients.form.02') }}</label>
                                <input type="text" name="input-contact_no" id="input-contact_no" class="form-control @error('input-contact_no') is-invalid error-input @enderror" placeholder="{{ __('messages.clients.form.02') }} {{ __('messages.forms.01') }}" maxlength="50" value="{{ old('input-contact_no') }}"/>
                                @if ($errors->has('input-contact_no'))
                                    <div class="invalid-feedback">
                                        @ {{ $errors->first('input-contact_no') }}
                                    </div>
                                @endif
                            </div>
                            <div class="col-6">
                                <label for="input-address" class="required form-label">{{ __('messages.clients.form.03') }}</label>
                                <input type="text" name="input-address" id="input-address" class="form-control @error('input-address') is-invalid error-input @enderror" placeholder="{{ __('messages.clients.form.03') }} {{ __('messages.forms.01') }}" maxlength="150" value="{{ old('input-address') }}"/>
                                @if ($errors->has('input-address'))
                                    <div class="invalid-feedback">
                                        @ {{ $errors->first('input-address') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="row mt-6">
                            <div class="col-12">
                                <label for="input-is_active" class="required form-label">{{ __('messages.clients.form.04') }}</label>
                                <select class="form-select @error('input-is_active') is-invalid error-input @enderror" name="input-is_active" id="input-is_active" data-control="select2" data-placeholder="{{ __('messages.forms.06') }}" data-hide-search="true">
                                    <option></option>
                                    <option value="1" {{ old('input-is_active') == '1' ? 'selected' : '' }}>{{ __('messages.clients.form.04.01') }}</option>
                                    <option value="0" {{ old('input-is_active') == '0' ? 'selected' : '' }}>{{ __('messages.clients.form.04.02') }}</option>
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
