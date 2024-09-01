@extends('layouts.application.layout_application')
@section('PageTitle', __('messages.organization_charts.index.01'))

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
    <div class="row g-5 g-xl-8 mb-6">
        <div class="col-xl-12">
            <div class="alert alert-warning d-flex align-items-center p-5">
                <i class="ki-duotone ki-shield-tick fs-2hx text-warning me-4"><span class="path1"></span><span class="path2"></span></i>
                <div class="d-flex flex-column">
                    <h4 class="mb-1">@ {{ __('messages.organization_charts.alert.01') }}</h4>
                    <span>- {{ __('messages.organization_charts.alert.02') }}</span>
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
