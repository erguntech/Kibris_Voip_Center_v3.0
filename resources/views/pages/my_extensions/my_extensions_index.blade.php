@extends('layouts.application.layout_application')
@section('PageTitle', __('messages.myextensions.index.01'))

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
            @if (session('result'))
                @include('components.alert', $data = ['alert_type' => session('result'), 'alert_title' => session('title'), 'alert_content' => session('content')])
            @endif
            <div class="card shadow-sm">
                <div class="card-header ribbon ribbon-start ribbon-clip">
                    <div class="ribbon-label bg-primary fs-6" style="padding: 10px 15px;"><span class="d-flex text-white fw-bolder fs-6">{{ __('messages.myextensions.index.02') }}</span></div>
                    <h3 class="card-title"></h3>
                    <div class="card-toolbar"></div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <!--begin::Table-->
                        <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 mb-0">
                            <!--begin::Table head-->
                            <thead>
                            <tr class="border-0">
                                <th class="p-0"></th>
                                <th class="p-0 min-w-100px text-end"></th>
                            </tr>
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody>
                            @foreach($extensions as $extension)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="symbol symbol-45px me-5">
                                                <span class="symbol-label bg-light-success text-success fw-bold">{{ $extension['extension'] }}</span>
                                            </div>
                                            <div class="d-flex justify-content-start flex-column">
                                                <a href="#" class="text-white fw-bold mb-1 fs-6">
                                                    @php
                                                        @$isAssigned = \App\Models\Employee::where('extension_no', $extension['extension'])->first();
                                                        if(@$isAssigned) {
                                                            echo __('messages.client_extension_selection.index.03').": ".$isAssigned->linkedUser->getUserFullName();
                                                        } else {
                                                            echo __('messages.client_extension_selection.index.04');
                                                        }
                                                    @endphp
                                                </a>
                                                <a href="#" class="text-muted text-hover-primary fw-semibold text-muted d-block fs-7">
                                                    {{ $client->company_name }}
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-end">
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            <!--end::Table body-->
                        </table>
                        <!--end::Table-->
                    </div>
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
