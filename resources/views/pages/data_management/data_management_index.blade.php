@extends('layouts.application.layout_application')
@section('PageTitle', __('messages.data_management.index.01'))

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
        .select2-container--open {
            z-index: 99999999999999;
        }
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
    <div class="alert alert-info d-flex align-items-center p-5 mb-6">
        <i class="ki-duotone ki-shield-tick fs-2hx text-info me-4"><span class="path1"></span><span class="path2"></span></i>
        <div class="d-flex flex-column">
            <h4 class="mb-1">@ {{ __('messages.data_management.alert.01') }}</h4>
            <span>- {{ __('messages.data_management.alert.02') }}</span>
        </div>
    </div>

    <div class="row g-5 g-xl-8 mb-6">
        <!--begin::Col-->
        <div class="col-xl-4">
            <!--begin::Lists Widget 19-->
            <div class="card card-flush h-xl-100">
                <!--begin::Heading-->
                <div class="card-header rounded bgi-no-repeat bgi-size-cover bgi-position-y-top bgi-position-x-center align-items-start h-100px" style="background-image:url({{ asset('assets/media/svg/shapes/abstract-2-dark.svg') }})" data-bs-theme="light">
                    <!--begin::Title-->
                    <h3 class="card-title align-items-start flex-column text-white pt-5">
                        <span class="card-label fw-bold text-primary mb-2">{{ Auth::user()->linkedClient->company_name }}</span>
                        <div class="fs-6">
                            <span class="text-warning">{{ __('messages.data_management.index.02') }}:</span>
                            <span class="position-relative d-inline-block">
							    <span class="fw-bold d-block mb-1 text-warning" id="totalDataCount">{{ $totalDataCount }}</span>
                            </span>
                        </div>
                    </h3>
                    <!--end::Title-->
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
                                        <span class="text-gray-700 fw-bolder d-block fs-2qx lh-1 ls-n1 mb-1" id="totalActiveDataCount">{{ $totalActiveDataCount }}</span>
                                        <!--end::Number-->
                                        <!--begin::Desc-->
                                        <span class="text-success fw-semibold fs-6">{{ __('messages.data_management.index.03') }}</span>
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
                                        <span class="text-gray-700 fw-bolder d-block fs-2qx lh-1 ls-n1 mb-1" id="totalPassiveDataCount">{{ $totalPassiveDataCount }}</span>
                                        <!--end::Number-->
                                        <!--begin::Desc-->
                                        <span class="text-danger fw-semibold fs-6">{{ __('messages.data_management.index.04') }}</span>
                                        <!--end::Desc-->
                                    </div>
                                    <!--end::Stats-->
                                </div>
                                <!--end::Items-->
                            </div>
                            <!--end::Col-->
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
        <div class="col-xl-8">
            <!--begin::Engage widget 4-->
            <div class="card h-xl-100 shadow-sm">
                <div class="card-header ribbon ribbon-start ribbon-clip">
                    <div class="ribbon-label bg-success fs-6" style="padding: 10px 15px;"><span class="d-flex text-white fw-bolder fs-6">{{ __('messages.data_management.index.05') }}</span></div>
                    <h3 class="card-title"></h3>
                    <div class="card-toolbar">
                        <a href="{{ route('DataManagement.DownloadExcelTemplate') }}" type="button" class="btn btn-sm btn-danger">
                            {{ __('messages.data_management.index.07') }}
                        </a>
                    </div>
                </div>
                <!--begin::Body-->
                <div class="card-body d-flex ps-xl-10">
                    <!--begin::Wrapper-->
                    <div class="m-0" style="width: 50%">
                        <!--begin::Title-->
                        <div class="position-relative z-index-2 card-label fw-bold text-primary mb-7">
                            <h4 class="mb-4"></h4>
                            <h6 class="mb-1">- {{ __('messages.data_management.index.05.01') }}</h6>
                            <h6 class="mb-1">- {{ __('messages.data_management.index.05.02') }}</h6>
                            <h6 class="mb-1">- {{ __('messages.data_management.index.05.03') }}</h6>
                        </div>
                        <!--end::Title-->
                        <div class="mb-3">
                            <input id="input-x" name="input-x" type="file">
                            <input type="hidden" id="csrf_token" name="_token" value="{{ csrf_token() }}">
                        </div>

                    </div>
                    <!--begin::Wrapper-->
                    <!--begin::Illustration-->
                    <img src="{{ asset('assets/media/illustrations/sigma-1/17-dark.png') }}" class="position-absolute me-3 bottom-0 end-0 h-200px" alt="" />
                    <!--end::Illustration-->
                </div>
                <!--end::Body-->
            </div>
            <!--end::Engage widget 4-->
        </div>
        <!--end::Col-->
    </div>
    <div class="row g-5 g-xl-8">
        <div class="col-xl-12">
            @if (session('result'))
                @include('components.alert', $data = ['alert_type' => session('result'), 'alert_title' => session('title'), 'alert_content' => session('content')])
            @endif
            <div class="card">
                <div class="card-header ribbon ribbon-start ribbon-clip">
                    <div class="ribbon-label bg-primary-active fs-6" style="padding: 10px 15px;"><span class="d-flex text-white fw-bolder fs-6">@yield('PageTitle') {{ __('messages.datatables.02') }}</span></div>
                    <h3 class="card-title"></h3>
                    <div class="card-toolbar">
                        <a href="{{ route('CallCenterClients.Create') }}" class="btn btn-light-success btn-icon btn-sm">
                            <i class="fas fa-plus"></i>
                        </a>
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
                            <th>{{ __('messages.call_center_clients.index.datatables.01') }}</th>
                            <th>{{ __('messages.call_center_clients.index.datatables.02') }}</th>
                            <th>{{ __('messages.call_center_clients.index.datatables.03') }}</th>
                            <th>{{ __('messages.call_center_clients.index.datatables.04') }}</th>
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
    <script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.0/js/plugins/buffer.min.js" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.0/js/plugins/filetype.min.js" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.0/js/plugins/piexif.min.js" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.0/js/plugins/sortable.min.js" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.0/js/fileinput.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.0/js/locales/tr.js"></script>
    <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
@endsection

@section('PageCustomJS')
    <script>
        $(document).ready(function() {
            $("#input-x").fileinput({
                rtl: false,
                language: 'tr',
                dropZoneEnabled: false,
                allowedFileExtensions: ["xlsx"],
                showPreview: false,
                contentType: "multipart/form-data",
                elErrorContainer: '#kartik-file-errors',
                uploadUrl: "/datamanagement/import",
                uploadAsync: false,
                uploadExtraData:{'_token': $('#csrf_token').val()},
            }).on('filebatchpreupload', function(event, data, id, index) {

            }).on('filebatchuploaderror', function(event, data, msg) {
                Swal.fire({
                    title: '{{ __('messages.sweetalert.44') }}',
                    html: '{!! __('messages.sweetalert.45') !!}',
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
            }).on('filebatchuploadsuccess', function(event, data) {
                $.ajax({
                    url: 'datamanagement/clientcount',
                    type: 'POST',
                    data: {
                        "_token": $("meta[name='csrf-token']").attr("content"),
                    },
                    success: function (data){
                        document.getElementById("totalDataCount").innerHTML = data.totalDataCount;
                        document.getElementById("totalActiveDataCount").innerHTML = data.totalActiveDataCount;
                        document.getElementById("totalPassiveDataCount").innerHTML = data.totalPassiveDataCount;
                    }, error: function (data){
                        console.log(data);
                    }
                });

                Swal.fire({
                    icon: 'success',
                    title: '{{ __('messages.alerts.01') }}',
                    text: data.response['recordCount'] + ' {{ __('messages.alerts.06') }}',
                    confirmButtonText: '{{ __('messages.sweetalert.05') }}',
                    allowOutsideClick: false,
                    customClass: {
                        confirmButton: 'btn btn-success',
                        title: 'text-white'
                    }
                }).then(function (result) {
                    dtReset();
                })
            });
        });
    </script>

    <script>
        var table, dt;
        var editUrl = '{{ route("CallCenterClients.Edit", ":id") }}';

        var initDatatable = function () {
            dt = $("#datatable").DataTable({
                searchDelay: 10000,
                processing: true,
                serverSide: false,
                order: [[1, 'asc']],
                autoWidth: false,
                responsive: false,
                pageLength: 5,
                aLengthMenu: [[5, 10, 25, 50, 100, -1], [5, 10, 25, 50, 100, "{{ __('messages.datatables.05') }}"]],
                fnCreatedRow: function( nRow, aData, iDataIndex ) {
                    $(nRow).children("td").css("white-space", "nowrap");
                },
                stateSave: false,
                pagingType: "simple_numbers",
                info: false,
                ajax: {
                    url : "{{ route('DataManagement.Index') }}",
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
                    { data: 'fullName' },
                    { data: 'companyName' },
                    { data: 'contactNo' },
                    { data: 'callStatus' },
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
                            return `
                            <a class="btn btn-icon btn-light-primary" onclick="assignData(this)" data-id="`+ row.id +`" style="height: calc(2.05em);"><i class="fas fa-share fs-5" style="margin-top: 2px;"></i></a>
                            <a class="btn btn-icon btn-light-danger" onclick="deleteData(this)" data-id="`+ row.id +`" style="height: calc(2.05em);"><i class="fas fa-trash-alt fs-5" style="margin-top: 2px;"></i></a>
                            `;
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
            $("#datatable").DataTable().page.len(5).draw();
            $("#datatable").DataTable().state.clear();
            $("#datatable").DataTable().ajax.reload();
        }
    </script>

    <script type="text/javascript">
        function deleteData(btn) {
            Swal.fire({
                title: '{{ __('messages.sweetalert.01') }}',
                text: '{{ __('messages.sweetalert.02') }}',
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
                if (result.value) {
                    $.ajax({
                        url: "callcenterclients/"+btn.getAttribute('data-id'),
                        type: 'DELETE',
                        data: {
                            "id": btn.getAttribute('data-id'),
                            "_token": $("meta[name='csrf-token']").attr("content"),
                        },
                        success: function (){
                            $.ajax({
                                url: 'datamanagement/clientcount',
                                type: 'POST',
                                data: {
                                    "_token": $("meta[name='csrf-token']").attr("content"),
                                },
                                success: function (data){
                                    document.getElementById("totalDataCount").innerHTML = data.totalDataCount;
                                    document.getElementById("totalActiveDataCount").innerHTML = data.totalActiveDataCount;
                                    document.getElementById("totalPassiveDataCount").innerHTML = data.totalPassiveDataCount;
                                }, error: function (data){
                                    console.log(data);
                                }
                            });
                            Swal.fire({
                                icon: 'success',
                                title: '{{ __('messages.alerts.01') }}',
                                text: '{{ __('messages.alerts.03') }}',
                                confirmButtonText: '{{ __('messages.sweetalert.05') }}',
                                allowOutsideClick: false,
                                customClass: {
                                    confirmButton: 'btn btn-success',
                                    title: 'text-white'
                                }
                            }).then(function (result) {
                                dtReset();
                            })
                        }, error: function (data) { console.log(data) }
                    });
                }
            });
        }
    </script>

    <script type="text/javascript">
        function assignData(btn) {
            if('{{ $employees->count() > 0 }}') {
                Swal.fire({
                    title: '{{ __('messages.sweetalert.10') }}',
                    html:`<select class="form-select" name="input-assigned_user_id" id="input-assigned_user_id" data-control="select2" data-placeholder="{{ __('messages.forms.06') }}">
                        <option></option>
                        @foreach($employees as $employee)
                            <option value="{{ $employee->id }}">{{ $employee->linkedUser->getUserFullName() }}</option>
                        @endforeach
                        </select>`,
                    icon: 'success',
                    showCancelButton: true,
                    allowOutsideClick: false,
                    confirmButtonText: '{{ __('messages.sweetalert.03') }}!',
                    cancelButtonText: '{{ __('messages.sweetalert.04') }}',
                    customClass: {
                        confirmButton: 'btn btn-danger',
                        cancelButton: 'btn btn-warning ml-1',
                        title: 'text-white'
                    },
                    buttonsStyling: false,
                    didOpen: function () {
                        $('[name="input-assigned_user_id"]').select2({
                            hideSearch : true
                        });
                    },
                }).then(function (result) {
                    if (result.value) {
                        $.ajax({
                            url: 'assigncallcenterclient',
                            type: 'POST',
                            data: {
                                "id": btn.getAttribute('data-id'),
                                "employeeID": $('#input-assigned_user_id').val(),
                                "_token": $("meta[name='csrf-token']").attr("content"),
                            },
                            success: function (data){
                                Swal.fire({
                                    icon: 'success',
                                    title: '{{ __('messages.alerts.01') }}',
                                    text: '{{ __('messages.alerts.07') }}',
                                    confirmButtonText: '{{ __('messages.sweetalert.05') }}',
                                    allowOutsideClick: false,
                                    customClass: {
                                        confirmButton: 'btn btn-success',
                                        title: 'text-white'
                                    }
                                }).then(function (result) {
                                    dtReset();
                                })
                            }
                        });
                    }
                });
            } else {
                Swal.fire({
                    title: '{{ __('messages.sweetalert.44') }}',
                    html: '{!! __('messages.sweetalert.45') !!}',
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
            }

        }
    </script>
@endsection

@section('PageModals')

@endsection
