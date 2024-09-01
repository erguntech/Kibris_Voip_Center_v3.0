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
    <div class="row g-5 g-xl-8 mb-2">
        <div class="col-xl-4 mb-4">
            <div class="card h-xl-100">
                @php
                    $arrContextOptions=array(
                        "ssl"=>array(
                            "verify_peer"=>false,
                            "verify_peer_name"=>false,
                        ),
                    );
                    $content = @file_get_contents('https://www.trthaber.com/sondakika_articles.rss', false, stream_context_create($arrContextOptions));
                    $count = 0;
                    $a = new SimpleXMLElement($content);
                @endphp
                    <!--begin::Header-->
                <div class="card-header align-items-center border-0">
                    <!--begin::Title-->
                    <h4 class="card-title d-flex align-items-start flex-column">
                        <span class="card-label fw-bold text-primary">{{ __('messages.dashboard.administration.10') }}</span>
                        <span class="text-gray-400 mt-1 fw-bold fs-7">{{ __('messages.dashboard.administration.11') }}</span>
                    </h4>
                    <!--end::Title-->
                </div>
                <!--end::Header-->
                <div class="card-body pt-2">
                    @foreach($a->channel->item as $entry)
                        @if($count <= 4)
                            <!--begin::Item-->
                            <div class="d-flex align-items-center mb-4">
                                <!--begin::Bullet-->
                                <span class="bullet bullet-vertical h-20px bg-success me-4"></span>
                                <!--end::Bullet-->
                                <!--begin::Description-->
                                <div class="flex-grow-1">
                                    <a href="{!! $entry->link !!}" target="_blank" class="text-gray-800 fs-6 text-hover-primary">
                                        {!! $entry->title !!}
                                    </a>
                                </div>
                                <!--end::Description-->
                                <a href="{!! $entry->link !!}" target="_blank" class="badge badge-light-warning fs-8 fw-bold">Detay...</a>
                            </div>
                            <!--end::Item-->
                        @endif
                        @php
                            $count += 1;
                        @endphp
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-xl-4 mb-4">
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
                            <span class="text-muted d-block fw-semibold">{{ (Auth::user()->client_id == 0) ? Settings::get('app_name') : Auth::user()->linkedClient->company_name }}</span>
                            <!--end::Position-->
                        </div>
                        <!--end::Info-->
                    </div>
                </div>
                <!--begin::Card body-->
            </div>
        </div>
        <div class="col-xl-4 mb-4">
            <!--begin::Slider Widget 1-->
            <div id="kt_sliders_widget_1_slider" class="card card-flush carousel carousel-custom carousel-stretch slide h-xl-100" data-bs-ride="carousel" data-bs-interval="5000">
                <!--begin::Header-->
                <div class="card-header pt-5">
                    <!--begin::Title-->
                    <h4 class="card-title d-flex align-items-start flex-column">
                        <span class="card-label fw-bold text-primary">{{ __('messages.dashboard.employees.03') }}</span>
                        <span class="text-gray-500 mt-1 fw-bold fs-7">{{ __('messages.dashboard.employees.03.01') }}</span>
                    </h4>
                    <!--end::Title-->
                    <!--begin::Toolbar-->
                    <div class="card-toolbar">

                    </div>
                    <!--end::Toolbar-->
                </div>
                <!--end::Header-->

                <!--begin::Body-->
                <div class="card-body" id="extensionsData">
                    @if(Auth::user()->linkedEmployee->extension_no != null && Auth::user()->linkedEmployee->extension_no != "0")
                        <div class="card card-flush text-center bgi-no-repeat bgi-size-cover bgi-position-y-top bgi-position-x-center" style="background-image:url({{ asset('assets/media/svg/shapes/top-green.png') }})" data-bs-theme="light">
                            <div class="p-8 mb-1">
                                <div class="d-flex flex-column">
                                    <i class="ki-solid ki-like text-white fs-2hx mb-2"></i>
                                    <span class="fs-4 fw-bold text-white">{{ Auth::user()->linkedEmployee->extension_no }} ({{ Auth::user()->getUserFullName() }})</span>
                                    <span class="text-white pt-1 fw-semibold fs-6">Hazır</span>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="row g-5 g-xl-8 mb-2">
                            <div class="col-12">
                                <div class="alert alert-warning d-flex align-items-center p-5">
                                    <i class="ki-duotone ki-shield-tick fs-2hx text-warning me-4"><span class="path1"></span><span class="path2"></span></i>
                                    <div class="d-flex flex-column">
                                        <h4 class="mb-1">@ {{ __('messages.dashboard.employees.04.04') }}</h4>
                                        <span>- {{ __('messages.dashboard.employees.06') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                <!--end::Body-->
            </div>
            <!--end::Slider Widget 1-->
        </div>
    </div>

    <div class="row g-5 g-xl-8">
        <div class="col-xxl-6">
            <div class="card h-xl-100">
                <div class="card-header align-items-center border-0">
                    <!--begin::Title-->
                    <h4 class="card-title d-flex align-items-start flex-column">
                        <span class="card-label fw-bold text-primary">{{ __('messages.dashboard.employees.04') }}</span>
                        <span class="text-gray-400 mt-1 fw-bold fs-7">{{ __('messages.dashboard.employees.04.01') }}</span>
                    </h4>
                    <!--end::Title-->
                </div>

                <div class="card-body pt-2">
                    <!--begin::Chart-->
                    @if($assignedData->count() >= 1)
                        @foreach($assignedData as $assignedDataContent)
                            <!--begin::Item-->
                            <div class="d-flex align-items-center mb-4">
                                <!--begin::Bullet-->
                                <span class="bullet bullet-vertical h-20px bg-success me-4"></span>
                                <!--end::Bullet-->
                                <!--begin::Description-->
                                <div class="flex-grow-1">
                                    <a href="" target="_blank" class="text-gray-800 fs-6 text-hover-primary">
                                        {{ $assignedDataContent->getClientFullName() }}
                                    </a>
                                </div>
                                <!--end::Description-->
                                <a href="{{ route('CallOrders.Details', $assignedDataContent->id) }}" class="badge badge-light-success fs-8 fw-bold">{{ __('messages.dashboard.employees.04.02') }}</a>
                            </div>
                            <!--end::Item-->
                        @endforeach
                    @else
                        <div class="row g-5 g-xl-8 mb-2">
                            <div class="col-12">
                                <div class="alert alert-warning d-flex align-items-center p-5">
                                    <i class="ki-duotone ki-shield-tick fs-2hx text-warning me-4"><span class="path1"></span><span class="path2"></span></i>
                                    <div class="d-flex flex-column">
                                        <h4 class="mb-1">@ {{ __('messages.dashboard.employees.04.04') }}</h4>
                                        <span>- {{ __('messages.dashboard.employees.04.03') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    <!--end::Chart-->
                </div>
            </div>
        </div>
        <div class="col-xxl-6">
            <div class="card h-xl-100">
                <div class="card-header align-items-center border-0">
                    <!--begin::Title-->
                    <h4 class="card-title d-flex align-items-start flex-column">
                        <span class="card-label fw-bold text-primary">{{ __('messages.dashboard.employees.05') }}</span>
                        <span class="text-gray-400 mt-1 fw-bold fs-7">{{ __('messages.dashboard.employees.05.01') }}</span>
                    </h4>
                    <!--end::Title-->
                </div>

                <div class="card-body pt-2">
                    <!--begin::Chart-->

                    <!--end::Chart-->
                </div>
            </div>
        </div>
    </div>
@endsection

@section('PageVendorJS')

@endsection

@section('PageCustomJS')
    <script type="text/javascript">
        @if(Auth::user()->linkedEmployee->extension_no != "")
            $( document ).ready(function() {
                getExtensionStatus();
            });

            setInterval(getExtensionStatus, 1000);

            function getExtensionStatus() {
                $.ajax({
                    url: "ajax/getextensionstatus",
                    type: 'POST',
                    async: false,
                    data: {
                        "extension": '{{ Auth::user()->linkedEmployee->extension_no }}',
                        "_token": $("meta[name='csrf-token']").attr("content"),
                    },
                    success: function (data){
                        $("#extensionsData").empty();
                        const extensionCard = '<div class="card card-flush text-center bgi-no-repeat bgi-size-cover bgi-position-y-top bgi-position-x-center" style="background-color:'+data.extensionStatus.split('|')[1]+';" data-bs-theme="light"><div class="p-8 mb-1"><div class="d-flex flex-column"><i class="ki-solid ki-like text-white fs-2hx mb-2"></i><span class="fs-4 fw-bold text-white">{{ Auth::user()->linkedEmployee->extension_no }} ({{ Auth::user()->getUserFullName() }})</span><span class="text-white pt-1 fw-semibold fs-6">'+ data.extensionStatus.split('|')[2] +'</span></div></div></div>';
                        $("#extensionsData").append(extensionCard);
                    }
                });
            }
        @endif

    </script>
@endsection

@section('PageModals')

@endsection
