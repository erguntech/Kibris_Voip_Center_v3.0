@extends('layouts.application.layout_application')
@section('PageTitle', __('messages.my_announcements.index.01'))

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
            @if ($announcements->count() < 1)
                <div class="alert alert-info d-flex align-items-center p-5">
                    <i class="ki-duotone ki-shield-tick fs-2hx text-info me-4"><span class="path1"></span><span class="path2"></span></i>
                    <div class="d-flex flex-column">
                        <h4 class="mb-1">@ {{ __('messages.my_announcements.alert.01') }}</h4>
                        <span>- {{ __('messages.my_announcements.alert.02') }}</span>
                    </div>
                </div>
            @else
                <div class="card shadow-sm">
                        <div class="card-header ribbon ribbon-start ribbon-clip">
                            <div class="ribbon-label bg-primary fs-6" style="padding: 10px 15px;"><span class="d-flex text-white fw-bolder fs-6">{{ __('messages.my_announcements.index.02') }}</span></div>
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
                                    </tr>
                                    </thead>
                                    <!--end::Table head-->
                                    <!--begin::Table body-->
                                    <tbody>
                                    @foreach($announcements as $announcement)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <!--begin::Avatar-->
                                                    <div class="symbol symbol-45px me-5">
                                                        <img alt="number" src="{{ asset('assets/media/misc/announcement.svg') }}" />
                                                    </div>
                                                    <!--end::Avatar-->
                                                    <!--begin::Name-->
                                                    <div class="d-flex justify-content-start flex-column">
                                                        {{ $announcement->announcement_content }}
                                                        <br>
                                                        <span class="text-gray-500 fw-semibold d-block fs-7">{{ $announcement->createdUser->getUserFullName() }} - {{ date('d/m/Y H:i', strtotime($announcement->created_at)) }}</span>
                                                    </div>
                                                    <!--end::Name-->
                                                </div>
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
            @endif

        </div>
    </div>
@endsection

@section('PageVendorJS')

@endsection

@section('PageCustomJS')

@endsection

@section('PageModals')

@endsection
