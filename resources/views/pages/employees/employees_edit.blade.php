@extends('layouts.application.layout_application')
@section('PageTitle', __('messages.employees.edit.01'))

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
            <a href="{{ route('Employees.Index') }}" class="text-muted text-hover-primary">{{ __('messages.employees.index.01') }}</a>
        </li>
    </ul>
@endsection

@section('PageContent')
    <div class="row g-5 g-xl-8">
        <div class="col-xl-12">
            <div class="alert alert-info d-flex align-items-center p-5">
                <i class="ki-duotone ki-shield-tick fs-2hx text-info me-4"><span class="path1"></span><span class="path2"></span></i>
                <div class="d-flex flex-column">
                    <h4 class="mb-1">@ {{ __('messages.employees.alert.01') }}</h4>
                    <span>- {{ __('messages.employees.alert.02') }}</span>
                </div>
            </div>

            @if (session('result'))
                <div class="mb-4">
                    @include('components.alert', $data = ['alert_type' => session('result'), 'alert_title' => session('title'), 'alert_content' => session('content')])
                </div>
            @endif

            <div class="card shadow-sm">
                <div class="card-header ribbon ribbon-start ribbon-clip">
                    <div class="ribbon-label bg-warning fs-6" style="padding: 10px 15px;"><span class="d-flex text-white fw-bolder fs-6">{{ __('messages.employees.edit.02') }}</span></div>
                    <h3 class="card-title"></h3>
                    <div class="card-toolbar"></div>
                </div>
                <div class="card-body">
                    <form action="{{ route('Employees.Update', $employee->id) }}" id="editForm" enctype="multipart/form-data" method="POST" autocomplete="off">
                        @method('PUT')
                        @csrf
                        @if($errors->any())
                            {{ implode('', $errors->all('<div>:message</div>')) }}
                        @endif
                        <div class="row">
                            <div class="col-6">
                                <label for="input-first_name" class="required form-label">{{ __('messages.users.form.01') }}</label>
                                <input type="text" name="input-first_name" id="input-first_name" class="form-control @error('input-first_name') is-invalid error-input @enderror" placeholder="{{ __('messages.users.form.01') }} {{ __('messages.forms.01') }}" maxlength="50" value="{{ old('input-first_name', $employee->linkedUser->first_name) }}"/>
                                @if ($errors->has('input-first_name'))
                                    <div class="invalid-feedback">
                                        @ {{ $errors->first('input-first_name') }}
                                    </div>
                                @endif
                            </div>
                            <div class="col-6">
                                <label for="input-last_name" class="required form-label">{{ __('messages.users.form.02') }}</label>
                                <input type="text" name="input-last_name" id="input-last_name" class="form-control @error('input-last_name') is-invalid error-input @enderror" placeholder="{{ __('messages.users.form.02') }} {{ __('messages.forms.01') }}" maxlength="50" value="{{ old('input-last_name', $employee->linkedUser->last_name) }}"/>
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
                                <input type="email" name="input-email" id="input-email" class="form-control" placeholder="{{ __('messages.users.form.03') }} {{ __('messages.forms.01') }}" maxlength="50" value="{{ old('input-email', $employee->linkedUser->email) }}" disabled/>
                            </div>
                        </div>
                        <div class="row mt-6">
                            <div class="col-6">
                                <label for="input-extension_no" class="required form-label">{{ __('messages.employees.form.01') }}</label>
                                <select class="form-select @error('input-extension_no') is-invalid error-input @enderror" name="input-extension_no" id="input-extension_no" data-control="select2" data-placeholder="{{ __('messages.forms.06') }}" data-hide-search="true">
                                    <option value="0" {{ old('input-extension_no', $employee->extension_no) == "0" ? 'selected' : '' }}>{{ __('messages.employees.form.01.01') }}</option>
                                    @if($employee->extension_no != "0")
                                        <option value="{{ $employee->extension_no }}" {{ old('input-extension_no', $employee->extension_no) == $employee->extension_no ? 'selected' : '' }}>{{ $employee->extension_no }}</option>
                                    @endif
                                    @foreach($emptyExtensions as $emptyExtension)
                                        <option value="{{ $emptyExtension['extension'] }}" @if (old('input-extension_no', $employee->extension_no) == $emptyExtension['extension']) selected="selected" @endif>{{ $emptyExtension['extension'] }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('input-extension_no'))
                                    <div class="invalid-feedback">
                                        @ {{ $errors->first('input-extension_no') }}
                                    </div>
                                @endif
                            </div>
                            <div class="col-6">
                                <label for="input-show_numbers" class="required form-label">{{ __('messages.employees.form.03') }}</label>
                                <select class="form-select @error('input-show_numbers') is-invalid error-input @enderror" name="input-show_numbers" id="input-show_numbers" data-control="select2" data-placeholder="{{ __('messages.forms.06') }}" data-hide-search="true">
                                    <option></option>
                                    <option value="1" {{ old('input-show_numbers', $employee->show_numbers) == '1' ? 'selected' : '' }}>{{ __('messages.employees.form.03.01') }}</option>
                                    <option value="0" {{ old('input-show_numbers', $employee->show_numbers) == '0' ? 'selected' : '' }}>{{ __('messages.employees.form.03.02') }}</option>
                                </select>
                                @if ($errors->has('input-show_numbers'))
                                    <div class="invalid-feedback">
                                        @ {{ $errors->first('input-show_numbers') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="row mt-6">
                            <div class="col-12">
                                <label for="input-is_active" class="required form-label">{{ __('messages.employees.form.02') }}</label>
                                <select class="form-select @error('input-is_active') is-invalid error-input @enderror" name="input-is_active" id="input-is_active" data-control="select2" data-placeholder="{{ __('messages.forms.06') }}" data-hide-search="true">
                                    <option></option>
                                    <option value="1" {{ old('input-is_active', $employee->linkedUser->is_active) == '1' ? 'selected' : '' }}>{{ __('messages.employees.form.02.01') }}</option>
                                    <option value="0" {{ old('input-is_active', $employee->linkedUser->is_active) == '0' ? 'selected' : '' }}>{{ __('messages.employees.form.02.02') }}</option>
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
                    <button type="submit" class="btn btn-warning btn-sm" form="editForm">
                        <span class="indicator-label">{{ __('messages.forms.05') }}</span>
                        <span class="indicator-progress">{{ __('messages.forms.03') }} <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>
                    <a href="{{ route('Employees.Index') }}" class="btn btn-light-danger btn-sm ms-2">{{ __('messages.forms.04') }}</a>
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
