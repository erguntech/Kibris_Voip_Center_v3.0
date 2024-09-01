@extends('layouts.application.layout_application')
@section('PageTitle', __('messages.data_distribution.index.01'))

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
    <div class="row g-5 g-xl-8 mb-4">
        <div class="col-xl-12">
            <div class="alert alert-info d-flex align-items-center p-5">
                <i class="ki-duotone ki-shield-tick fs-2hx text-info me-4"><span class="path1"></span><span class="path2"></span></i>
                <div class="d-flex flex-column">
                    <h4 class="mb-1">@ {{ __('messages.company_details.alert.01') }}</h4>
                    <span>- {{ __('messages.company_details.alert.02') }}</span>
                </div>
            </div>

            @if (session('result'))
                @include('components.alert', $data = ['alert_type' => session('result'), 'alert_title' => session('title'), 'alert_content' => session('content')])
            @endif

            <div class="card shadow-sm">
                <div class="card-header ribbon ribbon-start ribbon-clip">
                    <div class="ribbon-label bg-success fs-6" style="padding: 10px 15px;"><span class="d-flex text-white fw-bolder fs-6">{{ __('messages.data_distribution.index.02') }}</span></div>
                    <h3 class="card-title"></h3>
                    <div class="card-toolbar"></div>
                </div>

                <div class="card-body">
                    <form enctype="multipart/form-data" autocomplete="off">
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                <label for="input-distribution_style" class="required form-label">{{ __('messages.data_distribution.form.01') }}</label>
                                <select class="form-select @error('input-distribution_style') is-invalid error-input @enderror" name="input-distribution_style" id="input-distribution_style" data-control="select2" data-placeholder="{{ __('messages.forms.06') }}" data-hide-search="true">
                                    <option></option>
                                    <option value="1" {{ old('input-distribution_style') == '1' ? 'selected' : '' }}>{{ __('messages.data_distribution.form.01.01') }}</option>
                                </select>
                                @if ($errors->has('input-distribution_style'))
                                    <div class="invalid-feedback">
                                        @ {{ $errors->first('input-distribution_style') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </form>
                    <div class="separator border-2 my-10"></div>
                    <button type="button" class="btn btn-success btn-sm" onclick="assignCallCenterClients(this)">
                        <span class="indicator-label">{{ __('messages.forms.02') }}</span>
                        <span class="indicator-progress">{{ __('messages.forms.03') }} <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>
                </div>
            </div>
        </div>

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
    <script type="text/javascript">
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

    <script type="text/javascript">
        function assignCallCenterClients(btn) {
            if('{{ $employees->count() > 0 }}') {
                if(($('#input-distribution_style').val() == "") ) {
                    Swal.fire({
                        title: '{{ __('messages.sweetalert.46') }}',
                        text: '{{ __('messages.sweetalert.47') }}',
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
                } else if($('#input-distribution_style').val() == "1") {
                    Swal.fire({
                        title: '{{ __('messages.sweetalert.48') }}',
                        html: '<strong class="text-warning">{{ __('messages.sweetalert.50') }}:</strong> '+ $("#datatable").DataTable().rows().count() +'<br><strong class="text-primary">{{ __('messages.sweetalert.51') }}: </strong>'+ '{{ $employees->count() }}' +'<br><strong class="text-success">{{ __('messages.sweetalert.52') }}: </strong>'+ Math.ceil($("#datatable").DataTable().rows().count() / parseInt('{{ $employees->count() }}')) +'<br><br>{{ __('messages.sweetalert.13') }}',
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
                                url: '/ajax/datadistribution',
                                type: 'POST',
                                data: {
                                    "clientID": '{{ $client->id }}',
                                    "_token": $("meta[name='csrf-token']").attr("content"),
                                },
                                success: function (data){
                                    Swal.fire({
                                        icon: 'success',
                                        title: '{{ __('messages.sweetalert.53') }}',
                                        text: '{{ __('messages.sweetalert.54') }}',
                                        confirmButtonText: '{{ __('messages.sweetalert.05') }}',
                                        allowOutsideClick: false,
                                        customClass: {
                                            confirmButton: 'btn btn-success',
                                            title: 'text-white'
                                        }
                                    }).then(function (result) {
                                        $('#input-distribution_style').val(null).trigger('change');
                                        dtReset();
                                    })
                                },
                            });
                        }
                    });
                }
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
