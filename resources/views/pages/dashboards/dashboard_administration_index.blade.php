@extends('layouts.application.layout_application')
@section('PageTitle', __('messages.dashboard.administration.01'))

@section('PageVendorCSS')
    <link href="{{ asset('assets/plugins/custom/limarquee/css/liMarquee.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('PageCustomCSS')

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
        <div class="col-xl-4 mb-6">
            <!--begin::Slider Widget 1-->
            <div id="kt_sliders_widget_1_slider" class="card card-flush carousel carousel-custom carousel-stretch slide h-xl-100" data-bs-ride="carousel" data-bs-interval="5000">
                <!--begin::Header-->
                <div class="card-header pt-5">
                    <!--begin::Title-->
                    <h4 class="card-title d-flex align-items-start flex-column">
                        <span class="card-label fw-bold text-primary">Sistem Durumu</span>
                        <span class="text-gray-500 mt-1 fw-bold fs-7">Uplink Süresi: 48.798 Saat</span>
                    </h4>
                    <!--end::Title-->
                    <!--begin::Toolbar-->
                    <div class="card-toolbar">
                        <!--begin::Carousel Indicators-->
                        <ol class="p-0 m-0 carousel-indicators carousel-indicators-bullet carousel-indicators-active-primary">
                            <li data-bs-target="#kt_sliders_widget_1_slider" data-bs-slide-to="0" class="active ms-1"></li>
                            <li data-bs-target="#kt_sliders_widget_1_slider" data-bs-slide-to="1" class="ms-1"></li>
                            <li data-bs-target="#kt_sliders_widget_1_slider" data-bs-slide-to="2" class="ms-1"></li>
                        </ol>
                        <!--end::Carousel Indicators-->
                    </div>
                    <!--end::Toolbar-->
                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body py-6">
                    <!--begin::Carousel-->
                    <div class="carousel-inner mt-n5">
                        <!--begin::Item-->
                        <div class="carousel-item active show">
                            <!--begin::Wrapper-->
                            <div class="d-flex align-items-center mb-5">
                                <!--begin::Info-->
                                <div class="m-0">
                                    <!--begin::Items-->
                                    <div class="d-flex d-grid gap-5">
                                        <div class="d-flex align-items-center me-3">
                                            <img src="{{ asset('assets/media/svg/misc/cpu.svg') }}" class="me-4 w-60px" alt="Disc" style="margin-top: 10px;">
                                            <div class="flex-grow-1 w-250px">
                                                <!--begin::Progress-->
                                                <div class="d-flex align-items-center flex-column mt-3 w-100">
                                                    <div class="d-flex justify-content-between fw-bold fs-6 text-active-danger opacity-75 w-100 mt-auto mb-2">
                                                        <span>{{ __('messages.dashboard.administration.13') }}</span>
                                                        <span>62%</span>
                                                    </div>
                                                    <div class="h-8px mx-3 w-100 bg-warning bg-opacity-50 rounded">
                                                        <div class="bg-success rounded h-8px" role="progressbar" style="width: 62%;" aria-valuenow="62" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                                <!--end::Progress-->
                                                <span class="text-gray-500 fw-semibold d-block fs-6 mt-2 float-start">@ Intel Xeon X5550 2.6 GHz 8 MB</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <div class="carousel-item">
                            <!--begin::Wrapper-->
                            <div class="d-flex align-items-center mb-5">
                                <!--begin::Info-->
                                <div class="m-0">
                                    <!--begin::Items-->
                                    <div class="d-flex d-grid gap-5">
                                        <div class="d-flex align-items-center me-3">
                                            <img src="{{ asset('assets/media/svg/misc/disc.svg') }}" class="me-4 w-60px" alt="Cpu" style="margin-top: 10px;">
                                            <div class="flex-grow-1 w-250px">
                                                <!--begin::Progress-->
                                                <div class="d-flex align-items-center flex-column mt-3 w-100">
                                                    <div class="d-flex justify-content-between fw-bold fs-6 text-active-danger opacity-75 w-100 mt-auto mb-2">
                                                        <span>{{ __('messages.dashboard.administration.14') }}</span>
                                                        <span>{{ intval($diskPercentage) }}%</span>
                                                    </div>
                                                    <div class="h-8px mx-3 w-100 bg-warning bg-opacity-50 rounded">
                                                        <div class="bg-success rounded h-8px" role="progressbar" style="width: {{$diskPercentage}}%;" aria-valuenow="{{ $diskPercentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                                <!--end::Progress-->
                                                <span class="text-gray-500 fw-semibold d-block fs-6 mt-2 float-start">@ {{ formatBytes($diskUsedSpace) }} ({{ formatBytes($diskTotalSpace) }})</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <div class="carousel-item">
                            <!--begin::Wrapper-->
                            <div class="d-flex align-items-center mb-5">
                                <!--begin::Info-->
                                <div class="m-0">
                                    <!--begin::Items-->
                                    <div class="d-flex d-grid gap-5">
                                        <div class="d-flex align-items-center me-3">
                                            <img src="{{ asset('assets/media/svg/misc/memory.svg') }}" class="me-4 w-60px" alt="Memory" style="margin-top: 10px;">
                                            <div class="flex-grow-1 w-250px">
                                                @php $ramPercentage = rand(35, 45); @endphp

                                                    <!--begin::Progress-->
                                                <div class="d-flex align-items-center flex-column mt-3 w-100">
                                                    <div class="d-flex justify-content-between fw-bold fs-6 text-active-danger opacity-75 w-100 mt-auto mb-2">
                                                        <span>{{ __('messages.dashboard.administration.15') }}</span>
                                                        <span>{{ $ramPercentage }}%</span>
                                                    </div>
                                                    <div class="h-8px mx-3 w-100 bg-warning bg-opacity-50 rounded">
                                                        <div class="bg-success rounded h-8px" role="progressbar" style="width: {{ $ramPercentage }}%;" aria-valuenow="{{ $ramPercentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                                <!--end::Progress-->
                                                <span class="text-gray-500 fw-semibold d-block fs-6 mt-2 float-start">@ 12.45 GB (32 GB)</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end::Item-->
                    </div>
                    <!--end::Carousel-->
                </div>
                <!--end::Body-->
            </div>
            <!--end::Slider Widget 1-->
        </div>

        <div class="col-xl-4 mb-6">
            <div class="card h-xl-100">
                <!--begin::Card body-->
                <div class="card-body d-flex flex-center flex-column py-9 px-5">
                    <div class="d-flex flex-column text-center px-9">
                        <a href="#" class="card-title fw-bold text-muted text-hover-primary fs-4"><span id="userMessages" class="text-gray-800 fw-bold fs-5"></span></a>
                        <!--begin::Photo-->
                        <div class="symbol symbol-150px mb-4">
                            <img src="{{ asset('assets/custom/media/blank.png') }}" alt="user" />
                        </div>
                        <!--end::Photo-->
                        <!--begin::Info-->
                        <div class="text-center">
                            <!--begin::Name-->
                            <span class="text-gray-800 fw-bold fs-4">{{ Auth::user()->getUserFullName() }}</span>
                            <!--end::Name-->
                            <!--begin::Position-->
                            <span class="text-muted d-block fw-semibold">{{ (Auth::user()->client_id == 0) ? Settings::get('app_name') : Auth::user()->linkedClient()->company_name }}</span>
                            <!--end::Position-->
                        </div>
                        <!--end::Info-->
                    </div>
                </div>
                <!--begin::Card body-->
            </div>
        </div>

        <div class="col-xl-4 mb-6">
            <div class="card card-flush h-lg-100">
                <!--begin::Header-->
                <div class="card-header pt-5">
                    <!--begin::Title-->
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bold text-primary">{{ __('messages.dashboard.administration.02') }}</span>
                        <span class="text-gray-500 mt-1 fw-semibold fs-6">{{ Settings::get('app_name') }}</span>
                    </h3>
                    <!--end::Title-->
                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body pt-5">
                    <!--begin::Item-->
                    <div class="d-flex flex-stack">
                        <!--begin::Section-->
                        <div class="text-gray-700 fw-semibold fs-6 me-2">{{ __('messages.dashboard.administration.02.01') }}</div>
                        <!--end::Section-->
                        <!--begin::Statistics-->
                        <div class="d-flex align-items-senter">
                            <span class="text-gray-900 fw-bolder fs-6" data-kt-countup="true" data-kt-countup-value="{{ $totalUserCount }}">{{ $totalUserCount }}</span>
                        </div>
                        <!--end::Statistics-->
                    </div>
                    <!--end::Item-->
                    <!--begin::Separator-->
                    <div class="separator separator-dashed my-3"></div>
                    <!--end::Separator-->
                    <!--begin::Item-->
                    <div class="d-flex flex-stack">
                        <!--begin::Section-->
                        <div class="text-gray-700 fw-semibold fs-6 me-2">{{ __('messages.dashboard.administration.02.02') }}</div>
                        <!--end::Section-->
                        <!--begin::Statistics-->
                        <div class="d-flex align-items-senter">
                            <!--begin::Number-->
                            <span class="text-gray-900 fw-bolder fs-6" data-kt-countup="true" data-kt-countup-value="{{ $totalCustomerCount }}">{{ $totalCustomerCount }}</span>
                            <!--end::Number-->
                        </div>
                        <!--end::Statistics-->
                    </div>
                    <!--end::Item-->
                    <!--begin::Separator-->
                    <div class="separator separator-dashed my-3"></div>
                    <!--end::Separator-->
                    <!--begin::Item-->
                    <div class="d-flex flex-stack">
                        <!--begin::Section-->
                        <div class="text-gray-700 fw-semibold fs-6 me-2">{{ __('messages.dashboard.administration.02.03') }}</div>
                        <!--end::Section-->
                        <!--begin::Statistics-->
                        <div class="d-flex align-items-senter">
                            <!--begin::Number-->
                            <span class="text-gray-900 fw-bolder fs-6" data-kt-countup="true" data-kt-countup-value="0">0</span>
                            <!--end::Number-->
                        </div>
                        <!--end::Statistics-->
                    </div>
                    <!--end::Item-->
                    <!--begin::Separator-->
                    <div class="separator separator-dashed my-3"></div>
                    <!--end::Separator-->
                    <!--begin::Item-->
                    <div class="d-flex flex-stack">
                        <!--begin::Section-->
                        <div class="text-gray-700 fw-semibold fs-6 me-2">{{ __('messages.dashboard.administration.02.04') }}</div>
                        <!--end::Section-->
                        <!--begin::Statistics-->
                        <div class="d-flex align-items-senter">
                            <!--begin::Number-->
                            <span class="text-gray-900 fw-bolder fs-6">{{ $totalSummaryReturn }}</span>
                            <!--end::Number-->
                        </div>
                        <!--end::Statistics-->
                    </div>
                    <!--end::Item-->
                </div>
                <!--end::Body-->
            </div>
        </div>

    </div>

    <div class="row g-5 g-xl-8">
        <div class="col-lg-4 mb-6">
            <!--begin::Card-->
            <div class="card overlay overflow-hidden h-125px overlay-block" style="cursor: default !important;">
                <div class="card-body p-0">
                    <div class="overlay-wrapper">
                        <img src="assets/media/dashboard/D_001.jpg" alt="" class="w-100 rounded"/>
                    </div>
                    <div class="overlay-layer bg-dark bg-opacity-25 pulse pulse-primary">
                        <span class="pulse-ring border-4"></span>
                        <a href="{{ route('Clients.Index') }}" class="btn btn-light-primary btn-shadow hover-scale">{{ __('messages.dashboard.administration.04') }}</a>
                    </div>
                </div>
            </div>
            <!--end::Card-->
        </div>

        <div class="col-lg-4 mb-6">
            <!--begin::Card-->
            <div class="card overlay overflow-hidden h-125px overlay-block" style="cursor: default !important;">
                <div class="card-body p-0">
                    <div class="overlay-wrapper">
                        <img src="assets/media/dashboard/D_002.jpg" alt="" class="w-100 rounded"/>
                    </div>
                    <div class="overlay-layer bg-dark bg-opacity-25 pulse pulse-info">
                        <span class="pulse-ring border-4"></span>
                        <a href="{{ route('Announcements.Index') }}" class="btn btn-light-info btn-shadow hover-scale">{{ __('messages.dashboard.administration.05') }}</a>
                    </div>
                </div>
            </div>
            <!--end::Card-->
        </div>

        <div class="col-lg-4 mb-6">
            <!--begin::Card-->
            <div class="card overlay overflow-hidden h-125px overlay-block" style="cursor: default !important;">
                <div class="card-body p-0">
                    <div class="overlay-wrapper">
                        <img src="assets/media/dashboard/D_003.jpg" alt="" class="w-100 rounded"/>
                    </div>
                    <div class="overlay-layer bg-dark bg-opacity-25 pulse pulse-danger">
                        <span class="pulse-ring border-4"></span>
                        <a href="{{ route('PaymentOrders.Index') }}" class="btn btn-light-danger btn-shadow hover-scale">{{ __('messages.dashboard.administration.06') }}</a>
                    </div>
                </div>
            </div>
            <!--end::Card-->
        </div>
    </div>

    <div class="row g-5 g-xl-8">
        <div class="col-xxl-4">
            <div class="card h-xl-100">
                <div class="card-header align-items-center border-0">
                    <!--begin::Title-->
                    <h4 class="card-title d-flex align-items-start flex-column">
                        <span class="card-label fw-bold text-primary">{{ __('messages.dashboard.administration.08') }}</span>
                        <span class="text-gray-400 mt-1 fw-bold fs-7">{{ __('messages.dashboard.administration.08.01') }}</span>
                    </h4>
                    <!--end::Title-->
                </div>

                <div class="card-body pt-2">
                    @if($clientsUpcomingPayments->count() >= 1)
                        @foreach($clientsUpcomingPayments as $clientsUpcomingPayment)
                            <!--begin::Item-->
                            <div class="d-flex align-items-center mb-4">
                                <!--begin::Bullet-->
                                <span class="bullet bullet-vertical h-20px bg-success me-4"></span>
                                <!--end::Bullet-->
                                <!--begin::Description-->
                                <div class="flex-grow-1">
                                    <a href="" target="_blank" class="text-gray-800 fs-6 text-hover-primary">
                                        {{ $clientsUpcomingPayment->linkedClient->company_name }}
                                    </a>
                                </div>
                                <!--end::Description-->
                                <a href="xxxx" target="_blank" class="badge badge-light-success fs-8 fw-bold">{{ __('messages.dashboard.administration.08.02') }}</a>
                            </div>
                            <!--end::Item-->
                        @endforeach
                    @else
                        <div class="row g-5 g-xl-8 mb-2">
                            <div class="col-12">
                                <div class="alert alert-warning d-flex align-items-center p-5">
                                    <i class="ki-duotone ki-shield-tick fs-2hx text-warning me-4"><span class="path1"></span><span class="path2"></span></i>
                                    <div class="d-flex flex-column">
                                        <h4 class="mb-1">@ {{ __('messages.dashboard.administration.08.03') }}</h4>
                                        <span>- {{ __('messages.dashboard.administration.08.04') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-xxl-4">
            <div class="card h-xl-100">
                <div class="card-header align-items-center border-0">
                    <!--begin::Title-->
                    <h4 class="card-title d-flex align-items-start flex-column">
                        <span class="card-label fw-bold text-primary">{{ __('messages.dashboard.administration.09') }}</span>
                        <span class="text-gray-400 mt-1 fw-bold fs-7">{{ __('messages.dashboard.administration.09.01') }}</span>
                    </h4>
                    <!--end::Title-->
                </div>

                <div class="card-body pt-2">
                    @if($smsDevicesLowCredit->count() >= 1)
                        @foreach($smsDevicesLowCredit as $smsDevice)
                            <!--begin::Item-->
                            <div class="d-flex align-items-center mb-4">
                                <!--begin::Bullet-->
                                <span class="bullet bullet-vertical h-20px bg-success me-4"></span>
                                <!--end::Bullet-->
                                <!--begin::Description-->
                                <div class="flex-grow-1">
                                    <a href="" target="_blank" class="text-gray-800 fs-6 text-hover-primary">
                                        {{ $smsDevice->device_name }} ({{ __('messages.dashboard.clients.07', ['credits' => $smsDevice->credit_count]) }})
                                    </a>
                                </div>
                                <!--end::Description-->
                                <a href="{{ route('SMSDevices.Edit', $smsDevice->id) }}" target="_blank" class="badge badge-light-success fs-8 fw-bold">{{ __('messages.dashboard.administration.09.02') }}</a>
                            </div>
                            <!--end::Item-->
                        @endforeach
                    @else
                        <div class="row g-5 g-xl-8 mb-2">
                            <div class="col-12">
                                <div class="alert alert-warning d-flex align-items-center p-5">
                                    <i class="ki-duotone ki-shield-tick fs-2hx text-warning me-4"><span class="path1"></span><span class="path2"></span></i>
                                    <div class="d-flex flex-column">
                                        <h4 class="mb-1">@ {{ __('messages.dashboard.administration.09.03') }}</h4>
                                        <span>- {{ __('messages.dashboard.administration.09.04') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-xxl-4">
            <div class="card h-xl-100">
                <div class="card-header align-items-center border-0">
                    <!--begin::Title-->
                    <h4 class="card-title d-flex align-items-start flex-column">
                        <span class="card-label fw-bold text-primary">{{ __('messages.dashboard.administration.12') }}</span>
                        <span class="text-gray-400 mt-1 fw-bold fs-7">{{ __('messages.dashboard.administration.12.01') }}</span>
                    </h4>
                    <!--end::Title-->
                </div>

                <div class="card-body pt-2">
                    @if($smsClientsLowCredit->count() >= 1)
                        @foreach($smsClientsLowCredit as $clientSMSCredits)
                            <!--begin::Item-->
                            <div class="d-flex align-items-center mb-4">
                                <!--begin::Bullet-->
                                <span class="bullet bullet-vertical h-20px bg-success me-4"></span>
                                <!--end::Bullet-->
                                <!--begin::Description-->
                                <div class="flex-grow-1">
                                    <a href="" target="_blank" class="text-gray-800 fs-6 text-hover-primary">
                                        {{ $clientSMSCredits->linkedClient->company_name }} ({{ __('messages.dashboard.clients.07', ['credits' => $clientSMSCredits->sms_credits]) }})
                                    </a>
                                </div>
                                <!--end::Description-->
                                <a href="{{ route('SMSCredits.Index') }}" target="_blank" class="badge badge-light-success fs-8 fw-bold">{{ __('messages.dashboard.administration.12.03') }}</a>
                            </div>
                            <!--end::Item-->
                        @endforeach
                    @else
                        <div class="row g-5 g-xl-8 mb-2">
                            <div class="col-12">
                                <div class="alert alert-warning d-flex align-items-center p-5">
                                    <i class="ki-duotone ki-shield-tick fs-2hx text-warning me-4"><span class="path1"></span><span class="path2"></span></i>
                                    <div class="d-flex flex-column">
                                        <h4 class="mb-1">@ {{ __('messages.dashboard.administration.09.03') }}</h4>
                                        <span>- {{ __('messages.dashboard.administration.12.02') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('PageVendorJS')
    <script src="{{ asset('assets/plugins/custom/limarquee/js/jquery.liMarquee.js') }}"></script>
@endsection

@section('PageCustomJS')

@endsection

@section('PageModals')

@endsection
