@extends('layouts.application.layout_application')
@section('PageTitle', __('messages.dashboard.administration.01'))

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
    <a href="#" class="btn btn-outline btn-outline-dashed btn-outline-danger btn-active-light-danger" style="width: 100%;" onclick="excelExport()">Fuck Excel, Fuck Microsoft!</a>
@endsection

@section('PageVendorJS')

@endsection

@section('PageCustomJS')
    <script>
        function excelExport(id) {
            var token = $("meta[name='csrf-token']").attr("content");
            var route = "/sandbox/excelexport";

            $.ajax({
                url: route,
                type: 'POST',
                data: {
                    "id": id,
                    "_token": token,
                },
                success: function (data){
                    console.log(data);
                }
            });
        }
    </script>
@endsection

@section('PageModals')

@endsection
