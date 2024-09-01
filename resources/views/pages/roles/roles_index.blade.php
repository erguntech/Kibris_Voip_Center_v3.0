@extends('layouts.application.layout_application')
@section('PageTitle', __('messages.roles.index.01'))

@section('PageVendorCSS')
    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css"/>
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
            <div class="card">
                <div class="card-header ribbon ribbon-start ribbon-clip">
                    <div class="ribbon-label bg-primary-active fs-6" style="padding: 10px 15px;"><span class="d-flex text-white fw-bolder fs-6">@yield('PageTitle') {{ __('messages.datatables.02') }}</span></div>
                    <h3 class="card-title"></h3>
                    <div class="card-toolbar">
                        <a href="{{ route('Roles.Create') }}" class="btn btn-light-success btn-icon btn-sm">
                            <i class="fas fa-plus"></i>
                        </a>
                        <a onclick="dtReset()" class="btn btn-icon btn-light-warning btn-sm ms-2">
                            <i class="fas fa-redo-alt fs-5"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row p-0">
                        <!--begin::Col-->
                        <div class="col">
                            <div class="border border-dashed border-gray-300 text-center min-w-125px rounded pt-4 pb-2">
                                <span class="fs-4 fw-semibold text-success d-block">{{ __('messages.roles.index.03') }}</span>
                                <span class="fs-2hx fw-bold text-gray-900" data-kt-countup="true" data-kt-countup-value="{{ $totalRoleCount }}">0</span>
                            </div>
                        </div>
                        <!--end::Col-->
                        <!--begin::Col-->
                        <div class="col">
                            <div class="border border-dashed border-gray-300 text-center min-w-125px rounded pt-4 pb-2">
                                <span class="fs-4 fw-semibold text-primary d-block">{{ __('messages.roles.index.04') }}</span>
                                <span class="fs-2hx fw-bold text-gray-900" data-kt-countup="true" data-kt-countup-value="{{ $activeRoleCount }}">0</span>
                            </div>
                        </div>
                        <!--end::Col-->
                    </div>

                    <div class="separator separator-dotted my-6"></div>

                    <div class="input-group mb-5">
                        <span class="input-group-text">{{ __('messages.datatables.01') }}</span>
                        <input type="text" id="table-search" class="form-control" placeholder="..."/>
                    </div>

                    <table id="datatable" class="table table-hover table-rounded table-row-bordered table-row-gray-200 gy-1 gs-10" style="min-height: 100%; width: 100% !important;">
                        <thead>
                        <tr class="fw-bolder fs-7 text-uppercase gy-5">
                            <th>{{ __('messages.datatables.03') }}</th>
                            <th>{{ __('messages.roles.index.datatables.01') }}</th>
                            <th>{{ __('messages.roles.index.datatables.02') }}</th>
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
@endsection

@section('PageCustomJS')
    <script>
        var table, dt;
        var editUrl = '{{ route("Roles.Edit", ":id") }}';

        var initDatatable = function () {
            dt = $("#datatable").DataTable({
                searchDelay: 10000,
                processing: true,
                serverSide: false,
                order: [[1, 'asc']],
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
                    url : "{{ route('Roles.Index') }}",
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
                    { data: 'name' },
                    { data: 'description' },
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
                            <a class="btn btn-icon btn-light-warning" href="`+ editUrl.replace(':id', row.id) +`" style="height: calc(2.05em);"><i class="fas fa-edit fs-5" style="margin-top: 1px;"></i></a>
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
            $("#datatable").DataTable().page.len(10).draw();
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
                        url: "roles/"+btn.getAttribute('data-id'),
                        type: 'DELETE',
                        data: {
                            "id": btn.getAttribute('data-id'),
                            "_token": $("meta[name='csrf-token']").attr("content"),
                        },
                        success: function (){
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
                        }
                    });
                }
            });
        }
    </script>
@endsection

@section('PageModals')

@endsection
