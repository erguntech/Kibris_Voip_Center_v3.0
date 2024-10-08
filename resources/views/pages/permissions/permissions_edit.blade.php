@extends('layouts.application.layout_application')
@section('PageTitle', __('messages.permissions.edit.01'))

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
            <a href="{{ route('Permissions.Index') }}" class="text-muted text-hover-primary">{{ __('messages.permissions.index.01') }}</a>
        </li>
    </ul>
@endsection

@section('PageContent')
    <div class="row g-5 g-xl-8">
        <div class="col-xl-12">
            @if (session('result'))
                @include('components.alert', $data = ['alert_type' => session('result'), 'alert_title' => session('title'), 'alert_content' => session('content')])
            @endif
            <div class="card shadow-sm">
                <div class="card-header ribbon ribbon-start ribbon-clip">
                    <div class="ribbon-label bg-warning fs-6" style="padding: 10px 15px;"><span class="d-flex text-white fw-bolder fs-6">{{ __('messages.permissions.edit.02') }}</span></div>
                    <h3 class="card-title"></h3>
                    <div class="card-toolbar"></div>
                </div>
                <div class="card-body">
                    <form action="{{ route('Permissions.Update', $permission->id) }}" id="editForm" enctype="multipart/form-data" method="POST" autocomplete="off">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-6">
                                <label for="input-name" class="required form-label">{{ __('messages.permissions.form.01') }}</label>
                                <input type="text" name="input-name" id="input-name" class="form-control @error('input-name') is-invalid error-input @enderror" placeholder="{{ __('messages.permissions.form.01') }} {{ __('messages.forms.01') }}" maxlength="50" value="{{ old('input-name', $permission->name) }}"/>
                                @if ($errors->has('input-name'))
                                    <div class="invalid-feedback">
                                        @ {{ $errors->first('input-name') }}
                                    </div>
                                @endif
                            </div>
                            <div class="col-6">
                                <label for="input-description" class="form-label">{{ __('messages.permissions.form.02') }}</label>
                                <input type="text" name="input-description" id="input-description" class="form-control @error('input-description') is-invalid error-input @enderror" placeholder="{{ __('messages.permissions.form.02') }} {{ __('messages.forms.01') }}" maxlength="200" value="{{ old('input-description', $permission->description) }}"/>
                                @if ($errors->has('input-description'))
                                    <div class="invalid-feedback">
                                        @ {{ $errors->first('input-description') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="row mt-6">
                            <div class="col-12">
                                <label for="input-role_selection" class="required form-label">{{ __('messages.permissions.form.03') }}</label>
                                <select class="form-select @error('input-role_selection') is-invalid error-input @enderror" name="input-role_selection[]" id="input-role_selection" data-control="select2" data-placeholder="{{ __('messages.forms.06') }}" multiple="multiple">
                                    <option></option>
                                    @foreach($roles as $role)
                                        @if($role->hasPermissionTo($permission->name))
                                            <option value="{{ $role->id }}" selected="selected">{{ $role->name }}</option>
                                        @else
                                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                @if ($errors->has('input-role_selection'))
                                    <div class="invalid-feedback">
                                        * {{ $errors->first('input-role_selection') }}
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
                    <a href="{{ route('Permissions.Index') }}" class="btn btn-light-danger btn-sm ms-2">{{ __('messages.forms.04') }}</a>
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
