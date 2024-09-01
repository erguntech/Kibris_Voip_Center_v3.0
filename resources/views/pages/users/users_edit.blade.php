@extends('layouts.application.layout_application')
@section('PageTitle', __('messages.users.edit.01'))

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
            <a href="{{ route('Users.Index') }}" class="text-muted text-hover-primary">{{ __('messages.users.index.01') }}</a>
        </li>
    </ul>
@endsection

@section('PageContent')
    <div class="row g-5 g-xl-8">
        <div class="col-xl-12">
            <div class="alert alert-info d-flex align-items-center p-5">
                <i class="ki-duotone ki-shield-tick fs-2hx text-info me-4"><span class="path1"></span><span class="path2"></span></i>
                <div class="d-flex flex-column">
                    <h4 class="mb-1">@ {{ __('messages.users.alert.01') }}</h4>
                    <span>- {{ __('messages.users.alert.03') }}</span>
                </div>
            </div>

            @if (session('result'))
                <div class="mb-4">
                    @include('components.alert', $data = ['alert_type' => session('result'), 'alert_title' => session('title'), 'alert_content' => session('content')])
                </div>
            @endif

            <div class="card shadow-sm">
                <div class="card-header ribbon ribbon-start ribbon-clip">
                    <div class="ribbon-label bg-warning fs-6" style="padding: 10px 15px;"><span class="d-flex text-white fw-bolder fs-6">{{ __('messages.users.edit.02') }}</span></div>
                    <h3 class="card-title"></h3>
                    <div class="card-toolbar"></div>
                </div>
                <div class="card-body">
                    <form action="{{ route('Users.Update', $user->id) }}" id="editForm" enctype="multipart/form-data" method="POST" autocomplete="off">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-6">
                                <label for="input-first_name" class="required form-label">{{ __('messages.users.form.01') }}</label>
                                <input type="text" name="input-first_name" id="input-first_name" class="form-control @error('input-first_name') is-invalid error-input @enderror" placeholder="{{ __('messages.users.form.01') }} {{ __('messages.forms.01') }}" maxlength="50" value="{{ old('input-first_name', $user->first_name) }}"/>
                                @if ($errors->has('input-first_name'))
                                    <div class="invalid-feedback">
                                        @ {{ $errors->first('input-first_name') }}
                                    </div>
                                @endif
                            </div>
                            <div class="col-6">
                                <label for="input-last_name" class="required form-label">{{ __('messages.users.form.02') }}</label>
                                <input type="text" name="input-last_name" id="input-last_name" class="form-control @error('input-last_name') is-invalid error-input @enderror" placeholder="{{ __('messages.users.form.02') }} {{ __('messages.forms.01') }}" maxlength="50" value="{{ old('input-last_name', $user->last_name) }}"/>
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
                                <input type="email" name="input-email" id="input-email" class="form-control" placeholder="{{ __('messages.users.form.03') }} {{ __('messages.forms.01') }}" maxlength="50" value="{{ old('input-email', $user->email) }}" disabled/>
                            </div>
                        </div>
                        <div class="row mt-6">
                            <div class="col-6">
                                <label for="input-client_id" class="required form-label">{{ __('messages.users.form.04') }}</label>
                                <select class="form-select @error('input-client_id') is-invalid error-input @enderror" name="input-client_id" id="input-client_id" data-control="select2" data-placeholder="{{ __('messages.forms.06') }}">
                                    <option></option>
                                    <option value="0" {{ old('input-client_id', $user->client_id) == '0' ? 'selected' : '' }}>{{ Settings::get('app_name') }}</option>
                                    @foreach($clients as $client)
                                        <option value="{{ $client->id }}" {{ old('input-client_id', $user->client_id) == $client->id ? 'selected' : '' }}>{{ $client->company_name }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('input-client_id'))
                                    <div class="invalid-feedback">
                                        * {{ $errors->first('input-client_id') }}
                                    </div>
                                @endif
                            </div>
                            <div class="col-6">
                                <label for="input-is_active" class="required form-label">{{ __('messages.users.form.05') }}</label>
                                <select class="form-select @error('input-is_active') is-invalid error-input @enderror" name="input-is_active" id="input-is_active" data-control="select2" data-placeholder="{{ __('messages.forms.06') }}" data-hide-search="true">
                                    <option></option>
                                    <option value="1" {{ old('input-is_active', $user->is_active) == '1' ? 'selected' : '' }}>{{ __('messages.users.form.05.01') }}</option>
                                    <option value="0" {{ old('input-is_active', $user->is_active) == '0' ? 'selected' : '' }}>{{ __('messages.users.form.05.02') }}</option>
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
                                <label for="input-user_type" class="required form-label">{{ __('messages.users.form.07') }}</label>
                                <select class="form-select @error('input-user_type') is-invalid error-input @enderror" name="input-user_type" id="input-user_type" data-control="select2" data-placeholder="{{ __('messages.forms.06') }}" data-hide-search="true">
                                    <option></option>
                                    <option value="0" {{ old('input-user_type', $user->user_type) == '0' ? 'selected' : '' }}>{{ __('messages.users.form.07.01') }}</option>
                                    <option value="1" {{ old('input-user_type', $user->user_type) == '1' ? 'selected' : '' }}>{{ __('messages.users.form.07.02') }}</option>
                                    <option value="2" {{ old('input-user_type', $user->user_type) == '2' ? 'selected' : '' }}>{{ __('messages.users.form.07.03') }}</option>
                                    <option value="3" {{ old('input-user_type', $user->user_type) == '3' ? 'selected' : '' }}>{{ __('messages.users.form.07.04') }}</option>
                                    <option value="4" {{ old('input-user_type', $user->user_type) == '4' ? 'selected' : '' }}>{{ __('messages.users.form.07.05') }}</option>
                                </select>
                                @if ($errors->has('input-user_type'))
                                    <div class="invalid-feedback">
                                        @ {{ $errors->first('input-user_type') }}
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
                    <a href="{{ route('Users.Index') }}" class="btn btn-light-danger btn-sm ms-2">{{ __('messages.forms.04') }}</a>
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
