@extends('layouts.application.layout_application')
@section('PageTitle', __('messages.payment_periods.create.01'))

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
            <a href="{{ route('PaymentPeriods.Index') }}" class="text-muted text-hover-primary">{{ __('messages.payment_periods.index.01') }}</a>
        </li>
    </ul>
@endsection

@section('PageContent')
    <div class="row g-5 g-xl-8">
        <div class="col-xl-12">
            <div class="alert alert-info d-flex align-items-center p-5">
                <i class="ki-duotone ki-shield-tick fs-2hx text-info me-4"><span class="path1"></span><span class="path2"></span></i>
                <div class="d-flex flex-column">
                    <h4 class="mb-1">@ {{ __('messages.payment_periods.alert.01') }}</h4>
                    <span>- {{ __('messages.payment_periods.alert.02') }}</span>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-header ribbon ribbon-start ribbon-clip">
                    <div class="ribbon-label bg-success fs-6" style="padding: 10px 15px;"><span class="d-flex text-white fw-bolder fs-6">{{ __('messages.payment_periods.create.02') }}</span></div>
                    <h3 class="card-title"></h3>
                    <div class="card-toolbar"></div>
                </div>
                <div class="card-body">
                    <form action="{{ route('PaymentPeriods.Store') }}" id="createForm" enctype="multipart/form-data" method="POST" autocomplete="off">
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                <label for="input-client_id" class="required form-label">{{ __('messages.payment_periods.form.01') }}</label>
                                <select class="form-select @error('input-client_id') is-invalid error-input @enderror" name="input-client_id" id="input-client_id" data-control="select2" data-placeholder="{{ __('messages.forms.06') }}" data-hide-search="true">
                                    <option></option>
                                    @foreach($clients as $client)
                                        <option value="{{ $client->id }}" @if (old('input-client_id') == $client->id) selected="selected" @endif>{{ $client->company_name }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('input-client_id'))
                                    <div class="invalid-feedback">
                                        @ {{ $errors->first('input-client_id') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="row mt-6">
                            <div class="col-6">
                                <label for="input-payment_amount" class="required form-label">{{ __('messages.payment_periods.form.03') }}</label>
                                <input type="text" name="input-payment_amount" id="input-payment_amount" class="form-control @error('input-payment_amount') is-invalid error-input @enderror" placeholder="{{ __('messages.payment_periods.form.03') }} {{ __('messages.forms.01') }}" maxlength="150" value="{{ old('input-payment_amount') }}"/>
                                @if ($errors->has('input-payment_amount'))
                                    <div class="invalid-feedback">
                                        @ {{ $errors->first('input-payment_amount') }}
                                    </div>
                                @endif
                            </div>
                            <div class="col-6">
                                <label for="input-currency" class="required form-label">{{ __('messages.payment_periods.form.04') }}</label>
                                <select class="form-select @error('input-currency') is-invalid error-input @enderror" name="input-currency" id="input-currency" data-control="select2" data-placeholder="{{ __('messages.forms.06') }}" data-hide-search="true">
                                    <option></option>
                                    <option value="TRY" {{ old('input-currency') == 'TRY' ? 'selected' : '' }}>{{ __('messages.payment_periods.form.04.01') }}</option>
                                    <option value="USD" {{ old('input-currency') == 'USD' ? 'selected' : '' }}>{{ __('messages.payment_periods.form.04.02') }}</option>
                                    <option value="EUR" {{ old('input-currency') == 'EUR' ? 'selected' : '' }}>{{ __('messages.payment_periods.form.04.03') }}</option>
                                </select>
                                @if ($errors->has('input-currency'))
                                    <div class="invalid-feedback">
                                        @ {{ $errors->first('input-currency') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="row mt-6">
                            <div class="col-6">
                                <label for="input-payment_start_date" class="form-label required">{{ __('messages.payment_periods.form.02') }}</label>
                                <input name="input-payment_start_date" id="input-payment_start_date" class="form-control @error('input-payment_start_date') is-invalid error-input @enderror" placeholder="{{ __('messages.forms.06') }}" value="{{ old('input-payment_start_date') }}"/>
                                @if ($errors->has('input-payment_start_date'))
                                    <div class="invalid-feedback">
                                        @ {{ $errors->first('input-payment_start_date') }}
                                    </div>
                                @endif
                            </div>
                            <div class="col-6">
                                <label for="input-show_delayed_payment_warnings" class="required form-label">{{ __('messages.payment_periods.form.05') }}</label>
                                <select class="form-select @error('input-show_delayed_payment_warnings') is-invalid error-input @enderror" name="input-show_delayed_payment_warnings" id="input-show_delayed_payment_warnings" data-control="select2" data-placeholder="{{ __('messages.forms.06') }}" data-hide-search="true">
                                    <option></option>
                                    <option value="1" {{ old('input-show_delayed_payment_warnings') == '1' ? 'selected' : '' }}>{{ __('messages.payment_periods.form.05.01') }}</option>
                                    <option value="0" {{ old('input-show_delayed_payment_warnings') == '0' ? 'selected' : '' }}>{{ __('messages.payment_periods.form.05.02') }}</option>
                                </select>
                                @if ($errors->has('input-show_delayed_payment_warnings'))
                                    <div class="invalid-feedback">
                                        @ {{ $errors->first('input-show_delayed_payment_warnings') }}
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
                    <a href="{{ route('PaymentPeriods.Index') }}" class="btn btn-light-danger btn-sm ms-2">{{ __('messages.forms.04') }}</a>
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
