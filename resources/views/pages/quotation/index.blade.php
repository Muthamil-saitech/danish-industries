@extends('layouts.app')
@section('content')
    <?php
    $baseURL = getBaseURL();
    $setting = getSettingsInfo();
    $base_color = '#6ab04c';
    if (isset($setting->base_color) && $setting->base_color) {
        $base_color = $setting->base_color;
    }
    ?>
    <section class="main-content-wrapper">
        @include('utilities.messages')
        <section class="content-header">
            <div class="row">
                <div class="col-md-6">
                    <h2 class="top-left-header">{{ isset($title) && $title ? $title : '' }}</h2>
                    <input type="hidden" class="datatable_name" data-filter="yes" data-title="{{ isset($title) && $title ? $title : '' }}"
                        data-id_name="datatable">
                </div>
                <div class="col-md-offset-4 col-md-2">

                </div>
            </div>
        </section>
        <div class="box-wrapper">
            <div class="table-box">
                <!-- /.box-header -->
                <div class="table-responsive">
                    <table id="datatable" class="table table-striped">
                        <thead>
                            <tr>
                                <th class="width_1_p">@lang('index.sn')</th>
                                <th class="width_10_p">@lang('index.challan_date')</th>
                                <th class="width_10_p">@lang('index.challan_no')</th>
                                <th class="width_10_p">@lang('index.doc_no')</th>
                                <th class="width_10_p">@lang('index.customer')</th>
                                {{-- <th class="width_10_p">@lang('index.subtotal')</th> --}}
                                {{-- <th class="width_10_p">@lang('index.other')</th> --}}
                                {{-- <th class="width_10_p">@lang('index.discount')</th> --}}
                                {{-- <th class="width_10_p">@lang('index.grand_total')</th> --}}
                                <th class="width_10_p">@lang('index.status')</th>
                                <th class="width_1_p">@lang('index.actions')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($obj && !empty($obj))
                                <?php
                                $i = 1;
                                ?>
                            @endif
                            @foreach ($obj as $value)
                                <tr>
                                    <td class="c_center">{{ $i++ }}</td>
                                    <td>{{ getDateFormat($value->challan_date) }}</td>
                                    <td>{{ $value->challan_no }}</td>
                                    <td>{{ $value->material_doc_no }}</td>
                                    <td>{{ getCustomerNameById($value->customer_id) }}</td>
                                    {{-- <td>{{ getCurrency($value->subtotal) }}</td> --}}
                                    {{-- <td>{{ getCurrency($value->other) }}</td> --}}
                                    {{-- <td>-{{ $value->discount != null ? getCurrency($value->discount) : 0 }}</td> --}}
                                    {{-- <td>{{ getCurrency($value->grand_total) }}</td> --}}
                                    <td>
                                        <select name="challan_status" class="form-control select2 challan-status" data-id="{{ $value->id }}" {{ in_array($value->challan_status, ["3"]) ? 'disabled' : '' }} style="width: 100px;">
                                            <option value="1" {{ $value->challan_status == "1" ? 'selected' : '' }}{{ $value->challan_status =="2" ? "disabled" : "" }}>Pending</option>
                                            <option value="2" {{ $value->challan_status == "2" ? 'selected' : '' }}>Progress</option>
                                            <option value="3" {{ $value->challan_status == "3" ? 'selected' : '' }}>Verified</option>
                                        </select>
                                        <div class="challan-status-msg"></div>
                                    </td>
                                    <td>
                                        <div class="d-flex items-start justify-start" id="dc_qc_msg">
                                            @if($value->challan_status!="3")
                                            <button id="dc_qc_add" data-bs-toggle="modal" data-challan_id="{{ $value->id }}" data-bs-target="#dcQcScheduling" class="btn bg-blue-btn w-20" title="QC Check" type="button"><i class="fa fa-list-check"></i></button>&nbsp;
                                            @endif
                                            <button id="dc_qc_view" data-bs-toggle="modal" data-challan_id="{{ $value->id }}" data-bs-target="#dcQcView" class="btn bg-blue-btn w-20" title="QC Assignment History" type="button"><i class="fa fa-user"></i></button>&nbsp;
                                            <a href="{{ url('quotation') }}/{{ encrypt_decrypt($value->id, 'encrypt') }}" class="button-info" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('index.view_details')"><i class="fa fa-eye"></i></a>
                                            @if (routePermission('quotations.edit') && $value->challan_status!="3")
                                                <a href="{{ url('quotation') }}/{{ encrypt_decrypt($value->id, 'encrypt') }}/edit" class="button-success" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('index.edit')"><i class="fa fa-edit"></i></a>
                                            @endif
                                            {{-- <a href="{{ route('download-quotation', encrypt_decrypt($value->id, 'encrypt')) }}" class="button-info"
                                                data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('index.download')"><i
                                                    class="fa fa-download"></i></a> --}}
                                            @if (routePermission('quotations.delete') && $value->challan_status!="3")
                                                <a href="#" class="delete button-danger"
                                                    data-form_class="alertDelete{{ $value->id }}" type="submit"
                                                    data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('index.delete')">
                                                    <form action="{{ route('quotation.destroy', $value->id) }}"
                                                        class="alertDelete{{ $value->id }}" method="post">
                                                        @csrf
                                                        @method('DELETE')
                                                        <i class="c_padding_13 fa fa-trash tiny-icon"></i>
                                                    </form>
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
    </section>
    <div class="modal fade" id="dcQcScheduling" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">@lang('index.qc')</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i data-feather="x"></i></span>
                    </button>
                </div>
                <form id="dc_qc_form">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12 mb-2 col-md-4">
                                <div class="form-group">
                                    <label>@lang('index.assign_to') <span class="required_star">*</span></label>
                                    <select class="form-control @error('qc_user_id') is-invalid @enderror select2"
                                        name="qc_user_id" id="qc_user_id">
                                        <option value="">@lang('index.select')</option>
                                        @if (isset($qc_employees) && $qc_employees)
                                            @foreach ($qc_employees as $emp)
                                                <option value="{{ $emp->id }}">
                                                    {{ $emp->name }}({{ $emp->emp_code }})</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <p class="text-danger qc_user_error"></p>
                                </div>
                            </div>
                            <div class="col-sm-12 mb-2 col-md-4">
                                <div class="form-group">
                                    <label>@lang('index.start_date') <span class="required_star">*</span></label>
                                    <input type="text" name="start_date"
                                        class="form-control @error('title') is-invalid @enderror"
                                        id="qc_start_date" placeholder="Start Date">
                                    <p class="text-danger start_date_error"></p>
                                </div>
                            </div>
                            <div class="col-sm-12 mb-2 col-md-4">
                                <div class="form-group">
                                    <label>@lang('index.complete_date') <span class="required_star">*</span></label>
                                    <input type="text" name="complete_date"
                                        class="form-control @error('title') is-invalid @enderror"
                                        id="qc_complete_date" placeholder="Complete Date">
                                    <p class="text-danger end_date_error"></p>
                                </div>
                            </div>
                            <div class="col-sm-12 mb-2 col-md-12">
                                <div class="form-group">
                                    <label>@lang('index.note') </label>
                                    <textarea name="qc_note" id="qc_note" class="form-control @error('note') is-invalid @enderror" placeholder="Note" maxlength="100"></textarea>
                                    <input type="hidden" name="challan_id" id="challan_id">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn bg-blue-btn dc_qc_scheduling_btn"><iconify-icon
                                icon="solar:check-circle-broken"></iconify-icon>
                            @lang('index.add')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="dcQcView" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">QC Assignment History</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i data-feather="x"></i></span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive" id="qc_dc_log_modal_body">

                    </div>
                </div>
                <input type="hidden" name="challan_id" id="qc_challan_id">
            </div>
        </div>
    </div>
    <div class="modal fade" id="filterModal" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">@lang('index.dc_list')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    {!! Form::model('', [
                        'id' => 'add_form',
                        'method' => 'GET',
                        'enctype' => 'multipart/form-data',
                        'route' => ['quotation.index'],
                    ]) !!}
                    @csrf
                    <div class="row">
                        <div class="col-sm-6 mb-3">
                            <div class="form-group">
                                {!! Form::text('startDate', (isset($startDate)&&$startDate!='') ? date('d-m-Y',strtotime($startDate)) : '', ['class' => 'form-control', 'readonly'=>"", 'placeholder'=>"Start Date", 'id' => 'quote_start_date']) !!}
                            </div>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <div class="form-group">
                                {!! Form::text('endDate', (isset($endDate)&&$endDate!='') ? date('d-m-Y',strtotime($endDate)) : '', ['class' => 'form-control', 'readonly'=>"", 'placeholder'=>"End Date", 'id' => 'quote_complete_date']) !!}
                            </div>
                        </div>
                        <div class="col-md-12 mb-2">
                            <div class="form-group">
                                <label>@lang('index.customer') </label>
                                <select name="customer_id" id="customer_id" class="form-control select2">
                                    <option value="">@lang('index.select')</option>
                                    @if(isset($customer_id))
                                        @foreach ($customers as $key => $value)
                                            <option value="{{ $value->id }}"
                                                {{ isset($customer_id) && $customer_id == $value->id ? 'selected' : '' }}>
                                                {{ $value->name }} ({{ $value->customer_id }})</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 mt-3">
                            <button type="submit" name="submit" value="submit"
                                class="btn w-100 bg-blue-btn">@lang('index.submit')</button>
                        </div>
                        <div class="col-md-4 mt-3">
                            <a href="{{ route('quotation.index') }}" style="text-decoration: none;color:white;"><button type="button" value="reset" class="btn bg-second-btn w-100">Reset</button></a>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
@push('top_script')
    <script type="text/javascript" src="{!! $baseURL . 'assets/bower_components/jquery-ui/jquery-ui.min.js' !!}"></script>
@endpush
@section('script')
    <script src="{!! $baseURL . 'assets/datatable_custom/jquery-3.3.1.js' !!}"></script>
    <script src="{!! $baseURL . 'assets/dataTable/jquery.dataTables.min.js' !!}"></script>
    <script src="{!! $baseURL . 'assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js' !!}"></script>
    <script src="{!! $baseURL . 'assets/dataTable/dataTables.bootstrap4.min.js' !!}"></script>
    <script src="{!! $baseURL . 'assets/dataTable/dataTables.buttons.min.js' !!}"></script>
    <script src="{!! $baseURL . 'assets/dataTable/buttons.html5.min.js' !!}"></script>
    <script src="{!! $baseURL . 'assets/dataTable/buttons.print.min.js' !!}"></script>
    <script src="{!! $baseURL . 'assets/dataTable/jszip.min.js' !!}"></script>
    <script src="{!! $baseURL . 'assets/dataTable/pdfmake.min.js' !!}"></script>
    <script src="{!! $baseURL . 'assets/dataTable/vfs_fonts.js' !!}"></script>
    <script src="{!! $baseURL . 'frequent_changing/newDesign/js/forTable.js' !!}"></script>
    <script src="{!! $baseURL . 'frequent_changing/js/custom_report.js' !!}"></script>
    <script>
        $("#qc_user_id").select2({
            dropdownParent: $("#dcQcScheduling"),
        });
        $("#customer_id").select2({
            dropdownParent: $("#filterModal"),
        });
        function parseDMYtoDate(dmy) {
            const [day, month, year] = dmy.split('-');
            return new Date(`${year}-${month}-${day}`);
        }
        $('#qc_start_date').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true,
            startDate: new Date()
        }).on('changeDate', function (e) {
            const startDate = e.date;
            $('#qc_complete_date').datepicker('setStartDate', startDate);
            const completeDateVal = $('#qc_complete_date').val();
            if (completeDateVal) {
                const completeDate = parseDMYtoDate(completeDateVal);
                if (completeDate < startDate) {
                    $('#qc_complete_date').datepicker('update', startDate);
                }
            }
        });
        $('#qc_complete_date').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true,
            startDate: new Date()
        }).on('changeDate', function (e) {
            const completeDate = e.date;
            const startDateVal = $('#qc_start_date').val();

            if (startDateVal) {
                const startDate = parseDMYtoDate(startDateVal);
                if (completeDate < startDate) {
                    $('#qc_complete_date').datepicker('update', startDate);
                }
            }
        });
        const existingQCStartDate = $('#qc_start_date').val();
        if (existingQCStartDate) {
            const startDate = parseDMYtoDate(existingQCStartDate);
            $('#qc_complete_date').datepicker('setStartDate', startDate);

            const completeDateVal = $('#qc_complete_date').val();
            if (completeDateVal && parseDMYtoDate(completeDateVal) < startDate) {
                $('#qc_complete_date').datepicker('update', startDate);
            }
        }
        $('#quote_start_date').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true,
        }).on('changeDate', function (e) {
            const startDate = e.date;
            $('#quote_complete_date').datepicker('setStartDate', startDate);
            const completeDateVal = $('#quote_complete_date').val();
            if (completeDateVal) {
                const completeDate = parseDMYtoDate(completeDateVal);
                if (completeDate < startDate) {
                    $('#quote_complete_date').datepicker('update', startDate);
                }
            }
        });
        $('#quote_complete_date').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true,
        }).on('changeDate', function (e) {
            const completeDate = e.date;
            const startDateVal = $('#quote_start_date').val();
            if (startDateVal) {
                const startDate = parseDMYtoDate(startDateVal);
                if (completeDate < startDate) {
                    $('#quote_complete_date').datepicker('update', startDate);
                }
            }
        });
        $(document).on("click", "#dc_qc_add", function (e) {
            let challan_id =  $(this).data('challan_id');
            $("#challan_id").val(challan_id);
        });
        $('.dc_qc_scheduling_btn').on('click', function (e) {
            e.preventDefault();
            $('.qc_user_error, .start_date_error, .end_date_error').text('');
            let qcUserId = $('#qc_user_id').val().trim();
            let startDate = $('#qc_start_date').val().trim();
            let completeDate = $('#qc_complete_date').val().trim();
            let challanId = $('#challan_id').val().trim();
            let qc_note = $('#qc_note').val().trim();
            let isValid = true;
            if (!qcUserId) {
                $('.qc_user_error').text('Assign To is Required.');
                isValid = false;
            }
            if (!startDate) {
                $('.start_date_error').text('Start date is Required.');
                isValid = false;
            }
            if (!completeDate) {
                $('.end_date_error').text('Complete date is Required.');
                isValid = false;
            }
            if (!isValid) {
                return;
            }
            let hidden_base_url = $("#hidden_base_url").val();
            $.ajax({
                type: "POST",
                url: hidden_base_url + "updateDcQcAssign",
                data: { "csrf-token": $("[name='csrf-token']").attr("content"), qc_user_id: qcUserId, start_date: startDate, complete_date: completeDate, challan_id: challanId, qc_note: qc_note },
                dataType: "json",
                success: function (response) {
                    const modalEl = document.getElementById('dcQcScheduling');
                    const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
                    modal.hide();
                    $("#dc_qc_msg").after('<p id="qc_response_msg" class="text-success mt-2">QC added successfully.</p>');
                    setTimeout(function () {
                        $('#qc_response_msg').fadeOut('slow', function () {
                            $(this).remove();
                        });
                    }, 3000);
                },
                error: function () {},
            });
        });
        $(document).on("click", "#dc_qc_view", function (e) {
            e.preventDefault();
            let hidden_base_url = $("#hidden_base_url").val();
            let challan_id =  $(this).data('challan_id');
            $("#qc_challan_id").val(challan_id);
            let qc_challan_id = $("#qc_challan_id").val();
            let requestData = {
                qc_challan_id: qc_challan_id ?? '',
            }
            $.ajax({
                type: "POST",
                url: hidden_base_url + "getDCQCAssignLog",
                data: requestData,
                dataType: "json",
                success: function (data) {
                    let table = '';
                    if (data.length === 0) {
                        table += '<tr><td colspan="4" class="text-center text-danger">No QC Assigned.</td></tr>';
                    } else {
                        table += '<div class="d-flex justify-content-between"><div class="d-flex flex-column align-items-start ms-2"><h5 class="modal-title">'+data[0].challan_no+'</h5><div><small>Challan No</small></div></div><div id="challan_sts_wrapper" class="form-check mb-1"><input class="form-check-input challan_status" type="checkbox" id="chl_status"'+(data[0].challan_status === 3 ? "checked disabled" : "" )+'><label class="form-check-label" for="chl_status">Verified</label><p class="text-success d-none" id="check-msg">Checked!</p></div></div><hr><table class="table table-bordered table-striped"><thead><tr><th>Employee Name</th><th>Start Date</th><th>Complete date</th><th>Note</th></tr></thead><tbody>';
                        for (let i = 0; i < data.length; i++) {
                            table +=
                                "<tr><td>" +
                                data[i].emp_name +
                                "</td><td>" +
                                data[i].start_date+
                                "</td><td>" +
                                data[i].end_date +
                                "</td><td>" +
                                data[i].note +
                                "</td></tr>";
                            table +=
                                '<input type="hidden" name="id[]" value="' +
                                data[i].id +
                                '">';
                        }
                    }
                    table += "</tbody></table>";
                    $("#qc_dc_log_modal_body").html(table);
                },
                error: function () {},
            });
        });
        $(document).on("change", ".challan_status", function (e) {
            const checkbox = this;
            let qc_challan_id = $("#qc_challan_id").val();
            $.ajax({
                type: "POST",
                url: $("#hidden_base_url").val() + "updateVerifiedStatus",
                data: { qc_challan_id: qc_challan_id, challan_status: '3' },
                dataType: "json",
                success: function (data) {
                    $(checkbox).prop('disabled', true).prop('checked', true);
                    $('#check-msg').removeClass('d-none').fadeIn();
                    setTimeout(() => {
                        $('#check-msg').fadeOut(() => {
                            $('#check-msg').addClass('d-none');
                            location.reload();
                        });
                    }, 3000);
                },
                error: function () {
                }
            });
        });
        $(document).on("change", ".challan-status", function (e) {
            let $this = $(this);
            let status = $this.val();
            let challan_id = $this.data("id");
            let $statusMsg = $this.closest('td').find('.challan-status-msg');
            $.ajax({
                type: "POST",
                url: $("#hidden_base_url").val() + "updateChallanStatus",
                data: { challan_id: challan_id, status: status },
                dataType: "json",
                success: function (data) {
                    $statusMsg.html('<span class="text-success">' + data.message + '</span>')
                        .delay(3000)
                        .fadeOut();
                    location.reload();
                },
                error: function () {
                    $statusMsg.html('<span class="text-danger">Something went wrong.</span>')
                        .delay(2000)
                        .fadeOut();
                }
            });
        });
    </script>
@endsection
