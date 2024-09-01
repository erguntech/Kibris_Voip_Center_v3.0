@extends('layouts.application.layout_application')
@section('PageTitle', __('messages.contact.index.01'))

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
            <div class="alert alert-info d-flex align-items-center p-5">
                <i class="ki-duotone ki-shield-tick fs-2hx text-info me-4"><span class="path1"></span><span class="path2"></span></i>
                <div class="d-flex flex-column">
                    <h4 class="mb-1">@ {{ __('messages.contact.alert.01') }}</h4>
                    <span>- {{ __('messages.contact.alert.02') }}</span>
                </div>
            </div>

            @if (session('result'))
                @include('components.alert', $data = ['alert_type' => session('result'), 'alert_title' => session('title'), 'alert_content' => session('content')])
            @endif

            <div class="card shadow-sm">
                <div class="card-header ribbon ribbon-start ribbon-clip">
                    <div class="ribbon-label bg-success fs-6" style="padding: 10px 15px;"><span class="d-flex text-white fw-bolder fs-6">{{ __('messages.contact.index.09') }}</span></div>
                    <h3 class="card-title"></h3>
                    <div class="card-toolbar"></div>
                </div>

                <div class="card-body">
                    <form action="{{ route('Contact.SendMessage') }}" id="createForm" enctype="multipart/form-data" method="POST" autocomplete="off">
                        @csrf
                        @method('POST')
                        <div class="row">
                            <div class="col-12">
                                <label for="input-message_content" class="required form-label">{{ __('messages.contact.form.01') }}</label>
                                <textarea name="input-message_content" id="input-message_content" class="form-control @error('input-message_content') is-invalid error-input @enderror" rows="4" placeholder="{{ __('messages.contact.form.01') }} {{ __('messages.forms.01') }}"></textarea>
                                @if ($errors->has('input-message_content'))
                                    <div class="invalid-feedback">
                                        @ {{ $errors->first('input-message_content') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </form>
                    <div class="separator border-2 my-10"></div>

                    <button type="button" class="btn btn-success btn-sm" onclick="formSubmit(this)">
                        <span class="indicator-label">{{ __('messages.contact.form.02') }}</span>
                        <span class="indicator-progress">{{ __('messages.forms.03') }} <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>
                </div>
            </div>
        </div>

    </div>
    <div class="row g-5 g-xl-8">
        <!--begin::Col-->
        <div class="col-md-12 col-xl-4">
            <!--begin::Card-->
            <div class="card shadow-sm">
                <!--begin::Card header-->
                <div class="card-header border-0 pt-9">
                    <!--begin::Card Title-->
                    <div class="card-title m-0">
                        <!--begin::Avatar-->
                        <div class="symbol symbol-75px w-75px bg-light" style="background-color: #16cb47 !important;">
                            <img src="assets/media/svg/brand-logos/whatsapp.svg" alt="image" class="p-3" />
                        </div>
                        <!--end::Avatar-->
                    </div>
                    <!--end::Car Title-->
                    <!--begin::Card toolbar-->
                    <div class="card-toolbar">
                        <span class="badge badge-light-success fw-bold me-auto px-4 py-3">{{ __('messages.contact.index.02') }}</span>
                    </div>
                    <!--end::Card toolbar-->
                </div>
                <!--end:: Card header-->
                <!--begin:: Card body-->
                <div class="card-body p-9">
                    <!--begin::Name-->
                    <div class="fs-3 fw-bold text-gray-900">{{ __('messages.contact.index.03') }}</div>
                    <!--end::Name-->
                    <!--begin::Description-->
                    <p class="text-gray-500 fw-semibold fs-5 mt-1 mb-7">{{ Settings::get('app_whatsapp_contact') }}</p>
                    <!--end::Description-->
                    <!--begin::Progress-->
                    <div class="h-4px w-100 bg-light mb-5">
                        <div class="rounded h-4px" role="progressbar" style="width: 100%; background-color: #0e7732;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <!--end::Progress-->
                    <!--begin::Progress-->
                    <div>
                        <a href="https://wa.me/{{ Settings::get('app_whatsapp_contact') }}">
                            <button type="button" class="btn btn-primary btn-sm">{{ __('messages.contact.index.04') }}</button>
                        </a>
                    </div>
                    <!--end::Progress-->
                </div>
                <!--end:: Card body-->
            </div>
            <!--end::Card-->
        </div>
        <!--end::Col-->
        <!--begin::Col-->
        <div class="col-md-12 col-xl-4">
            <!--begin::Card-->
            <div class="card shadow-sm">
                <!--begin::Card header-->
                <div class="card-header border-0 pt-9">
                    <!--begin::Card Title-->
                    <div class="card-title m-0">
                        <!--begin::Avatar-->
                        <div class="symbol symbol-75px w-75px bg-light" style="background-color: #3f9bd4 !important;">
                            <img src="assets/media/svg/brand-logos/telegram.svg" alt="image" class="p-3" />
                        </div>
                        <!--end::Avatar-->
                    </div>
                    <!--end::Car Title-->
                    <!--begin::Card toolbar-->
                    <div class="card-toolbar">
                        <span class="badge badge-light-success fw-bold me-auto px-4 py-3">{{ __('messages.contact.index.02') }}</span>
                    </div>
                    <!--end::Card toolbar-->
                </div>
                <!--end:: Card header-->
                <!--begin:: Card body-->
                <div class="card-body p-9">
                    <!--begin::Name-->
                    <div class="fs-3 fw-bold text-gray-900">{{ __('messages.contact.index.05') }}</div>
                    <!--end::Name-->
                    <!--begin::Description-->
                    <p class="text-gray-500 fw-semibold fs-5 mt-1 mb-7">{{ Settings::get('app_telegram_contact') }}</p>
                    <!--end::Description-->
                    <!--begin::Progress-->
                    <div class="h-4px w-100 bg-light mb-5">
                        <div class="rounded h-4px" role="progressbar" style="width: 100%; background-color: #3f9bd4;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <!--end::Progress-->
                    <!--begin::Progress-->
                    <div>
                        <button type="button" class="btn btn-primary btn-sm">{{ __('messages.contact.index.04') }}</button>
                    </div>
                    <!--end::Progress-->
                </div>
                <!--end:: Card body-->
            </div>
            <!--end::Card-->
        </div>
        <!--end::Col-->
        <!--begin::Col-->
        <div class="col-md-12 col-xl-4">
            <!--begin::Card-->
            <div class="card shadow-sm">
                <!--begin::Card header-->
                <div class="card-header border-0 pt-9">
                    <!--begin::Card Title-->
                    <div class="card-title m-0">
                        <!--begin::Avatar-->
                        <div class="symbol symbol-75px w-75px bg-light" style="background-color: #11ade3 !important;">
                            <img src="assets/media/svg/brand-logos/skype.svg" alt="image" class="p-3" />
                        </div>
                        <!--end::Avatar-->
                    </div>
                    <!--end::Car Title-->
                    <!--begin::Card toolbar-->
                    <div class="card-toolbar">
                        <span class="badge badge-light-success fw-bold me-auto px-4 py-3">{{ __('messages.contact.index.02') }}</span>
                    </div>
                    <!--end::Card toolbar-->
                </div>
                <!--end:: Card header-->
                <!--begin:: Card body-->
                <div class="card-body p-9">
                    <!--begin::Name-->
                    <div class="fs-3 fw-bold text-gray-900">{{ __('messages.contact.index.07') }}</div>
                    <!--end::Name-->
                    <!--begin::Description-->
                    <p class="text-gray-500 fw-semibold fs-5 mt-1 mb-7">{{ Settings::get('app_skype_contact') }}</p>
                    <!--end::Description-->
                    <!--begin::Progress-->
                    <div class="h-4px w-100 bg-light mb-6">
                        <div class="rounded h-4px" role="progressbar" style="width: 100%; background-color: #11ade3;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <!--end::Progress-->
                    <!--begin::Progress-->
                    <div>
                        <button type="button" class="btn btn-primary btn-sm">{{ __('messages.contact.index.04') }}</button>
                    </div>
                    <!--end::Progress-->
                </div>
                <!--end:: Card body-->
            </div>
            <!--end::Card-->
        </div>
        <!--end::Col-->
    </div>
@endsection

@section('PageVendorJS')

@endsection

@section('PageCustomJS')
    <script type="text/javascript">
        function formSubmit(submitBtn) {
            Swal.fire({
                title: '{{ __('messages.sweetalert.55') }}',
                text: '{{ __('messages.sweetalert.56') }}',
                icon: 'error',
                showCancelButton: true,
                allowOutsideClick: false,
                confirmButtonText: '{{ __('messages.sweetalert.03') }}!',
                cancelButtonText: '{{ __('messages.sweetalert.04') }}',
                customClass: {
                    confirmButton: 'btn btn-danger',
                    cancelButton: 'btn btn-warning ml-1',
                    title: 'text-white'
                },
                buttonsStyling: false
            }).then(function (result) {
                submitBtn.setAttribute("data-kt-indicator", "on");
                $("#createForm").submit();
            });
        }
    </script>
@endsection

@section('PageModals')

@endsection
