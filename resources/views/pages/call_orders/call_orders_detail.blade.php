@extends('layouts.application.layout_application')
@section('PageTitle', __('messages.call_orders.index.01'))

@section('PageVendorCSS')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.min.css" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.0/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('PageCustomCSS')
    <style>
        thead th { white-space: nowrap; }
        #kartik-file-errors {
            margin: 0px 0px 20px 0px !important;
        }

        #msg_list { margin: .5em 0em .3em 0em; background: #ffffff; overflow-y: auto; overflow-x: hidden; width: 274px; height: 160px; text-align: left; border: 1px solid #ccc; border-radius: .1em;}
        #msg_list B { margin-left: .2em; font-size: .8em; }
        #msg_list P { margin-left: .6em; margin-top: 0; margin-bottom: .2em; font-size: .8em; }
        #msg_list .date { margin-top: 0; margin-bottom: .2em; margin-right: .2em; font-weight: bold; font-size: .6em; text-align: right;}
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
    @php
        if($callCenterClient->linkedUser->linkedEmployee == null) {
            $extension = "0000";
        }
    @endphp
    <div class="row g-5 g-xl-8 mb-6">
        <!--begin::Col-->
        <div class="col-xl-6">
            <!--begin::Lists Widget 19-->
            <div class="card card-flush h-xl-100">
                <!--begin::Heading-->
                <div class="card-header rounded bgi-no-repeat bgi-size-cover bgi-position-y-top bgi-position-x-center align-items-start h-100px" style="background-image:url({{ asset('assets/media/svg/shapes/abstract-2-dark.svg') }})" data-bs-theme="light">
                    <!--begin::Title-->
                    <h3 class="card-title align-items-start flex-column text-white pt-5">
                        <span class="card-label fw-bold text-primary mb-2">{{ $callCenterClient->getClientFullName() }}</span>
                        <div class="fs-6">
                            <span class="text-warning">@ {{ __('messages.call_orders.detail.05') }}:</span>
                            <span class="position-relative d-inline-block">
							    <span class="fw-bold d-block mb-1">{{ $callCenterClient->createdUser->getUserFullName() }}</span>
                            </span>
                        </div>
                        <div class="fs-6">
                            <span class="text-success">@ {{ __('messages.call_orders.detail.06') }}:</span>
                            <span class="position-relative d-inline-block">
							    <span class="fw-bold d-block mb-1">{{ $callCenterClient->created_at }}</span>
                            </span>
                        </div>
                    </h3>

                    <div class="card-toolbar mt-10">
                        <!--begin::Pagination-->
                        <div class="d-flex align-items-center">
                            @if($previousRecord != "")
                                <a href="/callorderdetails/{{ $previousRecord }}" class="btn btn-sm btn-icon btn-primary me-3" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('messages.call_orders.detail.07') }}">
                                    <i class="ki-duotone ki-left fs-2 m-0"></i>
                                </a>
                            @endif
                            @if($nextRecord != "")
                                <a href="/callorderdetails/{{ $nextRecord }}" class="btn btn-sm btn-icon btn-primary me-2" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('messages.call_orders.detail.08') }}">
                                    <i class="ki-duotone ki-right fs-2 m-0"></i>
                                </a>
                            @endif
                        </div>
                        <!--end::Pagination-->
                    </div>
                </div>
                <!--end::Heading-->
                <!--begin::Body-->
                <div class="card-body">
                    <!--begin::Stats-->
                    <div class="position-relative">
                        <!--begin::Row-->
                        <div class="row g-3 g-lg-6">
                            <!--begin::Col-->
                            <div class="col-6">
                                <!--begin::Items-->
                                <div class="bg-gray-100 bg-opacity-70 rounded-2 px-6 py-5">
                                    <!--begin::Stats-->
                                    <div class="m-0">
                                        <!--begin::Number-->
                                        <span class="text-gray-700 fw-bolder d-block fs-2qx lh-1 ls-n1 mb-1">
                                            @if(\Illuminate\Support\Facades\Auth::user()->user_type != 3)
                                                @if($callCenterClient->linkedUser->linkedEmployee->show_numbers == true)
                                                    {{ $callCenterClient->contact_no }}
                                                @else
                                                    *** *** ***
                                                @endif
                                            @else
                                                {{ $callCenterClient->contact_no }}
                                            @endif
                                        </span>
                                        <!--end::Number-->
                                        <!--begin::Desc-->
                                        <span class="text-success fw-semibold fs-6">{{ __('messages.call_orders.detail.02') }}</span>
                                        <!--end::Desc-->
                                    </div>
                                    <!--end::Stats-->
                                </div>
                                <!--end::Items-->
                            </div>
                            <!--end::Col-->
                            <!--begin::Col-->
                            <div class="col-6">
                                <!--begin::Items-->
                                <div class="bg-gray-100 bg-opacity-70 rounded-2 px-6 py-5">
                                    <!--begin::Stats-->
                                    <div class="m-0">
                                        <!--begin::Number-->
                                        <span class="text-gray-700 fw-bolder d-block fs-2qx lh-1 ls-n1 mb-1">{{ $callCenterClient->id }}</span>
                                        <!--end::Number-->
                                        <!--begin::Desc-->
                                        <span class="text-danger fw-semibold fs-6">{{ __('messages.call_orders.detail.09') }}</span>
                                        <!--end::Desc-->
                                    </div>
                                    <!--end::Stats-->
                                </div>
                                <!--end::Items-->
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Row-->

                        <!--begin::Row-->
                        <div class="row g-3 mt-2">
                            <ul class="nav mb-5 fs-6">
                                <li class="nav-item d-flex flex-row flex-column-fluid p-2">
                                    <!--begin::Nav link-->
                                    <a class="nav-link border btn btn-flex flex-column flex-stack pt-9 pb-7 page-bg active btn-active-light-primary" data-bs-toggle="pill" href="#kt_tab_pane_1" style="width: 100%;height: 180px">
                                        <!--begin::Icon-->
                                        <div class="nav-icon mb-3">
                                            <!--begin::Food icon-->
                                            <img src="{{ asset('assets/media/svg/misc/comment.svg') }}" class="w-75px" alt="" />
                                            <!--end::Food icon-->
                                        </div>
                                        <!--end::Icon-->
                                        <!--begin::Info-->
                                        <div class="">
                                            <span class="text-gray-800 fw-bold fs-2 d-block">{{ __('messages.call_orders.detail.14') }}</span>
                                            <span class="text-gray-500 fw-semibold fs-7">{{ __('messages.call_orders.detail.17') }}</span>
                                        </div>
                                        <!--end::Info-->
                                    </a>
                                    <!--end::Nav link-->
                                </li>
                                <li class="nav-item d-flex flex-row flex-column-fluid p-2">
                                    <!--begin::Nav link-->
                                    <a class="nav-link border btn btn-flex flex-column flex-stack pt-9 pb-7 page-bg @if(@$callCenterClient->linkedUser->linkedEmployee->extension_no != null && @$callCenterClient->linkedUser->linkedEmployee->extension_no != "0") btn-active-light-primary @endif" data-bs-toggle="pill" href="#kt_tab_pane_2" style="width: 100%;height: 180px" @if(@$callCenterClient->linkedUser->linkedEmployee->extension_no == null && @$callCenterClient->linkedUser->linkedEmployee->extension_no != "0") disabled onclick="extensionGateway()"@endif>
                                        <!--begin::Icon-->
                                        <div class="nav-icon mb-3">
                                            <!--begin::Food icon-->
                                            <img src="{{ asset('assets/media/svg/misc/call.svg') }}" class="w-75px" alt="" />
                                            <!--end::Food icon-->
                                        </div>
                                        <!--end::Icon-->
                                        <!--begin::Info-->
                                        <div class="">
                                            <span class="text-gray-800 fw-bold fs-2 d-block">{{ __('messages.call_orders.detail.12') }}</span>
                                            <span class="text-warning fw-semibold fs-7">{{ @$callCenterClient->linkedUser->linkedEmployee->extension_no != null && @$callCenterClient->linkedUser->linkedEmployee->extension_no != "0" ? __('messages.call_orders.detail.17') : __('messages.call_orders.detail.18') }} </span>
                                            {{ @$callCenterClient->linkedUser->linkedEmployee->extension_no }}
                                        </div>
                                        <!--end::Info-->
                                    </a>
                                    <!--end::Nav link-->
                                </li>
                                <li class="nav-item d-flex flex-row flex-column-fluid p-2">
                                    <!--begin::Nav link-->
                                    <a class="nav-link border btn btn-flex flex-column flex-stack pt-9 pb-7 page-bg @if($callCenterClient->linkedClient->linkedClientModules->sms_module == true) btn-active-light-primary @endif" data-bs-toggle="pill" href="#kt_tab_pane_3" style="width: 100%;height: 180px" @if($callCenterClient->linkedClient->linkedClientModules->sms_module == false) disabled onclick="smsGateway()"@endif>
                                        <!--begin::Icon-->
                                        <div class="nav-icon mb-3">
                                            <!--begin::Food icon-->
                                            <img src="{{ asset('assets/media/svg/misc/send_sms.svg') }}" class="w-75px" alt="" />
                                            <!--end::Food icon-->
                                        </div>
                                        <!--end::Icon-->
                                        <!--begin::Info-->
                                        <div class="">
                                            <span class="text-gray-800 fw-bold fs-2 d-block">{{ __('messages.call_orders.detail.13') }}</span>
                                            <span class="text-warning fw-semibold fs-7" id="input-remaining_sms_credits">{{ $callCenterClient->linkedClient->linkedClientModules->sms_module == true ? __('messages.sweetalert.34').': '.$clientModule->sms_credits : __('messages.call_orders.detail.18') }} </span>
                                        </div>
                                        <!--end::Info-->
                                    </a>
                                    <!--end::Nav link-->
                                </li>
                            </ul>
                        </div>
                        <!--end::Row-->
                    </div>
                    <!--end::Stats-->
                </div>
                <!--end::Body-->
            </div>
            <!--end::Lists Widget 19-->
        </div>
        <!--end::Col-->

        <!--begin::Col-->
        <div class="col-xl-6">
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="kt_tab_pane_1" role="tabpanel">
                    @if (session('result'))
                        @include('components.alert', $data = ['alert_type' => session('result'), 'alert_title' => session('title'), 'alert_content' => session('content')])
                    @endif

                    <div class="card shadow-sm">
                        <div class="card-header ribbon ribbon-start ribbon-clip">
                            <div class="ribbon-label bg-success fs-6" style="padding: 10px 15px;"><span class="d-flex text-white fw-bolder fs-6">{{ __('messages.call_orders.detail.15') }}</span></div>
                            <h3 class="card-title"></h3>
                            <div class="card-toolbar"></div>
                        </div>

                        <div class="card-body">
                            <form autocomplete="off">
                                <div class="row">
                                    <div class="col-12">
                                        <label for="input-status" class="required form-label">{{ __('messages.call_orders.detail.form.01') }}</label>
                                        <select class="form-select @error('input-status') is-invalid error-input @enderror" name="input-status" id="input-status" data-control="select2" data-placeholder="{{ __('messages.forms.06') }}" data-hide-search="true">
                                            <option></option>
                                            <option value="0" {{ old('input-status', $callCenterClient->status) == '0' ? 'selected' : '' }} @if($callCenterClient->status == 0) selected @endif>{{ __('messages.call_orders.detail.form.01.00') }}</option>
                                            <option value="1" {{ old('input-status', $callCenterClient->status) == '1' ? 'selected' : '' }}>{{ __('messages.call_orders.detail.form.01.01') }}</option>
                                            <option value="2" {{ old('input-status', $callCenterClient->status) == '2' ? 'selected' : '' }}>{{ __('messages.call_orders.detail.form.01.02') }}</option>
                                            <option value="3" {{ old('input-status', $callCenterClient->status) == '3' ? 'selected' : '' }}>{{ __('messages.call_orders.detail.form.01.03') }}</option>
                                            <option value="4" {{ old('input-status', $callCenterClient->status) == '4' ? 'selected' : '' }}>{{ __('messages.call_orders.detail.form.01.04') }}</option>
                                            <option value="5" {{ old('input-status', $callCenterClient->status) == '5' ? 'selected' : '' }}>{{ __('messages.call_orders.detail.form.01.05') }}</option>
                                            <option value="6" {{ old('input-status', $callCenterClient->status) == '6' ? 'selected' : '' }}>{{ __('messages.call_orders.detail.form.01.06') }}</option>
                                            <option value="7" {{ old('input-status', $callCenterClient->status) == '7' ? 'selected' : '' }}>{{ __('messages.call_orders.detail.form.01.07') }}</option>
                                            <option value="8" {{ old('input-status', $callCenterClient->status) == '8' ? 'selected' : '' }}>{{ __('messages.call_orders.detail.form.01.08') }}</option>
                                        </select>
                                        @if ($errors->has('input-status'))
                                            <div class="invalid-feedback">
                                                @ {{ $errors->first('input-status') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="row mt-6">
                                    <div class="col-12">
                                        <label for="input-description" class="form-label">{{ __('messages.call_orders.detail.form.02') }}</label>
                                        <textarea name="input-description" id="input-description" class="form-control @error('input-description') is-invalid error-input @enderror" rows="4" placeholder="{{ __('messages.call_orders.detail.form.02') }} {{ __('messages.forms.01') }}" maxlength="750">{{ old('input-description') }}</textarea>
                                        @if ($errors->has('input-description'))
                                            <div class="invalid-feedback">
                                                @ {{ $errors->first('input-description') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </form>
                            <div class="separator border-2 my-10"></div>
                            <button type="button" class="btn btn-success btn-sm" id="btn-tab-01-submit">
                                <span class="indicator-label">{{ __('messages.forms.02') }}</span>
                                <span class="indicator-progress">{{ __('messages.forms.03') }} <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            </button>
                        </div>
                    </div>
                </div>

                @if($callCenterClient->linkedClient->linkedClientModules->sms_module == true)
                <div class="tab-pane fade" id="kt_tab_pane_2" role="tabpanel">
                    <div class="card shadow-sm">
                        <div class="card-header ribbon ribbon-start ribbon-clip">
                            <div class="ribbon-label bg-success fs-6" style="padding: 10px 15px;"><span class="d-flex text-white fw-bolder fs-6">{{ __('messages.call_orders.detail.19') }}</span></div>
                            <h3 class="card-title"></h3>
                            <div class="card-toolbar"></div>
                        </div>

                        <div class="card-body">
                            <div class="row text-center">
                                <div class="col-12">
                                    <div class="symbol symbol-50px">
                                        <div class="symbol-label fs-1 fw-bold bg-light-success text-success">
                                            {{ $callCenterClient->getClientFullName()[0] }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mt-2">
                                    <span class="badge badge-danger badge-lg">{{ $callCenterClient->getClientFullName() }}</span>
                                </div>

                                <span class="text-gray-700 fw-bolder d-block fs-2qx lh-1 ls-n1 mb-1 mt-4">
                                        @if(\Illuminate\Support\Facades\Auth::user()->user_type != 3)
                                        @if($callCenterClient->linkedUser->linkedEmployee->show_numbers == true)
                                            {{ $callCenterClient->contact_no }}
                                        @else
                                            *** *** ***
                                        @endif
                                    @else
                                        {{ $callCenterClient->contact_no }}
                                    @endif
                                </span>

                                <span class="text-gray-700 fw-bolder d-block fs-1 lh-1 ls-n1 mb-1 mt-2" id="callTimer">
                                    00:00:00
                                </span>

                                <div class="col-12">
                                    <div id="siri-container"></div>
                                </div>
                                <iframe allow="microphone; camera; autoplay" style="display:none" height="0" width="0" id="loader"></iframe>
                                <span class="fw-bolder text-warning d-block fs-6" id="events"></span>
                            </div>

                            <div class="separator border-2 mb-9"></div>

                            <div class="row text-center">
                                <div class="col-12">
                                    <a href="#" class="btn btn-icon btn-dark"><i class="bi bi-mic-mute-fill fs-2x"></i></a>

                                    <button type="button" class="btn btn-bg-success" id="btn-makecall" style="width:85%; background-color: #0fa162;" onclick="startOriginator(this)">
                                        <span class="indicator-label">
                                            <i class="bi bi-telephone-fill fs-2x text-white"></i>
                                        </span>
                                        <span class="indicator-progress">
                                            <i class="bi bi-telephone-x-fill fs-2x text-white"></i>
                                        </span>
                                    </button>

                                    <a href="#" class="btn btn-icon btn-dark"><i class="bi bi-mic-mute-fill fs-2x"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                @if($callCenterClient->linkedClient->linkedClientModules->sms_module == true)
                <div class="tab-pane fade" id="kt_tab_pane_3" role="tabpanel">
                    @if (session('result'))
                        @include('components.alert', $data = ['alert_type' => session('result'), 'alert_title' => session('title'), 'alert_content' => session('content')])
                    @endif

                    <div class="card shadow-sm">
                        <div class="card-header ribbon ribbon-start ribbon-clip">
                            <div class="ribbon-label bg-success fs-6" style="padding: 10px 15px;"><span class="d-flex text-white fw-bolder fs-6">{{ __('messages.call_orders.detail.16') }}</span></div>
                            <h3 class="card-title"></h3>
                            <div class="card-toolbar">
                                <a class="btn btn-light-warning btn-sm" id="sms-count">
                                    {{ $callCenterClient->linkedClient->linkedClientModules->sms_credits }}
                                </a>
                            </div>
                        </div>

                        <div class="card-body">
                            <form autocomplete="off">
                                <div class="row">
                                    <div class="col-12">
                                        <label for="input-gsm_number" class="required form-label">{{ __('messages.call_orders.detail.form.03') }}</label>
                                        @if(\Illuminate\Support\Facades\Auth::user()->user_type != 3)
                                            <input type="text" name="input-gsm_number" id="input-gsm_number" class="form-control" maxlength="50" value="@if($callCenterClient->linkedUser->linkedEmployee->show_numbers == true) {{ $callCenterClient->contact_no }} @else *** *** *** ** ** @endif" disabled/>
                                        @else
                                            <input type="text" name="input-gsm_number" id="input-gsm_number" class="form-control" maxlength="50" value="{{ $callCenterClient->contact_no }}" disabled/>
                                        @endif
                                    </div>
                                </div>
                                <div class="row mt-6">
                                    <div class="col-12">
                                        <label for="input-sms_content" class="form-label">{{ __('messages.call_orders.detail.form.04') }}</label>
                                        <textarea name="input-sms_content" id="input-sms_content" class="form-control @error('input-sms_content') is-invalid error-input @enderror" rows="4" placeholder="{{ __('messages.call_orders.detail.form.04') }} {{ __('messages.forms.01') }}" maxlength="750">{{ old('input-sms_content') }}</textarea>
                                        @if ($errors->has('input-sms_content'))
                                            <div class="invalid-feedback">
                                                @ {{ $errors->first('input-sms_content') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <input type="hidden" id="input-sms_credit_count" name="input-sms_credit_count" value="">
                            </form>
                            <div class="separator border-2 my-10"></div>
                            <button type="button" class="btn btn-success btn-sm" id="btn-tab-03-submit">
                                <span class="indicator-label">{{ __('messages.forms.02') }}</span>
                                <span class="indicator-progress">{{ __('messages.forms.03') }} <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            </button>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
        <!--end::Col-->
    </div>

    <div class="row g-5 g-xl-8 mb-6">
        <div class="col-xl-12">
            @if (session('result'))
                @include('components.alert', $data = ['alert_type' => session('result'), 'alert_title' => session('title'), 'alert_content' => session('content')])
            @endif
            <div class="card">
                <div class="card-header ribbon ribbon-start ribbon-clip">
                    <div class="ribbon-label bg-primary-active fs-6" style="padding: 10px 15px;"><span class="d-flex text-white fw-bolder fs-6">{{ __('messages.call_orders.detail.11') }} {{ __('messages.datatables.02') }}</span></div>
                    <h3 class="card-title"></h3>
                    <div class="card-toolbar">
                        <a onclick="dtReset()" class="btn btn-icon btn-light-warning btn-sm ms-2">
                            <i class="fas fa-redo-alt fs-5"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body">

                    <div class="input-group mb-5">
                        <span class="input-group-text">{{ __('messages.datatables.01') }}</span>
                        <input type="text" id="table-search" class="form-control" placeholder="..."/>
                    </div>

                    <table id="datatable" class="table table-hover table-rounded table-row-bordered table-row-gray-200 gy-1 gs-10" style="min-height: 100%; width: 100% !important;">
                        <thead>
                        <tr class="fw-bolder fs-7 text-uppercase gy-5">
                            <th>{{ __('messages.datatables.03') }}</th>
                            <th>{{ __('messages.call_orders.detail.datatables.01') }}</th>
                            <th>{{ __('messages.call_orders.detail.datatables.02') }}</th>
                            <th>{{ __('messages.call_orders.detail.datatables.03') }}</th>
                            <th>{{ __('messages.call_orders.detail.datatables.04') }}</th>
                            <th class="text-center">{{ __('messages.datatables.04') }}</th>
                        </tr>
                        </thead>
                        <tbody class="text-gray-700 fw-bold" style="vertical-align: middle;"></tbody>
                    </table>
                    <div class="d-none d-sm-block alert alert-dismissible bg-light-warning d-flex flex-column flex-sm-row p-2" style="padding-left: 15px !important;">
                        <div class="d-flex flex-column pe-0 pe-sm-10">
                            <span id="dt_info"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('PageVendorJS')
    <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <script src="{{ asset('assets/plugins/custom/easytimer/easytimer.js') }}"></script>
    <script src="{{ asset('assets/plugins/custom/webphone/webphone_api.js?jscodeversion=1') }}"></script>
    <script src="https://unpkg.com/siriwave/dist/siriwave.umd.min.js"></script>
@endsection

@section('PageCustomJS')
    <script>
        function generateUniqueCallId() {
            return Math.random().toString(36).substr(2, 9);
        }

        var serverAddress = "{{ $callCenterClient->linkedClient->linkedClientModules->pbx_server_ip_address }}";
        var userExtension = "{{ $callCenterClient->linkedUser->linkedEmployee->extension_no }}";
        var userPassword = "24082408Aa";
        var destinationNumber = "0901";
        webphone_api.getlastcalldetails();
        webphone_api.onAppStateChange(function (state)
        {
            if (state === 'loaded')
            {
                webphone_api.setparameter('serveraddress', serverAddress, false);
                webphone_api.setparameter('username', userExtension, false);
                webphone_api.setparameter('password', userPassword, false);
                webphone_api.setparameter('destination', destinationNumber, false);
                document.getElementById('events').innerHTML = 'EVENT, Initializing...'; // ????????????????????????????????????????????????????????????????????????
                webphone_api.start();
            }
        });

        function Call()
        {
            var callId = generateUniqueCallId();
            webphone_api.setsipheader('X-CALL-ID: '+callId);
            webphone_api.call(destinationNumber);
            $.ajax({
                url: '/ajax/startcall',
                type: 'POST',
                data: {
                    "call_center_client_id": '{{ $callCenterClient->id }}',
                    "source": userExtension,
                    "destination": destinationNumber,
                    "call_id": callId,
                    "status": "Success",
                    "_token": $("meta[name='csrf-token']").attr("content"),
                },
                success: function (data){
                    console.log(data);
                    dtReset();
                }, error: function (data) {
                    console.log(data);
                },
            });
        }

        function Hangup()
        {
            webphone_api.hangup();
        }

        webphone_api.onEvent(function (type, evt)
        {
            if (type === 'event' || type === 'display')
            {
                DisplayEvent(evt);
            }
        });

        function DisplayEvent(evt)
        {
            document.getElementById('events').innerHTML = evt;
        }

        webphone_api.onCallStateChange(function (event)
        {
            if (event === 'disconnected')
            {
                endOriginator(document.getElementById('btn-makecall'));
            }
        });

        webphone_api.onCdr(function (caller, called, connecttime, duration, direction, peerdisplayname, reason, line, callid)
        {
            console.log('CDR: caller: ' + caller + ', called: ' + called + ', connecttime: ' + connecttime+ ', duration: ' + duration + ', direction: ' + direction + ', peerdisplayname: ' + peerdisplayname + ', reason: ' + reason + ', line: ' + line + ', callid: ' + callid);

            /** Example of sending CDR details to your server with an HTTP POST reques */
            /*
                        var method = 'POST';
                        var url = 'http://YOURDOMAIN.COM/sendcdr/';

                        var xhr = new XMLHttpRequest();
                        if ("withCredentials" in xhr) // XHR for Chrome/Firefox/Opera/Safari.
                        {
                            xhr.open(method, url, true);
                        }
                        else if (typeof XDomainRequest != "undefined") // XDomainRequest for IE.
                        {
                            xhr = new XDomainRequest();
                            xhr.open(method, url);
                        }

                        xhr.onload = function()
                        {
                            var asnwer = xhr.responseText;
                            console.log('EVENT, SendCdr request answer: ' + asnwer);
                        };

                        xhr.onerror = function(error)
                        {
                            console.log('ERROR, SendCdr failed: ' + error);
                        };

                        xhr.timeout = 20000; // set timeout to 20 sec
                        xhr.ontimeout = function (event)
                        {
                            console.log('ERROR, SendCdr request timed out');
                        };

                        var cdrdata = caller + ',' + called + ',' + connecttime + ',' + direction + ',' + peerdisplayname + ',' + reason + ',' + line;
                        xhr.send(cdrdata);
            */
        });



    </script>

    <script>
        var siriWave = new SiriWave({
            container: document.getElementById("siri-container"),
            width: 400,
            height: 75,
            style: 'ios',
            autostart: true,
            speed: 0.05,
            amplitude: 0.1
        });
    </script>

    <script>
        var timerInstance = new easytimer.Timer();
        var isCallActive = false;

        function startOriginator(callBtn) {
            isCallActive = true;
            callBtn.style.backgroundColor = "#a10f2b";
            callBtn.setAttribute("data-kt-indicator", "on");
            siriWave.setSpeed(0.2);
            siriWave.setAmplitude(1);
            timerInstance.start();
            timerInstance.addEventListener("secondsUpdated", function (e) {
                $("#callTimer").html(timerInstance.getTimeValues().toString());
            });
            document.getElementById('btn-makecall').setAttribute("onClick", "endOriginator(this)");
            Call();
        }

        function endOriginator(callBtn) {
            isCallActive = false;
            callBtn.style.backgroundColor = "#0fa162";
            callBtn.setAttribute("data-kt-indicator", "off");
            siriWave.setSpeed(0.05);
            siriWave.setAmplitude(0.1);
            timerInstance.stop();
            timerInstance.off();
            $("#callTimer").html('00:00:00');
            Hangup();
            document.getElementById('btn-makecall').setAttribute("onClick", "startOriginator(this)");
        }
    </script>

    <script type="text/javascript">
        var table, dt;

        var initDatatable = function () {
            dt = $("#datatable").DataTable({
                searchDelay: 10000,
                processing: true,
                serverSide: false,
                order: [[2, 'desc']],
                autoWidth: false,
                responsive: false,
                pageLength: 10,
                aLengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "{{ __('messages.datatables.05') }}"]],
                fnCreatedRow: function( nRow, aData, iDataIndex ) {
                    $(nRow).children("td").css("white-space", "nowrap");
                },
                stateSave: false,
                pagingType: "simple_numbers",
                info: false,
                ajax: {
                    url : "{{ route('CallOrderDescriptions.Index') }}",
                    data:{ clientID: "{{ $callCenterClient->id }}" }
                },
                language: {
                    @if(App::getLocale() == 'tr')
                    url: '{{ asset('assets/plugins/custom/datatables/lang/tr_TR.json') }}'
                    @elseif(App::getLocale() == 'en')
                    url: '{{ asset('assets/plugins/custom/datatables/lang/en_GB.json') }}'
                    @endif
                },
                columns: [
                    { data: 'id' },
                    { data: 'communicationType' },
                    { data: 'createdUser' },
                    { data: 'creationDate' },
                    { data: 'communicationStatus' },
                    { data: null },
                ],
                columnDefs: [
                    @if(App::getLocale() == 'tr')
                    { type: 'turkish', targets: [0,1] },
                    @endif
                    { targets : 0,
                        render : function (data, type, row) {
                            return '<span class="badge badge-square badge-light-warning"><strong>'+ data +'</strong></span>';
                        }
                    },
                    { targets: -1,
                        data: null,
                        orderable: false,
                        className: 'text-center',
                        render: function (data, type, row) {
                            if(row.communication_type != 0) {
                                return `<a class="btn btn-icon btn-light-primary" onclick="viewDetailModal(this)" data-communication_type="`+ row.communication_type +`" data-unique_id="`+ row.unique_id +`" style="height: calc(2.05em);"><i class="fas fa-eye fs-5" style="margin-top: 1px;"></i></a>`;
                            } else {
                                return `
                                <a class="btn btn-icon btn-light-success" onclick="listenRecording(this)" data-id="`+ row.unique_id +`" style="height: calc(2.05em);"><i class="fas fa-play fs-5" style="margin-top: 2px;"></i></a>
                                <a class="btn btn-icon btn-light-primary" onclick="viewDetailModal(this)" data-communication_type="`+ row.communication_type +`" data-unique_id="`+ row.unique_id +`" style="height: calc(2.05em);"><i class="fas fa-eye fs-5" style="margin-top: 1px;"></i></a>
                                `;
                            }
                        },
                    },
                    { className: "dt-settings", "targets": [ -1 ] },
                ],
                drawCallback : function() {
                    processInfo(this.api().page.info());
                },
            });

            table = dt.$;

            dt.on('draw', function () {
                KTMenu.createInstances();
            });

            $('#table-search').keyup(function(){
                dt.search($(this).val()).draw();
            });
        };

        function processInfo(info) {
            @if(App::getLocale() == 'tr')
            $("#dt_info").html(
                'Toplam ' + info.recordsTotal + ' Kayıttan ' + (info.start+1) + ' - ' + info.end + ' Arası Gösteriliyor.'
            );
            @else
            $("#dt_info").html(
                'Showing ' + (info.start+1) + ' - ' + info.end + ' of ' + info.recordsTotal + ' Total Records.'
            );
            @endif
        };

        KTUtil.onDOMContentLoaded(function () {
            initDatatable();
        });

        function dtReset() {
            $("#datatable").DataTable().page.len(10).draw();
            $("#datatable").DataTable().state.clear();
            $("#datatable").DataTable().ajax.reload();
        }
    </script>

    <script type="text/javascript">
        $('#btn-tab-01-submit').on('click',function(e){
            if($('#input-description').val() == "") {
                Swal.fire({
                    title: '{{ __('messages.sweetalert.14') }}',
                    text: '{{ __('messages.sweetalert.15') }}',
                    icon: 'error',
                    showCancelButton: true,
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    cancelButtonText: '{{ __('messages.sweetalert.04') }}',
                    customClass: {
                        cancelButton: 'btn btn-danger ml-1',
                        title: 'text-white'
                    },
                    buttonsStyling: false
                });
            } else {
                Swal.fire({
                    title: '{{ __('messages.sweetalert.12') }}',
                    text: '{{ __('messages.sweetalert.13') }}',
                    icon: 'info',
                    showCancelButton: true,
                    allowOutsideClick: false,
                    confirmButtonText: '{{ __('messages.sweetalert.03') }}!',
                    cancelButtonText: '{{ __('messages.sweetalert.04') }}',
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger ml-1',
                        title: 'text-white'
                    },
                    buttonsStyling: false
                }).then(function (result) {
                    if (result.value) {
                        $.ajax({
                            url: '/callordercomment',
                            type: 'POST',
                            data: {
                                "id": "{{ $callCenterClient->id }}",
                                "status": $('#input-status').val(),
                                "description": $('#input-description').val(),
                                "_token": $("meta[name='csrf-token']").attr("content"),
                            },
                            success: function (data){
                                Swal.fire({
                                    icon: 'success',
                                    title: '{{ __('messages.alerts.01') }}',
                                    text: '{{ __('messages.alerts.08') }}',
                                    confirmButtonText: '{{ __('messages.sweetalert.05') }}',
                                    allowOutsideClick: false,
                                    customClass: {
                                        confirmButton: 'btn btn-success',
                                        title: 'text-white'
                                    }
                                }).then(function (result) {
                                    $('#input-status').val(1);
                                    $('#input-description').val("");
                                    dtReset();
                                })
                            }, error: function (data) {
                                console.log(data);
                            },
                        });
                    }
                });
            }
        });
    </script>

    <script type="text/javascript">
        $('#btn-tab-03-submit').on('click',function(e){
            var currentCredit = '{{ $clientModule->sms_credits }}';
            var smsCreditCount = $('#input-sms_credit_count').val();
            var remainingCredits = parseInt(currentCredit) - parseInt(smsCreditCount);

            if(parseInt(currentCredit) > 0) {
                if($('#input-sms_content').val() == "") {
                    Swal.fire({
                        title: '{{ __('messages.sweetalert.18') }}',
                        text: '{{ __('messages.sweetalert.19') }}',
                        icon: 'error',
                        showCancelButton: true,
                        showConfirmButton: false,
                        allowOutsideClick: false,
                        cancelButtonText: '{{ __('messages.sweetalert.04') }}',
                        customClass: {
                            cancelButton: 'btn btn-danger ml-1',
                            title: 'text-white'
                        },
                        buttonsStyling: false
                    });
                } else {
                    Swal.fire({
                        title: '{{ __('messages.sweetalert.20') }}',
                        html: '<strong class="text-warning">{{ __('messages.sweetalert.32') }}:</strong> '+ smsCreditCount +' {{ __('messages.sweetalert.35') }}<br><strong class="text-primary">{{ __('messages.sweetalert.33') }}: </strong>'+ currentCredit +'<br><strong class="text-success">{{ __('messages.sweetalert.34') }}: </strong>'+ remainingCredits +'<br><br>{{ __('messages.sweetalert.13') }}',
                        icon: 'info',
                        showCancelButton: true,
                        allowOutsideClick: false,
                        confirmButtonText: '{{ __('messages.sweetalert.03') }}!',
                        cancelButtonText: '{{ __('messages.sweetalert.04') }}',
                        customClass: {
                            confirmButton: 'btn btn-success',
                            cancelButton: 'btn btn-danger ml-1',
                            title: 'text-white'
                        },
                        buttonsStyling: false
                    }).then(function (result) {
                        if (result.value) {
                            $.ajax({
                                url: '/callordersms',
                                type: 'POST',
                                data: {
                                    "id": "{{ $callCenterClient->id }}",
                                    "sms_content": $('#input-sms_content').val(),
                                    "_token": $("meta[name='csrf-token']").attr("content"),
                                },
                                success: function (data){
                                    Swal.fire({
                                        icon: 'success',
                                        title: '{{ __('messages.alerts.01') }}',
                                        text: '{{ __('messages.alerts.10') }}',
                                        confirmButtonText: '{{ __('messages.sweetalert.05') }}',
                                        allowOutsideClick: false,
                                        customClass: {
                                            confirmButton: 'btn btn-success',
                                            title: 'text-white'
                                        }
                                    }).then(function (result) {
                                        console.log(data);
                                        $('#input-sms_content').val("");
                                        document.getElementById('input-remaining_sms_credits').innerHTML = '{{ __('messages.sweetalert.34') }}: ' + data.credits;
                                        dtReset();
                                    })
                                }, error: function (data) {
                                    console.log(data);
                                },
                            });
                        }
                    });
                }
            } else {
                Swal.fire({
                    title: '{{ __('messages.sweetalert.36') }}',
                    text: '{{ __('messages.sweetalert.37') }}',
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
        });
    </script>

    <script type="text/javascript">
        function viewDetailModal(btn) {
            var token = $("meta[name='csrf-token']").attr("content");
            var route = "/ajax/callorderdetails";

            $.ajax({
                url: route,
                type: 'POST',
                data: {
                    "uniqueID": btn.getAttribute('data-unique_id'),
                    "communicationType": btn.getAttribute('data-communication_type'),
                    "_token": token,
                },
                success: function (data){
                    $("#indexDataModal #modalData #modalData_01").empty();
                    $("#indexDataModal #modalData #modalData_01").text(data.name);
                    $("#indexDataModal #modalData #modalData_02").empty();
                    $("#indexDataModal #modalData #modalData_02").text(data.phone);
                    $("#indexDataModal #modalData #modalData_03").empty();
                    $("#indexDataModal #modalData #modalData_03").text(data.createdBy);
                    $("#indexDataModal #modalData #modalData_04").empty();
                    $("#indexDataModal #modalData #modalData_04").text(data.creationDate);
                    $("#indexDataModal").modal("show");
                }
            });
        }
    </script>

    <script type="text/javascript">
        function listenRecording(btn) {
            var token = $("meta[name='csrf-token']").attr("content");
            var route = "/ajax/getcallrecording";

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var requestData = {
                "uniqueID": btn.getAttribute('data-id'),
                "_token": token,
            };

            $.ajax({
                url: route,
                type: 'POST',
                contentType: 'application/json; charset=UTF-8',
                dataType: "json",
                data: JSON.stringify(requestData), // Convert data to JSON format
                success: function (data){
                    console.log(data);
                    $('#audioPlayer').attr('src', data.url).show();
                    $("#audioListenModal").modal("show");

                }
            });
        }

        $(document).ready(function() {
            $("#audioListenModal").on('hidden.bs.modal', function () {
                console.log($('#audioPlayer').attr('src'));
                $.ajax({
                    url: '/ajax/removecallrecording',
                    type: 'POST',
                    data: {
                        "filename": $('#audioPlayer').attr('src'),
                        "_token": $("meta[name='csrf-token']").attr("content"),
                    },
                    success: function (data){
                        console.log(data.status);
                    },
                });
            })
        })
    </script>

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
        function extensionGateway() {
            Swal.fire({
                title: '{{ __('messages.sweetalert.57') }}',
                text: '{{ __('messages.sweetalert.58') }}',
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
        const SMSCalculator = {
            // Encoding
            encoding: {
                UTF16: [70, 64, 67],
                GSM_7BIT: [160, 146, 153],
                GSM_7BIT_EX: [160, 146, 153],
            },

            // Charset
            charset: {
                gsmEscaped: '\\^{}\\\\\\[~\\]|€',
                gsm: '@£$¥èéùìòÇ\\nØø\\rÅåΔ_ΦΓΛΩΠΨΣΘΞÆæßÉ !"#¤%&\'()*+,-./0123456789:;<=>?¡ABCDEFGHIJKLMNOPQRSTUVWXYZÄÖÑÜ§¿abcdefghijklmnopqrstuvwxyzäöñüà',
            },

            // Regular Expression
            regex: function() {
                return {
                    gsm: RegExp(`^[${this.charset.gsm}]*$`),
                    gsmEscaped: RegExp(`^[\\${this.charset.gsmEscaped}]*$`),
                    gsmFull: RegExp(`^[${this.charset.gsm}${this.charset.gsmEscaped}]*$`),
                };
            },

            // Method
            detectEncoding: function(text) {
                if (text.match(this.regex().gsm)) {
                    return this.encoding.GSM_7BIT;
                } else if (text.match(this.regex().gsmFull)) {
                    return this.encoding.GSM_7BIT_EX;
                } else {
                    return this.encoding.UTF16;
                }
            },
            getEscapedCharCount: function(text) {
                return [...text].reduce((acc, char) => acc + (char.match(this.regex().gsmEscaped) ? 1 : 0), 0);
            },
            getPartData: function(totalLength, encoding) {
                let maxCharCount = encoding[2];
                let numberOfSMS = Math.ceil(totalLength / maxCharCount);
                let remaining = maxCharCount - (totalLength - (encoding[0] + encoding[1] + (encoding[2] * (numberOfSMS - 3))));

                if (totalLength <= encoding[0]) {
                    maxCharCount = encoding[0];
                    numberOfSMS = 1;
                    remaining = maxCharCount - totalLength;
                } else if (totalLength > encoding[0] && totalLength <= (encoding[0] + encoding[1])) {
                    maxCharCount = encoding[1];
                    numberOfSMS = 2;
                    remaining = maxCharCount - (totalLength - encoding[0]);
                }

                return {
                    maxCharCount,
                    numberOfSMS,
                    remaining,
                    totalLength,
                };
            },
            getCount: function(text) {
                let length = text.length;
                const encoding = this.detectEncoding(text);

                if (encoding === this.encoding.GSM_7BIT_EX) {
                    length += this.getEscapedCharCount(text);
                }

                return this.getPartData(length, encoding);
            },
        };

        let value = '';

        const calculate = () => {
            const count = SMSCalculator.getCount(value);

            document.getElementById('sms-count').innerText = `${count.remaining} / ${count.numberOfSMS}`;
            $('#input-sms_credit_count').val(count.numberOfSMS);
        };

        setInterval(() => {
            const area = document.getElementById('input-sms_content');

            if (value !== area.value) {
                value = area.value;
                calculate();
            }

        }, 100);

        calculate();
    </script>
@endsection

@section('PageModals')
    <div class="modal fade" tabindex="-1" id="indexDataModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="padding: 0.75rem 1.75rem;">
                    <h5 class="modal-title">{{ __('messages.call_orders.detail.modal.01') }}</h5>
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <span class="svg-icon svg-icon-2x"></span>
                    </div>
                </div>

                <div class="modal-body" style="padding: 0.75rem 1.75rem;" id="modalData">
                    <li class="d-flex align-items-center py-2">
                        <span class="bullet bg-success me-5"></span> <strong>{{ __('messages.call_orders.detail.modal.02') }}: </strong> <span class="ms-2" id="modalData_01"></span>
                    </li>
                    <li class="d-flex align-items-center py-2">
                        <span class="bullet bg-success me-5"></span> <strong>{{ __('messages.call_orders.detail.modal.03') }}: </strong> <span class="ms-2" id="modalData_02"></span>
                    </li>
                    <li class="d-flex align-items-center py-2">
                        <span class="bullet bg-success me-5"></span> <strong>{{ __('messages.call_orders.detail.modal.04') }}: </strong> <span class="ms-2" id="modalData_03"></span>
                    </li>
                    <li class="d-flex align-items-center py-2">
                        <span class="bullet bg-success me-5"></span> <strong>{{ __('messages.call_orders.detail.modal.05') }}: </strong> <span class="ms-2" id="modalData_04"></span>
                    </li>
                </div>

                <div class="modal-footer" style="padding: 0.75rem 1.75rem;">
                    <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">{{ __('messages.modal.01') }}</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" tabindex="-1" id="audioListenModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="padding: 0.75rem 1.75rem;">
                    <h5 class="modal-title">{{ __('messages.call_orders.detail.modal.06') }}</h5>
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <span class="svg-icon svg-icon-2x"></span>
                    </div>
                </div>

                <div class="modal-body" style="padding: 0.75rem 1.75rem;" id="modalData">
                    <audio id="audioPlayer" style="width: 100%" controls></audio>
                </div>

                <div class="modal-footer" style="padding: 0.75rem 1.75rem;">
                    <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">{{ __('messages.modal.01') }}</button>
                </div>
            </div>
        </div>
    </div>
@endsection
