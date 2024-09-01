@extends('layouts.application.layout_application')
@section('PageTitle', __('messages.my_invoices.detail.01'))

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
                    <div class="ribbon-label bg-primary fs-6" style="padding: 10px 15px;"><span class="d-flex text-white fw-bolder fs-6">{{ __('messages.my_invoices.detail.02') }}</span></div>
                    <h3 class="card-title"></h3>
                    <div class="card-toolbar">
                        <a href="{{ route('PaymentOrders.Index') }}" class="btn btn-light-warning btn-sm ms-2">
                            {{ __('messages.sweetalert.04') }}
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex flex-column flex-xl-row">
                        <!--begin::Content-->
                        <div class="flex-lg-row-fluid mb-10 mb-xl-0">
                            <!--begin::Invoice 2 content-->
                            <div class="mt-n1">
                                <!--begin::Top-->
                                <div class="d-flex flex-stack pb-10">
                                    <!--begin::Logo-->
                                    <a href="#">
                                        <img alt="Logo" src="{{ asset('assets/custom/media/logo_dark.svg') }}" class="h-45px app-sidebar-logo-default theme-dark-show"/>
                                        <img alt="Logo" src="{{ asset('assets/custom/media/logo.svg') }}" class="h-45px app-sidebar-logo-default theme-light-show"/>
                                    </a>
                                    <!--end::Logo-->
                                    @if($invoice->status == 1)
                                        <span class="badge badge-light-success">{{ __('messages.my_invoices.detail.13') }}</span>
                                    @elseif($invoice->status == 2)
                                        <span class="badge badge-light-danger">{{ __('messages.my_invoices.detail.17') }}</span>
                                    @endif
                                </div>
                                <!--end::Top-->
                                <!--begin::Wrapper-->
                                <div class="m-0">
                                    <!--begin::Row-->
                                    <div class="d-flex justify-content-between mb-4">
                                        <!--end::Col-->
                                        <div>
                                            <!--end::Label-->
                                            <div class="fw-semibold fs-6 text-gray-600 mb-1">{{ __('messages.my_invoices.detail.03') }}</div>
                                            <!--end::Label-->
                                            <!--end::Col-->
                                            <div class="fw-bold fs-4 text-danger">{{ date('Ym', strtotime($invoice->created_at)).$invoice->id }}</div>
                                            <!--end::Col-->
                                        </div>
                                        <!--end::Col-->
                                        <!--end::Col-->
                                        <div style="text-align: right">
                                            <!--end::Label-->
                                            <div class="fw-semibold fs-6 text-gray-600 mb-1">{{ __('messages.my_invoices.detail.04') }}</div>
                                            <!--end::Label-->
                                            <!--end::Col-->
                                            <div class="fw-bold fs-4">{{ date('d/m/Y H:i', strtotime($invoice->created_at)) }}</div>
                                            <!--end::Col-->
                                        </div>
                                        <!--end::Col-->
                                    </div>
                                    <!--end::Row-->

                                    <!--begin::Content-->
                                    <div class="flex-grow-1">
                                        <!--begin::Table-->
                                        <div class="table-responsive border-bottom mb-9">
                                            <table class="table mb-3">
                                                <thead>
                                                    <tr class="border-bottom fs-6 fw-bold text-muted">
                                                        <th class="min-w-175px pb-2">{{ __('messages.my_invoices.detail.05') }}</th>
                                                        @if($invoice->invoice_type == 1)
                                                            <th class="min-w-70px text-end pb-2">{{ __('messages.my_invoices.detail.06') }}</th>
                                                        @elseif($invoice->invoice_type == 2)
                                                            <th class="min-w-70px text-end pb-2">{{ __('messages.my_invoices.detail.20') }}</th>
                                                        @endif
                                                        <th class="min-w-100px text-end pb-2">{{ __('messages.my_invoices.detail.07') }}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                @if($invoice->invoice_type == 1)
                                                    <tr class="fw-bold text-gray-700 fs-5 text-end">
                                                        <td class="d-flex align-items-center pt-6">
                                                            <i class="fa fa-genderless text-danger fs-2 me-2"></i>{{ __('messages.my_invoices.detail.08') }}</td>
                                                        <td class="pt-6">{{ __('messages.my_invoices.detail.09') }}</td>
                                                        <td class="pt-6 text-gray-900 fw-bolder">{{ Number::withLocale('tr', fn () => Number::format($invoice->payment_amount)).' '.$invoice->currency }}</td>
                                                    </tr>
                                                @elseif($invoice->invoice_type == 2)
                                                    <tr class="fw-bold text-gray-700 fs-5 text-end">
                                                        <td class="d-flex align-items-center pt-6">
                                                            <i class="fa fa-genderless text-warning fs-2 me-2"></i>{{ __('messages.my_invoices.detail.18') }}</td>
                                                        <td class="pt-6">{{ $smsCreditLog->credit_to_add }} {{ __('messages.my_invoices.detail.21') }}</td>
                                                        <td class="pt-6 text-gray-900 fw-bolder">{{ Number::withLocale('tr', fn () => Number::format($invoice->payment_amount)).' '.$invoice->currency }}</td>
                                                    </tr>
                                                @endif
                                                </tbody>
                                            </table>
                                        </div>
                                        <!--end::Table-->
                                        <!--begin::Container-->
                                        <div class="d-flex justify-content-end">
                                            <!--begin::Section-->
                                            <div class="mw-300px">
                                                <!--begin::Item-->
                                                <div class="d-flex flex-stack mb-3">
                                                    <!--begin::Accountname-->
                                                    <div class="fw-semibold pe-10 text-gray-600 fs-7">{{ __('messages.my_invoices.detail.10') }}:</div>
                                                    <!--end::Accountname-->
                                                    <!--begin::Label-->
                                                    <div class="text-end fw-bold fs-6 text-gray-800">{{ Number::withLocale('tr', fn () => Number::format($invoice->payment_amount)).' '.$invoice->currency }}</div>
                                                    <!--end::Label-->
                                                </div>
                                                <!--end::Item-->
                                                <!--begin::Item-->
                                                <div class="d-flex flex-stack mb-3">
                                                    <!--begin::Accountname-->
                                                    <div class="fw-semibold pe-10 text-gray-600 fs-7">{{ __('messages.my_invoices.detail.11') }}:</div>
                                                    <!--end::Accountname-->
                                                    <!--begin::Label-->
                                                    <div class="text-end fw-bold fs-6 text-gray-800">0.00 {{ $invoice->currency }}</div>
                                                    <!--end::Label-->
                                                </div>
                                                <!--end::Item-->
                                                <!--begin::Item-->
                                                <div class="d-flex flex-stack mb-3">
                                                    <!--begin::Accountnumber-->
                                                    <div class="fw-semibold pe-10 text-gray-600 fs-7">{{ __('messages.my_invoices.detail.12') }}:</div>
                                                    <!--end::Accountnumber-->
                                                    <!--begin::Number-->
                                                    <div class="text-end fw-bold fs-6 text-gray-800">{{ Number::withLocale('tr', fn () => Number::format($invoice->payment_amount)).' '.$invoice->currency }}</div>
                                                    <!--end::Number-->
                                                </div>
                                                <!--end::Item-->
                                            </div>
                                            <!--end::Section-->
                                        </div>
                                        <!--end::Container-->
                                    </div>
                                    <!--end::Content-->
                                </div>
                                <!--end::Wrapper-->
                            </div>
                            <!--end::Invoice 2 content-->
                        </div>
                        <!--end::Content-->
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
