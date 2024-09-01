@extends('layouts.application.layout_application')
@section('PageTitle', __('messages.sms_credits.index.01'))

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

            @if (session('result'))
                @include('components.alert', $data = ['alert_type' => session('result'), 'alert_title' => session('title'), 'alert_content' => session('content')])
            @endif

            <div class="card shadow-sm">
                <div class="card-header ribbon ribbon-start ribbon-clip">
                    <div class="ribbon-label bg-success fs-6" style="padding: 10px 15px;"><span class="d-flex text-white fw-bolder fs-6">{{ __('messages.sms_credits.index.02') }}</span></div>
                    <h3 class="card-title"></h3>
                    <div class="card-toolbar"></div>
                </div>

                <div class="card-body">
                    <form autocomplete="off">
                        @csrf
                        <div class="row">
                            <div class="col-6">
                                <label for="input-client_id" class="required form-label">{{ __('messages.sms_credits.form.01') }}</label>
                                <select class="form-select @error('input-client_id') is-invalid error-input @enderror" name="input-client_id" id="input-client_id" data-control="select2" data-placeholder="{{ __('messages.forms.06') }}" data-hide-search="true">
                                    <option></option>
                                    @foreach($clientsSMSActive as $client)
                                        <option value="{{ $client->id }}" @if (old('input-client_id') == $client->id) selected="selected" @endif>{{ $client->company_name }} - {{ __('messages.sms_credits.form.03').$client->linkedClientModules->sms_credits }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('input-client_id'))
                                    <div class="invalid-feedback">
                                        @ {{ $errors->first('input-client_id') }}
                                    </div>
                                @endif
                            </div>
                            <div class="col-6">
                                <label for="input-credits_to_add" class="required form-label">{{ __('messages.sms_credits.form.02') }}</label>
                                <input type="text" name="input-credits_to_add" id="input-credits_to_add" class="form-control @error('input-credits_to_add') is-invalid error-input @enderror" placeholder="{{ __('messages.sms_credits.form.02') }} {{ __('messages.forms.01') }}" maxlength="150" value="{{ old('input-credits_to_add') }}"/>
                                @if ($errors->has('input-credits_to_add'))
                                    <div class="invalid-feedback">
                                        @ {{ $errors->first('input-credits_to_add') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="row mt-6">
                            <div class="col-12">
                                <label for="input-email" class="required form-label">{{ __('messages.service_fees.form.01') }}</label>
                                <input type="email" name="input-email" id="input-email" class="form-control" placeholder="{{ __('messages.service_fees.form.01') }} {{ __('messages.forms.01') }}" maxlength="50" value="{{ $smsServiceFee }}" disabled/>
                            </div>
                        </div>
                    </form>
                    <div class="separator border-2 my-10"></div>
                    <button type="button" class="btn btn-success btn-sm" onclick="assignCredits(this)">
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
                            <th>{{ __('messages.sms_credits.index.datatables.01') }}</th>
                            <th>{{ __('messages.sms_credits.index.datatables.02') }}</th>
                            <th>{{ __('messages.sms_credits.index.datatables.03') }}</th>
                            <th>{{ __('messages.sms_credits.index.datatables.04') }}</th>
                            <th>{{ __('messages.sms_credits.index.datatables.05') }}</th>
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
        var table, dt;
        var detailUrl = '{{ route("MyInvoices.Detail", ":id") }}';

        var initDatatable = function () {
            dt = $("#datatable").DataTable({
                searchDelay: 10000,
                processing: true,
                serverSide: false,
                order: [[0, 'desc']],
                autoWidth: false,
                responsive: false,
                pageLength: 5,
                aLengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "{{ __('messages.datatables.05') }}"]],
                fnCreatedRow: function( nRow, aData, iDataIndex ) {
                    $(nRow).children("td").css("white-space", "nowrap");
                },
                stateSave: false,
                pagingType: "simple_numbers",
                info: false,
                ajax: {
                    url : "{{ route('SMSCredits.Index') }}",
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
                    { data: 'companyName' },
                    { data: 'SMSDeviceName' },
                    { data: 'oldCredits' },
                    { data: 'creditsAdd' },
                    { data: 'totalCredits' },
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
                            return `<a class="btn btn-icon btn-light-primary" href="`+ detailUrl.replace(':id', row.id) +`" style="height: calc(2.05em);"><i class="fas fa-eye fs-5" style="margin-top: 1px;"></i></a>`;
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
        function assignCredits(btn) {
            if(($('#input-client_id').val() == "") || ($('#input-credits_to_add').val() == "")) {
                Swal.fire({
                    title: '{{ __('messages.sweetalert.23') }}',
                    text: '{{ __('messages.sweetalert.24') }}',
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
                    title: parseInt($('#input-credits_to_add').val()).toLocaleString('tr-TR') + ' {{ __('messages.sweetalert.25') }}',
                    text: '{{ __('messages.sweetalert.26') }}',
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
                            url: '/ajax/clientsmscredits',
                            type: 'POST',
                            data: {
                                "clientID": $('#input-client_id').val(),
                                "creditsToAdd": $('#input-credits_to_add').val(),
                                "_token": $("meta[name='csrf-token']").attr("content"),
                            },
                            success: function (data){
                                Swal.fire({
                                    icon: 'success',
                                    title: '{{ __('messages.sweetalert.27') }}',
                                    html: '<br>{{ __('messages.sweetalert.29') }} <br><br> <strong class="text-warning">{{ __('messages.sweetalert.33') }}:</strong> '+ data.oldCredits.toLocaleString('tr-TR') +'<br><strong class="text-primary">{{ __('messages.sweetalert.30') }}: </strong>'+ data.creditsX.toLocaleString('tr-TR') +'<br><strong class="text-success">{{ __('messages.sweetalert.31') }}: </strong>'+ data.totalCredits.toLocaleString('tr-TR') +'<br><br>{{ __('messages.sweetalert.13') }}',
                                    confirmButtonText: '{{ __('messages.sweetalert.05') }}',
                                    allowOutsideClick: false,
                                    customClass: {
                                        confirmButton: 'btn btn-success',
                                        title: 'text-white'
                                    }
                                }).then(function (result) {
                                    $('#input-client_id').val(null).trigger('change');
                                    $('#input-credits_to_add').val("");
                                    dtReset();
                                })
                            }, error: function (data){
                                console.log(data);
                            }
                        });
                    }
                });
            }
        }
    </script>
@endsection

@section('PageModals')

@endsection
