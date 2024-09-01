@extends('layouts.application.layout_application')
@section('PageTitle', __('messages.dashboard.clients.01'))

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
            <div class="card card-flush h-lg-100">
                <!--begin::Header-->
                <div class="card-header pt-5">
                    <!--begin::Title-->
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bold text-primary">{{ __('messages.dashboard.clients.02') }}</span>
                        <span class="text-gray-500 mt-1 fw-semibold fs-6">{{ Settings::get('app_name') }}</span>
                    </h3>
                    <!--end::Title-->
                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body pt-5">
                    <div class="table-responsive">
                        <!--begin::Table-->
                        <table class="table table-row-dashed align-middle gs-0 gy-3 my-0">

                            <!--begin::Table body-->
                            <tbody>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="symbol symbol-50px me-3">
                                            <img src="{{ asset('assets/media/svg/misc/call.svg') }}" class="" alt="" />
                                        </div>
                                        <div class="d-flex justify-content-start flex-column">
                                            <a href="#" class="text-gray-800 fw-bold text-hover-primary mb-1 fs-6">{{ __('messages.dashboard.clients.02.01') }}</a>
                                            <span class="text-gray-500 fw-semibold d-block fs-7">{{ __('messages.dashboard.clients.02.01.01') }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-end">
                                    <span class="badge py-3 px-4 fs-7 badge-light-success">{{ __('messages.dashboard.clients.04') }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="symbol symbol-50px me-3">
                                            <img src="{{ asset('assets/media/svg/misc/sms_module.svg') }}" class="" alt="" />
                                        </div>
                                        <div class="d-flex justify-content-start flex-column">
                                            <a href="#" class="text-gray-800 fw-bold text-hover-primary mb-1 fs-6">{{ __('messages.dashboard.clients.02.02') }}</a>
                                            <span class="text-gray-500 fw-semibold d-block fs-7">{{ Auth::user()->linkedClient->linkedClientModules->sms_module == true ? __('messages.dashboard.clients.02.01.01') : __('messages.dashboard.clients.03.02.01') }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-end">
                                    <span class="badge py-3 px-4 fs-7 {{ Auth::user()->linkedClient->linkedClientModules->sms_module == true ? 'badge-light-warning' : 'badge-light-danger' }}">{{ Auth::user()->linkedClient->linkedClientModules->sms_module == true ? __('messages.dashboard.clients.07', ['credits' => Number::format(Auth::user()->linkedClient->linkedClientModules->sms_credits)]) : __('messages.dashboard.clients.06') }}</span>
                                    @if(Auth::user()->linkedClient->linkedClientModules->sms_module == false)
                                        <a class="badge py-3 px-4 fs-7 badge-light-warning" onclick="smsGateway()" href="#">?</a>
                                    @endif
                                </td>
                            </tr>
                            </tbody>
                            <!--end::Table body-->
                        </table>
                    </div>
                </div>
                <!--end::Body-->
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
    </div>

    @if(@$paymentOrder->status == 1)
    <div class="row g-5 g-xl-8 mb-2">
        <div class="col-12">
            <div class="alert alert-success d-flex align-items-center p-5">
                <i class="ki-duotone ki-shield-tick fs-2hx text-success me-4"><span class="path1"></span><span class="path2"></span></i>
                <div class="d-flex flex-column">
                    <h4 class="mb-1">@ {{ __('messages.payment_orders.alert.01') }}</h4>
                    <span>- {{ __('messages.payment_orders.alert.03') }}</span>
                </div>
            </div>
        </div>
    </div>
    @elseif(@$paymentOrder->status == 2)
    <div class="row g-5 g-xl-8 mb-2">
        <div class="col-12">
            <div class="alert alert-danger d-flex align-items-center p-5">
                <i class="ki-duotone ki-shield-tick fs-2hx text-danger me-4"><span class="path1"></span><span class="path2"></span></i>
                <div class="d-flex flex-column">
                    <h4 class="mb-1">@ {{ __('messages.payment_orders.alert.01') }}</h4>
                    <span>- {{ __('messages.payment_orders.alert.02', [ 'daystosuspend' => intval((strtotime($paymentOrder->payment_date)-strtotime(\Carbon\Carbon::now())) / (60 * 60 * 24)) ]) }}</span>
                    <span>- {{ __('messages.payment_orders.alert.04') }}</span>
                </div>
            </div>
        </div>
    </div>
   @endif

    <div class="row g-5 g-xl-10 mb-xl-10" id="extensionsData">

    </div>
@endsection

@section('PageVendorJS')

@endsection

@section('PageCustomJS')
    <script type="text/javascript">
        function smsGateway() {
            Swal.fire({
                title: '{{ __('messages.sweetalert.21') }}',
                text: '{{ __('messages.sweetalert.22') }}',
                icon: 'error',
                showCancelButton: false,
                allowOutsideClick: false,
                confirmButtonText: '{{ __('messages.sweetalert.05') }}!',
                customClass: {
                    confirmButton: 'btn btn-success',
                    title: 'text-white'
                },
                buttonsStyling: false
            })
        }
    </script>

    <script type="text/javascript">
        $( document ).ready(function() {
            getExtensionsAndStatus();
        });

        setInterval(getExtensionsAndStatus, 1000);

        function getExtensionsAndStatus() {
            $.ajax({
                url: "ajax/getassignedextensions",
                type: 'POST',
                async: false,
                data: {
                    "_token": $("meta[name='csrf-token']").attr("content"),
                },
                success: function (data){
                    console.log(data.status);
                    $("#extensionsData").empty();
                    $.each( data.extensions, function( key, value ) {
                        const listItem = '<div class="col-lg-2"><div class="card card-flush border-1 text-center" style="background-color: '+ value.status.split('|')[1] +';"><div class="p-3"><div class="d-flex flex-column"><i class="ki-solid ki-'+ value.status.split('|')[3] +' text-white fs-2hx mb-2"></i><span class="fs-4 fw-bold text-white">'+ value.extension +' ('+value.assignedUserFullName+')</span><span class="text-white opacity-50 pt-1 fw-semibold fs-6">'+ value.status.split('|')[2] +'</span></div></div></div></div>';
                        $("#extensionsData").append(listItem);
                    });
                }
            });
            console.log('Updated!');
        }
    </script>
@endsection

@section('PageModals')

@endsection
