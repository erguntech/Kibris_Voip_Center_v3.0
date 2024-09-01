@extends('layouts.application.layout_application')
@section('PageTitle', __('messages.sandbox.issabel.01'))

@section('PageVendorCSS')

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

@endsection

@section('PageVendorJS')
    <script src="{{ asset('assets/plugins/custom/easytimer/easytimer.js') }}"></script>
    <script src="{{ asset('assets/plugins/custom/sipJS/sip-0.21.2.js') }}"></script>
@endsection

@section('PageCustomJS')

@endsection

@section('PageModals')

@endsection
